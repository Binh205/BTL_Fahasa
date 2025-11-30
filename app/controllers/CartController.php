<?php
/**
 * CART CONTROLLER
 * Quản lý giỏ hàng và thanh toán
 */

class CartController extends Controller {

    public function __construct() {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Trang giỏ hàng
     */
    public function index() {
        // Xử lý khi người dùng nhấn "Mua ngay" từ trang chi tiết
        if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
            $this->addToCartFromBuyNow($_GET['product_id'], $_GET['quantity']);
            // Redirect về /cart (không có params) để tránh thêm lại khi reload
            header('Location: ' . BASE_URL . 'cart');
            exit;
        }

        // Lấy giỏ hàng từ session
        $cart = $_SESSION['cart'] ?? [];
        
        // Lấy thông tin chi tiết các sản phẩm trong giỏ
        $cartItems = $this->getCartItems($cart);
        
        // Tính tổng tiền
        $summary = $this->calculateCartSummary($cartItems);
        
        $data = [
            'title' => 'Giỏ hàng - ' . APP_NAME,
            'page' => 'cart',
            'cartItems' => $cartItems,
            'summary' => $summary
        ];

        $this->view('cart/index', $data);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     */
    public function updateQuantity() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = (int)($_POST['quantity'] ?? 1);
            
            if ($quantity <= 0) {
                // Xóa sản phẩm nếu số lượng <= 0
                $this->removeFromCart();
                return;
            }
            
            // Cập nhật số lượng
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] = $quantity;
                
                $response = [
                    'success' => true,
                    'message' => 'Đã cập nhật số lượng sản phẩm!',
                    'cartCount' => array_sum($_SESSION['cart'] ?? [])
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
                ];
            }
            
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        
        header('Location: ' . BASE_URL . 'cart');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            
            if (isset($_SESSION['cart'][$productId])) {
                unset($_SESSION['cart'][$productId]);
                
                $response = [
                    'success' => true,
                    'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                    'cartCount' => array_sum($_SESSION['cart'] ?? [])
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
                ];
            }
            
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        
        header('Location: ' . BASE_URL . 'cart');
    }

    /**
     * Thêm sản phẩm vào giỏ từ nút "Mua ngay"
     */
    private function addToCartFromBuyNow($productId, $quantity) {
        $productId = (int)$productId;
        $quantity = (int)$quantity;
        
        if ($productId > 0 && $quantity > 0) {
            $cart = $_SESSION['cart'] ?? [];
            
            // Kiểm tra xem sản phẩm đã có trong giỏ chưa
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }
            
            $_SESSION['cart'] = $cart;
        }
    }

    /**
     * Lấy thông tin chi tiết các sản phẩm trong giỏ hàng
     */
    private function getCartItems($cart) {
        if (empty($cart)) {
            return [];
        }

        $cartItems = [];
        
        foreach ($cart as $productId => $quantity) {
            $product = $this->getProductById($productId);
            
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product['price'] * $quantity
                ];
            }
        }
        
        return $cartItems;
    }

    /**
     * Tính tổng tiền giỏ hàng
     */
    private function calculateCartSummary($cartItems) {
        $subtotal = 0;
        $totalDiscount = 0;
        
        foreach ($cartItems as $item) {
            $subtotal += $item['subtotal'];
            
            // Tính tiền giảm giá
            if ($item['product']['old_price'] > $item['product']['price']) {
                $discount = ($item['product']['old_price'] - $item['product']['price']) * $item['quantity'];
                $totalDiscount += $discount;
            }
        }
        
        $shipping = $subtotal > 0 ? 30000 : 0; // Phí ship cố định 30,000đ
        $total = $subtotal + $shipping;
        
        return [
            'subtotal' => $subtotal,
            'discount' => $totalDiscount,
            'shipping' => $shipping,
            'total' => $total
        ];
    }

    /**
     * Lấy thông tin sản phẩm theo ID
     * (Giống trong ProductController - trong thực tế nên tách ra model)
     */
    private function getProductById($id) {
        $products = [
            1 => [
                'id' => 1,
                'name' => 'Đắc Nhân Tâm - Tác phẩm kinh điển về nghệ thuật thu phục và ảnh hưởng người khác',
                'author' => 'Dale Carnegie',
                'price' => 85000,
                'old_price' => 100000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/dac-nhan-tam.jpg',
                'in_stock' => true
            ],
            2 => [
                'id' => 2,
                'name' => 'Nhà Giả Kim - Phiên bản kỷ niệm 25 năm',
                'author' => 'Paulo Coelho',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-van-hoc',
                'image' => 'images/product-page/nha-gia-kim.jpg',
                'in_stock' => true
            ],
            3 => [
                'id' => 3,
                'name' => 'Nhà Lãnh Đạo Không Chức Danh',
                'author' => 'Robin Sharma',
                'price' => 95000,
                'old_price' => 110000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/nha-lanh-dao-khong-chuc-danh.jpg',
                'in_stock' => true
            ],
            4 => [
                'id' => 4,
                'name' => 'Đời Ngắn Đừng Ngủ Dài',
                'author' => 'Robin Sharma',
                'price' => 88000,
                'old_price' => 105000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/doi-ngan-dung-ngu-dai.jpg',
                'in_stock' => true
            ],
            5 => [
                'id' => 5,
                'name' => 'Tư Duy Nhanh và Tư Duy Chậm',
                'author' => 'Daniel Kahneman',
                'price' => 120000,
                'old_price' => 140000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-nhanh-va-cham.jpg',
                'in_stock' => true
            ],
            6 => [
                'id' => 6,
                'name' => 'Tư Duy Tích Cực',
                'author' => 'Carol Dweck',
                'price' => 92000,
                'old_price' => 110000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-tich-cuc.jpg',
                'in_stock' => true
            ],
            7 => [
                'id' => 7,
                'name' => 'Hiểu Về Trái Tim',
                'author' => 'Minh Niệm',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/hieu-ve-trai-tim.jpg',
                'in_stock' => true
            ],
            8 => [
                'id' => 8,
                'name' => 'Dám Bị Ghét',
                'author' => 'Kishimi Ichiro & Koga Fumitake',
                'price' => 85000,
                'old_price' => 100000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/dam-bi-ghet.jpg',
                'in_stock' => true
            ],
            9 => [
                'id' => 9,
                'name' => 'Gardening at Longmeadow',
                'author' => 'Monty Don',
                'price' => 468000,
                'old_price' => 585000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/gardening-at-longmeadow.jpg',
                'in_stock' => true
            ],
            10 => [
                'id' => 10,
                'name' => 'Văn Hóa Ẩm Thực Việt Nam',
                'author' => 'Trần Quốc Vượng - Nguyễn Thị Bảy',
                'price' => 40500,
                'old_price' => 45000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/van-hoa-am-thuc-viet-nam.jpg',
                'in_stock' => true
            ],
            11 => [
                'id' => 11,
                'name' => 'Câu Chuyện Triết Học',
                'author' => 'Will Durant',
                'price' => 289800,
                'old_price' => 450000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/cau-chuyen-triet-hoc.jpg',
                'in_stock' => true
            ],
            12 => [
                'id' => 12,
                'name' => 'Bách Khoa Cho Trẻ Em - Bách Khoa Khoa Học',
                'author' => 'Nhóm tác giả',
                'price' => 140800,
                'old_price' => 160000,
                'category' => 'sach-thieu-nhi',
                'image' => 'images/product-page/bach-khoa-khoa-hoc-cho-tre-em.jpg',
                'in_stock' => true
            ]
        ];

        return $products[$id] ?? null;
    }
}
