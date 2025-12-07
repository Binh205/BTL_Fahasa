<?php
// app/controllers/CustomerController.php
class CustomerController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Tạm thời: cho phép guest (không ép login).
        // Nếu muốn kích hoạt lại yêu cầu login: uncomment redirect section dưới.
        /*
        if (!isset($_SESSION['users_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        */
    }

    // Profile page
    public function index() {
        // Nếu đã login -> lấy từ DB
        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $userModel = $this->model('UserModel');
            $user = $userModel->getById($_SESSION['users_id']);
            // Nếu model trả null, fallback vào session (edge case)
            if (!$user) $user = $_SESSION['guest_user'] ?? null;
        } else {
            // Guest: nếu chưa có guest_user trong session thì tạo mẫu để hiển thị/ sửa
            if (!isset($_SESSION['guest_user'])) {
                $_SESSION['guest_user'] = [
                    'user_id' => 0,
                    'username' => 'Khách',
                    'fullname' => '',
                    'email' => '',
                    'phone' => '',
                    'gender' => 'male',
                    'birthday' => '',
                    'address' => '',
                    'avatar' => null,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            $user = $_SESSION['guest_user'];
        }

        $data = ['user' => $user];
        $this->view('customer/index', $data);
    }

    // Update profile (AJAX POST) - if guest, save to session; if logged, save to DB
    public function updateProfile() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $payload = [
            'fullname' => trim($_POST['fullname'] ?? ''),
            'phone'    => trim($_POST['phone'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'gender'   => $_POST['gender'] ?? null,
            'birthday' => $_POST['birthday'] ?? null,
            'address'  => $_POST['address'] ?? null
        ];

        // If logged in -> update DB
        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $uid = $_SESSION['users_id'];
            $userModel = $this->model('UserModel');
            $ok = $userModel->updateProfile($uid, $payload);
            if ($ok) {
                // Update session username if used elsewhere
                $_SESSION['users_username'] = $payload['fullname'] ?: $_SESSION['users_username'];
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không cập nhật được vào DB']);
            }
            return;
        }

        // Guest: lưu vào session (không ghi DB)
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['guest_user'] = array_merge($_SESSION['guest_user'] ?? [], $payload);
        // đảm bảo created_at tồn tại
        if (!isset($_SESSION['guest_user']['created_at'])) $_SESSION['guest_user']['created_at'] = date('Y-m-d H:i:s');

        echo json_encode(['success' => true, 'guest' => true]);
    }

    // Orders (kept minimal) - require login in real app, but we'll show mock orders for guest
    public function orders() {
        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $orderModel = $this->model('OrderModel');
            $orders = $orderModel->getByUserId($_SESSION['users_id']);
            foreach ($orders as &$o) {
                $o['items'] = $orderModel->getItems($o['id']);
            }
        } else {
            // guest: show empty or mock orders (you can customize)
            $orders = []; // or keep mock data as before
        }
        $this->view('customer/orders', ['orders' => $orders]);
    }

    // Notifications
    public function notifications() {
        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $nm = $this->model('NotificationModel');
            $notes = $nm->getByUserId($_SESSION['users_id']);
        } else {
            // guest notifications: none (or mock)
            $notes = $_SESSION['guest_notifications'] ?? [];
        }
        $this->view('customer/notifications', ['notifications' => $notes]);
    }

    // Mark single notification read (AJAX)
    public function markNotificationRead() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success' => false]); return; }

        $nid = (int)($_POST['id'] ?? 0);
        if ($nid <= 0) { echo json_encode(['success' => false]); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $nm = $this->model('NotificationModel');
            $ok = $nm->markRead($nid, $_SESSION['users_id']);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // Guest: mark in session
        if (isset($_SESSION['guest_notifications']) && is_array($_SESSION['guest_notifications'])) {
            foreach ($_SESSION['guest_notifications'] as &$n) {
                if ((int)($n['id'] ?? 0) === $nid) {
                    $n['is_read'] = 1;
                    echo json_encode(['success' => true]);
                    return;
                }
            }
        }
        echo json_encode(['success' => false]);
    }

    // Mark all notifications read (AJAX)
    public function markAllNotificationsRead() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success' => false]); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $nm = $this->model('NotificationModel');
            $ok = $nm->markAllRead($_SESSION['users_id']);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // Guest
        if (isset($_SESSION['guest_notifications']) && is_array($_SESSION['guest_notifications'])) {
            foreach ($_SESSION['guest_notifications'] as &$n) $n['is_read'] = 1;
            echo json_encode(['success' => true]);
            return;
        }

        echo json_encode(['success' => false]);
    }

    // Wishlist page (reads DB for logged users, session for guests)
    public function wishlist() {
        $list = [];
        $productModel = $this->model('ProductModel');

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $wm = $this->model('WishlistModel');
            $rows = $wm->getByUserId($_SESSION['users_id']);
            foreach ($rows as $r) {
                $list[] = [
                    'product_id' => $r['product_id'],
                    'product_name'=> $r['product_name'],
                    'image'=> $r['image'],
                    'price'=> $r['price'],
                    'original_price'=> $r['original_price'],
                    'author'=> $r['author'] ?? '',
                    'rating'=> $r['rating'] ?? 0,
                    'sold'=> $r['sold'] ?? 0,
                    'discount'=> (isset($r['original_price']) && $r['original_price']>$r['price']) ? round(100-($r['price']/$r['original_price']*100)) : 0
                ];
            }
        } else {
            // guest: use session list of product IDs
            $guest = $_SESSION['guest_wishlist'] ?? [];
            if (!empty($guest)) {
                // assume productModel->getByIds exists; if not, fetch one by one
                if (method_exists($productModel, 'getByIds')) {
                    $products = $productModel->getByIds($guest);
                } else {
                    $products = [];
                    foreach ($guest as $pid) {
                        $p = $productModel->getById($pid);
                        if ($p) $products[] = $p;
                    }
                }
                foreach ($products as $p) {
                    $list[] = [
                        'product_id' => $p['id'] ?? $p['product_id'] ?? 0,
                        'product_name'=> $p['name'] ?? $p['product_name'] ?? '',
                        'image'=> $p['image'] ?? '',
                        'price'=> $p['price'] ?? 0,
                        'original_price'=> $p['old_price'] ?? ($p['original_price'] ?? 0),
                        'author'=> $p['author'] ?? '',
                        'rating'=> $p['rating'] ?? 0,
                        'sold'=> $p['sold'] ?? 0,
                        'discount'=> (isset($p['old_price']) && $p['old_price']>$p['price']) ? round(100-($p['price']/$p['old_price']*100)) : 0
                    ];
                }
            }
        }

        $this->view('customer/wishlist', ['wishlist' => $list]);
    }

    // API add wishlist (POST)
    public function addWishlist() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success'=>false,'message'=>'Method not allowed']); return; }
        $pid = (int)($_POST['product_id'] ?? 0);
        if ($pid <= 0) { echo json_encode(['success'=>false,'message'=>'Invalid product']); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $wm = $this->model('WishlistModel');
            $ok = $wm->add($_SESSION['users_id'], $pid);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // guest: add to session array
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['guest_wishlist']) || !is_array($_SESSION['guest_wishlist'])) $_SESSION['guest_wishlist'] = [];
        if (!in_array($pid, $_SESSION['guest_wishlist'])) $_SESSION['guest_wishlist'][] = $pid;
        $_SESSION['guest_wishlist'] = array_values(array_unique($_SESSION['guest_wishlist']));
        echo json_encode(['success'=>true, 'guest'=>true, 'count'=>count($_SESSION['guest_wishlist'])]);
    }

    // API remove wishlist (POST)
    public function removeWishlist() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['success'=>false,'message'=>'Method not allowed']); return; }
        $pid = (int)($_POST['product_id'] ?? 0);
        if ($pid <= 0) { echo json_encode(['success'=>false,'message'=>'Invalid product']); return; }

        if (isset($_SESSION['users_id']) && !empty($_SESSION['users_id'])) {
            $wm = $this->model('WishlistModel');
            $ok = $wm->remove($_SESSION['users_id'], $pid);
            echo json_encode(['success' => (bool)$ok]);
            return;
        }

        // guest: remove from session
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['guest_wishlist']) || !is_array($_SESSION['guest_wishlist'])) {
            echo json_encode(['success'=>false,'message'=>'Not found']); return;
        }
        $_SESSION['guest_wishlist'] = array_values(array_diff($_SESSION['guest_wishlist'], [$pid]));
        echo json_encode(['success'=>true, 'guest'=>true, 'count'=>count($_SESSION['guest_wishlist'])]);
    }
}
