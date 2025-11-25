<?php
/**
 * PRODUCT CONTROLLER
 * Trang Danh sách sản phẩm và Chi tiết sản phẩm
 */

class ProductController extends Controller {

    /**
     * Trang danh sách sản phẩm
     */
    public function index() {
        $search = trim($_GET['search'] ?? '');
        $category = $_GET['category'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Số sản phẩm trên mỗi trang
        $offset = ($page - 1) * $limit;

        // Trong thực tế, bạn sẽ truy vấn database để lấy sản phẩm
        // Dưới đây là dữ liệu mẫu
        $products = $this->getProducts($search, $category, $limit, $offset);
        $totalProducts = $this->getTotalProducts($search, $category);
        $totalPages = ceil($totalProducts / $limit);

        $data = [
            'title' => 'Danh sách sản phẩm - ' . APP_NAME,
            'page' => 'product',
            'products' => $products,
            'search' => $search,
            'category' => $category,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts
        ];

        $this->view('product/index', $data);
    }

    /**
     * Trang chi tiết sản phẩm
     */
    public function detail($id) {
        // Trong thực tế, bạn sẽ truy vấn database để lấy thông tin sản phẩm
        // Dưới đây là dữ liệu mẫu
        $product = $this->getProductById($id);
        
        if (!$product) {
            // Nếu không tìm thấy sản phẩm, chuyển hướng về trang danh sách
            header('Location: ' . BASE_URL . 'product');
            exit;
        }
        
        // Lấy sản phẩm liên quan (cùng danh mục)
        $relatedProducts = $this->getRelatedProducts($product['category'], $id, 4);
        
        $data = [
            'title' => $product['name'] . ' - ' . APP_NAME,
            'page' => 'product',
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ];

        $this->view('product/detail', $data);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = (int)($_POST['quantity'] ?? 1);
            
            // Trong thực tế, bạn sẽ lưu vào session hoặc database
            // Ở đây là mô phỏng đơn giản
            
            // Lấy giỏ hàng hiện tại từ session (giả lập)
            $cart = $_SESSION['cart'] ?? [];
            
            // Kiểm tra xem sản phẩm đã có trong giỏ chưa
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }
            
            // Cập nhật lại session
            $_SESSION['cart'] = $cart;
            
            // Trả về kết quả
            $response = [
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
                'cartCount' => array_sum($_SESSION['cart'] ?? [])
            ];
            
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        
        // Nếu không phải POST thì redirect về trang chủ
        header('Location: ' . BASE_URL);
    }
    
