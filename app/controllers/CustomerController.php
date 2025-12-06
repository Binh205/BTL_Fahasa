<?php
/**
 * CUSTOMER CONTROLLER
 * Quản lý trang cá nhân của khách hàng
 */

class CustomerController extends Controller {
    
    /**
     * Constructor - Kiểm tra đăng nhập
     */
    public function __construct() {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['users_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }
    
    /**
     * Trang thông tin tài khoản
     */
    public function index() {
        // Mock user data
        $userData = [
            'user_id' => $_SESSION['users_id'],
            'username' => $_SESSION['users_username'] ?? 'Nguyễn Văn A',
            'fullname' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'phone' => '0901234567',
            'gender' => 'male',
            'birthday' => '1990-01-15',
            'address' => '123 Nguyễn Huệ, Quận 1, TP.HCM',
            'avatar' => null,
            'created_at' => '2024-01-01'
        ];
        
        $data = [
            'title' => 'Thông tin tài khoản - ' . APP_NAME,
            'page' => 'customer',
            'user' => $userData
        ];
        
        $this->view('customer/index', $data);
    }
    
    /**
     * Trang đơn hàng của tôi
     */
    public function orders() {
        // Mock orders data
        $orders = [
            [
                'order_id' => 'DH001',
                'order_date' => '2024-11-25',
                'status' => 'completed',
                'status_text' => 'Đã giao hàng',
                'total' => 450000,
                'items' => [
                    [
                        'product_name' => 'Đắc Nhân Tâm',
                        'quantity' => 1,
                        'price' => 150000,
                        'image' => 'images/product-page/dac-nhan-tam.jpg'
                    ],
                    [
                        'product_name' => 'Nhà Giả Kim',
                        'quantity' => 2,
                        'price' => 150000,
                        'image' => 'images/product-page/nha-gia-kim.jpg'
                    ]
                ]
            ],
            [
                'order_id' => 'DH002',
                'order_date' => '2024-11-28',
                'status' => 'shipping',
                'status_text' => 'Đang giao hàng',
                'total' => 320000,
                'items' => [
                    [
                        'product_name' => 'Tư Duy Nhanh Và Chậm',
                        'quantity' => 1,
                        'price' => 320000,
                        'image' => 'images/product-page/tu-duy-nhanh-va-cham.jpg'
                    ]
                ]
            ],
            [
                'order_id' => 'DH003',
                'order_date' => '2024-12-01',
                'status' => 'processing',
                'status_text' => 'Đang xử lý',
                'total' => 280000,
                'items' => [
                    [
                        'product_name' => 'Hiểu Về Trái Tim',
                        'quantity' => 1,
                        'price' => 280000,
                        'image' => 'images/product-page/hieu-ve-trai-tim.jpg'
                    ]
                ]
            ]
        ];
        
        $data = [
            'title' => 'Đơn hàng của tôi - ' . APP_NAME,
            'page' => 'customer',
            'orders' => $orders
        ];
        
        $this->view('customer/orders', $data);
    }
    
    /**
     * Trang thông báo
     */
    public function notifications() {
        // Mock notifications data
        $notifications = [
            [
                'id' => 1,
                'type' => 'order',
                'icon' => 'fa-box',
                'title' => 'Đơn hàng DH002 đang được giao',
                'content' => 'Đơn hàng của bạn đang trên đường giao đến. Dự kiến giao hàng trong 1-2 ngày tới.',
                'time' => '2 giờ trước',
                'is_read' => false
            ],
            [
                'id' => 2,
                'type' => 'promotion',
                'icon' => 'fa-gift',
                'title' => 'Giảm giá 20% cho đơn hàng tiếp theo',
                'content' => 'Chúc mừng! Bạn nhận được mã giảm giá 20% cho đơn hàng tiếp theo. Mã: FAHASA20',
                'time' => '1 ngày trước',
                'is_read' => false
            ],
            [
                'id' => 3,
                'type' => 'order',
                'icon' => 'fa-check-circle',
                'title' => 'Đơn hàng DH001 đã giao thành công',
                'content' => 'Đơn hàng của bạn đã được giao thành công. Cảm ơn bạn đã mua hàng tại Fahasa!',
                'time' => '3 ngày trước',
                'is_read' => true
            ],
            [
                'id' => 4,
                'type' => 'system',
                'icon' => 'fa-info-circle',
                'title' => 'Cập nhật chính sách đổi trả',
                'content' => 'Fahasa đã cập nhật chính sách đổi trả sản phẩm. Vui lòng xem chi tiết tại mục Chính sách.',
                'time' => '1 tuần trước',
                'is_read' => true
            ]
        ];
        
        $data = [
            'title' => 'Thông báo - ' . APP_NAME,
            'page' => 'customer',
            'notifications' => $notifications
        ];
        
        $this->view('customer/notifications', $data);
    }
    
    /**
     * Trang sản phẩm yêu thích
     */
    public function wishlist() {
        // Mock wishlist data
        $wishlist = [
            [
                'product_id' => 1,
                'product_name' => 'Đắc Nhân Tâm',
                'author' => 'Dale Carnegie',
                'price' => 150000,
                'original_price' => 180000,
                'discount' => 17,
                'image' => 'images/product-page/dac-nhan-tam.jpg',
                'rating' => 4.8,
                'sold' => 1250,
                'added_date' => '2024-11-20'
            ],
            [
                'product_id' => 2,
                'product_name' => 'Tư Duy Nhanh Và Chậm',
                'author' => 'Daniel Kahneman',
                'price' => 320000,
                'original_price' => 380000,
                'discount' => 16,
                'image' => 'images/product-page/tu-duy-nhanh-va-cham.jpg',
                'rating' => 4.9,
                'sold' => 890,
                'added_date' => '2024-11-22'
            ],
            [
                'product_id' => 3,
                'product_name' => 'Hiểu Về Trái Tim',
                'author' => 'Minh Niệm',
                'price' => 280000,
                'original_price' => 320000,
                'discount' => 13,
                'image' => 'images/product-page/hieu-ve-trai-tim.jpg',
                'rating' => 4.7,
                'sold' => 650,
                'added_date' => '2024-11-25'
            ],
            [
                'product_id' => 4,
                'product_name' => 'Nhà Giả Kim',
                'author' => 'Paulo Coelho',
                'price' => 150000,
                'original_price' => 170000,
                'discount' => 12,
                'image' => 'images/product-page/nha-gia-kim.jpg',
                'rating' => 4.6,
                'sold' => 2100,
                'added_date' => '2024-11-28'
            ]
        ];
        
        $data = [
            'title' => 'Sản phẩm yêu thích - ' . APP_NAME,
            'page' => 'customer',
            'wishlist' => $wishlist
        ];
        
        $this->view('customer/wishlist', $data);
    }
}
