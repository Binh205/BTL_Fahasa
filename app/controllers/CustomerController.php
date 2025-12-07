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
    
    /**
     * Trang đơn hàng của tôi
     */
    public function orders() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) && !isset($_SESSION['users_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit();
        }

        $userId = $_SESSION['user_id'] ?? $_SESSION['users_id'] ?? null;

        // Load Order model
        require_once APP_ROOT . '/models/Order.php';
        $orderModel = new Order();

        // Lấy danh sách đơn hàng
        $ordersData = $orderModel->getOrdersByUserId($userId, 20, 0);

        // Format data cho view
        $orders = [];
        foreach ($ordersData as $order) {
            // Lấy sản phẩm trong đơn hàng
            $items = $orderModel->getOrderProducts($order['order_id']);

            // Format items
            $formattedItems = [];
            foreach ($items as $item) {
                $formattedItems[] = [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['title'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'image' => $item['image_url'] ?? 'images/product-page/default.jpg',
                    'author' => $item['author'] ?? 'N/A'
                ];
            }

            // Map status text
            $statusMap = [
                'pending' => 'Chờ xử lý',
                'processing' => 'Đang xử lý',
                'shipped' => 'Đang giao',
                'completed' => 'Hoàn thành',
                'cancelled' => 'Đã hủy'
            ];

            $orders[] = [
                'order_id' => $order['order_id'],
                'order_date' => $order['created_at'],
                'status' => $order['status'],
                'status_text' => $statusMap[$order['status']] ?? $order['status'],
                'total' => $order['total_amount'],
                'shipping_fee' => $order['shipping_fee'],
                'subtotal' => $order['subtotal'],
                'payment_method' => $order['payment_method'],
                'shipping_address' => $order['shipping_address'],
                'note' => $order['note'],
                'items' => $formattedItems
            ];
        }

        $data = [
            'title' => 'Đơn hàng của tôi - ' . APP_NAME,
            'page' => 'customer',
            'orders' => $orders
        ];

        $this->view('customer/orders', $data);
    }

    // Orders (kept minimal) - require login in real app, but we'll show mock orders for guest
    /*public function orders() {
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
    }*/

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
                    'image'=> $r['image'] ?? 'images/product-page/default.jpg',
                    'price'=> $r['price'],
                    'original_price'=> $r['original_price'] ?? 0,
                    'author'=> $r['author'] ?? 'Chưa có thông tin',
                    'discount'=> (isset($r['original_price']) && $r['original_price']>$r['price']) ? round(100-($r['price']/$r['original_price']*100)) : 0
                ];
            }
        } else {
            // guest: use session list of product IDs
            $guest = $_SESSION['guest_wishlist'] ?? [];
            if (!empty($guest)) {
                // Sử dụng ProductModel để lấy sản phẩm
                if (method_exists($productModel, 'getProductsByIds')) {
                    $products = $productModel->getProductsByIds($guest);
                } else {
                    $products = [];
                }
                foreach ($products as $p) {
                    $list[] = [
                        'product_id' => $p['product_id'],
                        'product_name'=> $p['title'],
                        'image'=> $p['image_url'] ?? 'images/product-page/default.jpg',
                        'price'=> $p['price'],
                        'original_price'=> $p['old_price'] ?? 0,
                        'author'=> $p['author'] ?? 'Chưa có thông tin',
                        'discount'=> (isset($p['old_price']) && $p['old_price']>$p['price']) ? round(100-($p['price']/$p['old_price']*100)) : 0
                    ];
                }
            }
        }

        $data = [
            'title' => 'Sản phẩm yêu thích - ' . APP_NAME,
            'page' => 'customer',
            'wishlist' => $list
        ];

        $this->view('customer/wishlist', $data);
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