    /**
     * Mô phỏng hàm lấy sản phẩm từ database
     */
    private function getProducts($search = '', $category = '', $limit = 12, $offset = 0) {
        // Dữ liệu mẫu
        $allProducts = [
            1 => [
                'id' => 1,
                'name' => 'Đắc Nhân Tâm - Tác phẩm kinh điển về nghệ thuật thu phục và ảnh hưởng người khác',
                'author' => 'Dale Carnegie',
                'price' => 85000,
                'old_price' => 100000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/dac-nhan-tam.jpg',
                'description' => 'Đắc Nhân Tâm là quyển sách duy nhất về thể loại self-help bán chạy nhất mọi thời đại. Cuốn sách đã và đang thay đổi cuộc sống của hàng triệu người trên thế giới.',
                'rating' => 4.8,
                'reviews' => 1250
            ],
            2 => [
                'id' => 2,
                'name' => 'Nhà Giả Kim - Phiên bản kỷ niệm 25 năm',
                'author' => 'Paulo Coelho',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-van-hoc',
                'image' => 'images/product-page/nha-gia-kim.jpg',
                'description' => 'Một câu chuyện cổ tích dành cho người lớn, một câu chuyện cổ tích về việc theo đuổi giấc mơ và tìm kiếm ý nghĩa cuộc sống.',
                'rating' => 4.7,
                'reviews' => 980
            ],
            3 => [
                'id' => 3,
                'name' => 'Nhà Lãnh Đạo Không Chức Danh',
                'author' => 'Robin Sharma',
                'price' => 95000,
                'old_price' => 110000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/nha-lanh-dao-khong-chuc-danh.jpg',
                'description' => 'Cuốn sách truyền cảm hứng cho độc giả rằng ai cũng có thể trở thành một nhà lãnh đạo, không phải bởi chức vụ mà bởi hành động.',
                'rating' => 4.6,
                'reviews' => 750
            ],
            4 => [
                'id' => 4,
                'name' => 'Đời Ngắn Đừng Ngủ Dài',
                'author' => 'Robin Sharma',
                'price' => 88000,
                'old_price' => 105000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/doi-ngan-dung-ngu-dai.jpg',
                'description' => 'Cuốn sách giúp bạn khám phá cách thức để thức dậy mỗi ngày với sự hăng hái, hiệu suất và cảm giác tuyệt vời.',
                'rating' => 4.5,
                'reviews' => 820
            ],
            5 => [
                'id' => 5,
                'name' => 'Tư Duy Nhanh và Tư Duy Chậm',
                'author' => 'Daniel Kahneman',
                'price' => 120000,
                'old_price' => 140000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-nhanh-va-cham.jpg',
                'description' => 'Cuốn sách khám phá hai hệ thống tư duy chi phối cách chúng ta suy nghĩ: hệ thống nhanh và hệ thống chậm.',
                'rating' => 4.7,
                'reviews' => 680
            ],
            6 => [
                'id' => 6,
                'name' => 'Tư Duy Tích Cực',
                'author' => 'Carol Dweck',
                'price' => 92000,
                'old_price' => 110000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-tich-cuc.jpg',
                'description' => 'Cuốn sách giải thích cách tư duy ảnh hưởng đến thành công và cách phát triển tư duy tăng trưởng.',
                'rating' => 4.6,
                'reviews' => 740
            ],
            7 => [
                'id' => 7,
                'name' => 'Hiểu Về Trái Tim',
                'author' => 'Minh Niệm',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/hieu-ve-trai-tim.jpg',
                'description' => 'Cuốn sách giúp người đọc hiểu rõ hơn về bản thân và cảm xúc của mình, từ đó sống an nhiên và hạnh phúc hơn.',
                'rating' => 4.8,
                'reviews' => 950
            ],
            8 => [
                'id' => 8,
                'name' => 'Dám Bị Ghét',
                'author' => 'Kishimi Ichiro & Koga Fumitake',
                'price' => 85000,
                'old_price' => 100000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/dam-bi-ghet.jpg',
                'description' => 'Cuốn sách truyền cảm hứng để bạn dám sống đúng là chính mình, không bị ràng buộc bởi kỳ vọng của người khác.',
                'rating' => 4.9,
                'reviews' => 1100
            ],
            9 => [
                'id' => 9,
                'name' => 'Gardening at Longmeadow',
                'author' => 'Monty Don',
                'price' => 468000,
                'old_price' => 585000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/gardening-at-longmeadow.jpg',
                'description' => 'Cuốn sách hướng dẫn chăm sóc vườn tược với nhiều mẹo hay và kinh nghiệm từ chuyên gia.',
                'rating' => 4.4,
                'reviews' => 320
            ],
            10 => [
                'id' => 10,
                'name' => 'Văn Hóa Ẩm Thực Việt Nam',
                'author' => 'Trần Quốc Vượng - Nguyễn Thị Bảy',
                'price' => 40500,
                'old_price' => 45000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/van-hoa-am-thuc-viet-nam.jpg',
                'description' => 'Khám phá văn hóa ẩm thực đặc sắc của Việt Nam qua từng vùng miền.',
                'rating' => 4.7,
                'reviews' => 560
            ],
            11 => [
                'id' => 11,
                'name' => 'Câu Chuyện Triết Học',
                'author' => 'Will Durant',
                'price' => 289800,
                'old_price' => 450000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/cau-chuyen-triet-hoc.jpg',
                'description' => 'Cuốn sách kinh điển giúp bạn nắm trọn tinh hoa triết học phương Tây qua những câu chuyện súc tích, dễ hiểu và đầy cảm hứng',
                'rating' => 4.9,
                'reviews' => 420
            ],
            12 => [
                'id' => 12,
                'name' => 'Bách Khoa Cho Trẻ Em - Bách Khoa Khoa Học',
                'author' => 'Nhóm tác giả',
                'price' => 140800,
                'old_price' => 160000,
                'category' => 'sach-thieu-nhi',
                'image' => 'images/product-page/bach-khoa-khoa-hoc-cho-tre-em.jpg',
                'description' => 'Cuốn sách mang đến những thông tin thú vị về thế giới tự nhiên, con người, động vật...',
                'rating' => 4.6,
                'reviews' => 780
            ]
        ];
        
        // Lọc sản phẩm theo tìm kiếm
        if (!empty($search)) {
            $filteredProducts = [];
            foreach ($allProducts as $product) {
                if (stripos($product['name'], $search) !== false || 
                    stripos($product['author'], $search) !== false) {
                    $filteredProducts[] = $product;
                }
            }
            $allProducts = $filteredProducts;
        }
        
        // Lọc sản phẩm theo danh mục
        if (!empty($category) && $category !== 'all') {
            $filteredProducts = [];
            foreach ($allProducts as $product) {
                if ($product['category'] === $category) {
                    $filteredProducts[] = $product;
                }
            }
            $allProducts = $filteredProducts;
        }
        
        // Phân trang
        $totalProducts = count($allProducts);
        $products = array_slice($allProducts, $offset, $limit);
        
        return $products;
    }
    
    /**
     * Mô phỏng hàm lấy tổng số sản phẩm (cho phân trang)
     */
    private function getTotalProducts($search = '', $category = '') {
        $allProducts = $this->getProducts($search, $category);
        return count($allProducts);
    }
    
    /**
     * Mô phỏng hàm lấy sản phẩm theo ID
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
                'description' => 'Đắc Nhân Tâm là quyển sách duy nhất về thể loại self-help bán chạy nhất mọi thời đại. Cuốn sách đã và đang thay đổi cuộc sống của hàng triệu người trên thế giới. Đây là quyển sách đầu tiên trong lịch sử bán được hơn 15 triệu bản và được dịch ra gần 40 thứ tiếng trên thế giới. Cuốn sách đưa ra những nguyên tắc cơ bản và sâu sắc về cách ứng xử, làm việc và sinh hoạt để đạt được thành công trong cuộc sống. Tác phẩm đã giúp hàng triệu người thành công và hạnh phúc hơn trong cuộc sống. Quyển sách cũng được xem như là một trong những cuốn sách bán chạy và có ảnh hưởng nhất trong lịch sử nước Mỹ.',
                'rating' => 4.8,
                'reviews' => 1250,
                'in_stock' => true,
                'pages' => 400,
                'publisher' => 'NXB Tổng hợp TP.HCM',
                'published_date' => '2020-06-15',
                'dimensions' => '13 x 20.5 cm',
                'weight' => '480g'
            ],
            2 => [
                'id' => 2,
                'name' => 'Nhà Giả Kim - Phiên bản kỷ niệm 25 năm',
                'author' => 'Paulo Coelho',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-van-hoc',
                'image' => 'images/product-page/nha-gia-kim.jpg',
                'description' => 'Một cậu bé chăn cừu người Tây Ban Nha tên Santiago dấn thân vào một cuộc hành trình theo đuổi giấc mơ và tìm kiếm kho báu được tiết lộ trong giấc mơ của mình. Trong hành trình đó, cậu học được nhiều điều về bản thân và khám phá ra "Ngôn ngữ của thế giới". Cuốn tiểu thuyết phiêu lưu này đã được dịch ra hơn 80 ngôn ngữ và bán hơn 150 triệu bản, trở thành một trong những cuốn sách bán chạy nhất mọi thời đại. Đây là cuốn sách truyền cảm hứng cho độc giả rằng ai cũng có thể theo đuổi giấc mơ của mình.',
                'rating' => 4.7,
                'reviews' => 980,
                'in_stock' => true,
                'pages' => 162,
                'publisher' => 'NXB Trẻ',
                'published_date' => '2019-08-10',
                'dimensions' => '11 x 18 cm',
                'weight' => '200g'
            ],
            3 => [
                'id' => 3,
                'name' => 'Nhà Lãnh Đạo Không Chức Danh',
                'author' => 'Robin Sharma',
                'price' => 95000,
                'old_price' => 110000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/nha-lanh-dao-khong-chuc-danh.jpg',
                'description' => 'Robin Sharma, tác giả của "Đời Ngắn Đừng Ngủ Dài", giới thiệu một câu chuyện truyền cảm hứng về một nhân viên bình thường tên là Blake Mycoskie, người đang đối mặt với sự trì trệ trong cuộc sống và công việc. Thông qua cuộc gặp gỡ đầy bất ngờ với một cựu đặc nhiệm SEAL, Blake khám phá ra các bí mật thực sự của hiệu suất cao, sự lãnh đạo và sự vĩ đại. Cuốn sách mang đến những nguyên tắc quan trọng giúp bạn dẫn đầu trong công việc và cuộc sống, bất kể bạn đang giữ chức vụ gì.',
                'rating' => 4.6,
                'reviews' => 750,
                'in_stock' => true,
                'pages' => 224,
                'publisher' => 'NXB Lao Động',
                'published_date' => '2021-03-05',
                'dimensions' => '14 x 20.5 cm',
                'weight' => '280g'
            ],
            4 => [
                'id' => 4,
                'name' => 'Đời Ngắn Đừng Ngủ Dài',
                'author' => 'Robin Sharma',
                'price' => 88000,
                'old_price' => 105000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/doi-ngan-dung-ngu-dai.jpg',
                'description' => 'Tác phẩm đã truyền cảm hứng cho hàng triệu người trên thế giới để thức dậy mỗi ngày với năng lượng, hiệu suất và cảm giác tuyệt vời. Robin Sharma, cựu luật sư nổi tiếng, chia sẻ công cụ thiết thực và những chiến lược mạnh mẽ đã giúp hàng ngàn doanh nhân, vận động viên, diễn viên và các nhà lãnh đạo hàng đầu đạt được thành công vĩ đại. Cuốn sách giúp bạn khám phá cách để trở thành phiên bản tốt nhất của chính mình mỗi ngày.',
                'rating' => 4.5,
                'reviews' => 820,
                'in_stock' => true,
                'pages' => 208,
                'publisher' => 'NXB Tổng hợp TP.HCM',
                'published_date' => '2020-11-20',
                'dimensions' => '13 x 20.5 cm',
                'weight' => '260g'
            ],
            5 => [
                'id' => 5,
                'name' => 'Tư Duy Nhanh và Tư Duy Chậm',
                'author' => 'Daniel Kahneman',
                'price' => 120000,
                'old_price' => 140000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-nhanh-va-cham.jpg',
                'description' => 'Cuốn sách khám phá hai hệ thống tư duy chi phối cách chúng ta suy nghĩ: hệ thống nhanh và hệ thống chậm. Một hệ thống nhanh ra quyết định một cách trực giác và cảm tính, hệ thống còn lại thì chậm hơn, có tính toán và logic. Cuốn sách làm sáng tỏ nhiều đặc tính kỳ lạ của tư duy con người, từ ảo tưởng nhận thức đến cách ra quyết định tài chính, cũng như đánh giá hạnh phúc và lựa chọn xã hội.',
                'rating' => 4.7,
                'reviews' => 680,
                'in_stock' => true,
                'pages' => 499,
                'publisher' => 'NXB Chính Trị Quốc Gia',
                'published_date' => '2018-07-15',
                'dimensions' => '14 x 21 cm',
                'weight' => '650g'
            ],
            6 => [
                'id' => 6,
                'name' => 'Tư Duy Tích Cực',
                'author' => 'Carol Dweck',
                'price' => 92000,
                'old_price' => 110000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-tich-cuc.jpg',
                'description' => 'Cuốn sách giải thích cách tư duy ảnh hưởng đến thành công và cách phát triển tư duy tăng trưởng. Tác phẩm khám phá sự khác biệt giữa tư duy cố định và tư duy tăng trưởng, và cách thay đổi tư duy có thể thay đổi cuộc sống. Cuốn sách cung cấp những phương pháp thực tế để xây dựng tư duy tích cực và khả năng phục hồi, giúp bạn đạt được mục tiêu và vượt qua thử thách.',
                'rating' => 4.6,
                'reviews' => 740,
                'in_stock' => true,
                'pages' => 320,
                'publisher' => 'NXB Trẻ',
                'published_date' => '2020-05-12',
                'dimensions' => '14 x 21 cm',
                'weight' => '400g'
            ],
            7 => [
                'id' => 7,
                'name' => 'Hiểu Về Trái Tim',
                'author' => 'Minh Niệm',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/hieu-ve-trai-tim.jpg',
                'description' => 'Cuốn sách giúp người đọc hiểu rõ hơn về bản thân và cảm xúc của mình, từ đó sống an nhiên và hạnh phúc hơn. Tác phẩm đưa ra những lời khuyên sâu sắc về việc kiểm soát cảm xúc, thấu hiểu người khác, và tìm thấy bình an trong tâm hồn. Đây là một cuốn sách gối đầu giường giúp bạn sống chậm lại và cảm nhận sâu sắc hơn về cuộc sống.',
                'rating' => 4.8,
                'reviews' => 950,
                'in_stock' => true,
                'pages' => 280,
                'publisher' => 'NXB Tổng hợp TP.HCM',
                'published_date' => '2019-11-30',
                'dimensions' => '13 x 20 cm',
                'weight' => '350g'
            ],
            8 => [
                'id' => 8,
                'name' => 'Dám Bị Ghét',
                'author' => 'Kishimi Ichiro & Koga Fumitake',
                'price' => 85000,
                'old_price' => 100000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/dam-bi-ghet.jpg',
                'description' => 'Cuốn sách truyền cảm hứng để bạn dám sống đúng là chính mình, không bị ràng buộc bởi kỳ vọng của người khác. Dựa trên tâm lý học Adler, cuốn sách khám phá cách chúng ta có thể thoát khỏi sự lo lắng về việc bị người khác phán xét và sống tự do, hạnh phúc hơn. Cuốn sách cung cấp những góc nhìn mới mẻ về cuộc sống, mối quan hệ và sự phát triển bản thân.',
                'rating' => 4.9,
                'reviews' => 1100,
                'in_stock' => true,
                'pages' => 256,
                'publisher' => 'NXB Thế Giới',
                'published_date' => '2020-09-15',
                'dimensions' => '14 x 20.5 cm',
                'weight' => '300g'
            ],
            9 => [
                'id' => 9,
                'name' => 'Gardening at Longmeadow',
                'author' => 'Monty Don',
                'price' => 468000,
                'old_price' => 585000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/gardening-at-longmeadow.jpg',
                'description' => 'Cuốn sách hướng dẫn chăm sóc vườn tược với nhiều mẹo hay và kinh nghiệm từ chuyên gia. Tác phẩm chia sẻ bí quyết tạo nên một khu vườn đẹp theo mùa, cách chăm sóc cây cối, lựa chọn giống hoa phù hợp và tạo nên không gian xanh lý tưởng. Đây là nguồn cảm hứng cho những người yêu thích làm vườn và thiên nhiên.',
                'rating' => 4.4,
                'reviews' => 320,
                'in_stock' => true,
                'pages' => 352,
                'publisher' => 'DK Publishing',
                'published_date' => '2021-02-08',
                'dimensions' => '21 x 25 cm',
                'weight' => '1200g'
            ],
            10 => [
                'id' => 10,
                'name' => 'Văn Hóa Ẩm Thực Việt Nam',
                'author' => 'Trần Quốc Vượng - Nguyễn Thị Bảy',
                'price' => 40500,
                'old_price' => 45000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/van-hoa-am-thuc-viet-nam.jpg',
                'description' => 'Khám phá văn hóa ẩm thực đặc sắc của Việt Nam qua từng vùng miền. Cuốn sách cung cấp kiến thức phong phú về lịch sử, đặc điểm và ý nghĩa văn hóa của các món ăn truyền thống Việt Nam. Tác phẩm cũng giới thiệu các phương pháp chế biến, nguyên liệu đặc trưng và vai trò của ẩm thực trong đời sống người Việt.',
                'rating' => 4.7,
                'reviews' => 560,
                'in_stock' => true,
                'pages' => 208,
                'publisher' => 'NXB Văn Hóa',
                'published_date' => '2019-06-20',
                'dimensions' => '16 x 24 cm',
                'weight' => '450g'
            ],
            11 => [
                'id' => 11,
                'name' => 'Câu Chuyện Triết Học',
                'author' => 'Will Durant',
                'price' => 289800,
                'old_price' => 450000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/cau-chuyen-triet-hoc.jpg',
                'description' => 'Cuốn sách kinh điển giúp bạn nắm trọn tinh hoa triết học phương Tây qua những câu chuyện súc tích, dễ hiểu và đầy cảm hứng. Tác phẩm giới thiệu những tư tưởng vĩ đại của các triết gia từ thời cổ đại đến hiện đại, từ Plato, Aristotle đến Nietzsche, Schopenhauer. Cuốn sách là hành trình khám phá những câu hỏi vĩ đại của nhân loại và cách các triết gia trả lời chúng.',
                'rating' => 4.9,
                'reviews' => 420,
                'in_stock' => true,
                'pages' => 736,
                'publisher' => 'NXB Thế Giới',
                'published_date' => '2020-04-10',
                'dimensions' => '15 x 23 cm',
                'weight' => '980g'
            ],
            12 => [
                'id' => 12,
                'name' => 'Bách Khoa Cho Trẻ Em - Bách Khoa Khoa Học',
                'author' => 'Nhóm tác giả',
                'price' => 140800,
                'old_price' => 160000,
                'category' => 'sach-thieu-nhi',
                'image' => 'images/product-page/bach-khoa-khoa-hoc-cho-tre-em.jpg',
                'description' => 'Cuốn sách mang đến những thông tin thú vị về thế giới tự nhiên, con người, động vật và nhiều lĩnh vực khác. Với hình ảnh minh họa sinh động, nội dung khoa học được trình bày dễ hiểu, cuốn sách là người bạn đồng hành lý tưởng giúp các em nhỏ khám phá thế giới xung quanh. Nội dung được chia theo các chủ đề hấp dẫn, giúp trẻ phát triển tư duy khoa học và khơi gợi lòng ham mê khám phá.',
                'rating' => 4.6,
                'reviews' => 780,
                'in_stock' => true,
                'pages' => 320,
                'publisher' => 'NXB Kim Đồng',
                'published_date' => '2021-07-15',
                'dimensions' => '20 x 26 cm',
                'weight' => '850g'
            ]
        ];

        return $products[$id] ?? null;
    }
    
    /**
     * Mô phỏng hàm lấy sản phẩm liên quan
     */
    private function getRelatedProducts($category, $currentId, $limit = 4) {
        $allProducts = [
            1 => [
                'id' => 1,
                'name' => 'Đắc Nhân Tâm - Tác phẩm kinh điển về nghệ thuật thu phục và ảnh hưởng người khác',
                'author' => 'Dale Carnegie',
                'price' => 85000,
                'old_price' => 100000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/dac-nhan-tam.jpg',
                'rating' => 4.8,
                'reviews' => 1250
            ],
            2 => [
                'id' => 2,
                'name' => 'Nhà Giả Kim - Phiên bản kỷ niệm 25 năm',
                'author' => 'Paulo Coelho',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-van-hoc',
                'image' => 'images/product-page/nha-gia-kim.jpg',
                'rating' => 4.7,
                'reviews' => 980
            ],
            3 => [
                'id' => 3,
                'name' => 'Nhà Lãnh Đạo Không Chức Danh',
                'author' => 'Robin Sharma',
                'price' => 95000,
                'old_price' => 110000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/nha-lanh-dao-khong-chuc-danh.jpg',
                'rating' => 4.6,
                'reviews' => 750
            ],
            4 => [
                'id' => 4,
                'name' => 'Đời Ngắn Đừng Ngủ Dài',
                'author' => 'Robin Sharma',
                'price' => 88000,
                'old_price' => 105000,
                'category' => 'sach-ky-nang',
                'image' => 'images/product-page/doi-ngan-dung-ngu-dai.jpg',
                'rating' => 4.5,
                'reviews' => 820
            ],
            5 => [
                'id' => 5,
                'name' => 'Tư Duy Nhanh và Tư Duy Chậm',
                'author' => 'Daniel Kahneman',
                'price' => 120000,
                'old_price' => 140000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-nhanh-va-cham.jpg',
                'rating' => 4.7,
                'reviews' => 680
            ],
            6 => [
                'id' => 6,
                'name' => 'Tư Duy Tích Cực',
                'author' => 'Carol Dweck',
                'price' => 92000,
                'old_price' => 110000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/tu-duy-tich-cuc.jpg',
                'rating' => 4.6,
                'reviews' => 740
            ],
            7 => [
                'id' => 7,
                'name' => 'Hiểu Về Trái Tim',
                'author' => 'Minh Niệm',
                'price' => 75000,
                'old_price' => 90000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/hieu-ve-trai-tim.jpg',
                'rating' => 4.8,
                'reviews' => 950
            ],
            8 => [
                'id' => 8,
                'name' => 'Dám Bị Ghét',
                'author' => 'Kishimi Ichiro & Koga Fumitake',
                'price' => 85000,
                'old_price' => 100000,
                'category' => 'sach-tam-li',
                'image' => 'images/product-page/dam-bi-ghet.jpg',
                'rating' => 4.9,
                'reviews' => 1100
            ],
            9 => [
                'id' => 9,
                'name' => 'Gardening at Longmeadow',
                'author' => 'Monty Don',
                'price' => 468000,
                'old_price' => 585000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/gardening-at-longmeadow.jpg',
                'rating' => 4.4,
                'reviews' => 320
            ],
            10 => [
                'id' => 10,
                'name' => 'Văn Hóa Ẩm Thực Việt Nam',
                'author' => 'Trần Quốc Vượng - Nguyễn Thị Bảy',
                'price' => 40500,
                'old_price' => 45000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/van-hoa-am-thuc-viet-nam.jpg',
                'rating' => 4.7,
                'reviews' => 560
            ],
            11 => [
                'id' => 11,
                'name' => 'Câu Chuyện Triết Học',
                'author' => 'Will Durant',
                'price' => 289800,
                'old_price' => 450000,
                'category' => 'sach-kien-thuc',
                'image' => 'images/product-page/cau-chuyen-triet-hoc.jpg',
                'rating' => 4.9,
                'reviews' => 420
            ],
            12 => [
                'id' => 12,
                'name' => 'Bách Khoa Cho Trẻ Em - Bách Khoa Khoa Học',
                'author' => 'Nhóm tác giả',
                'price' => 140800,
                'old_price' => 160000,
                'category' => 'sach-thieu-nhi',
                'image' => 'images/product-page/bach-khoa-khoa-hoc-cho-tre-em.jpg',
                'rating' => 4.6,
                'reviews' => 780
            ]
        ];

        $related = [];
        foreach ($allProducts as $product) {
            if ($product['category'] === $category && $product['id'] !== $currentId) {
                $related[] = $product;
                if (count($related) >= $limit) {
                    break;
                }
            }
        }

        return $related;
    }
}