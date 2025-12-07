<?php
/**
 * PRODUCT CONTROLLER
 * Trang Danh sách sản phẩm và Chi tiết sản phẩm
 */

class ProductController extends Controller
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load models
        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
    }

    /**
     * Trang danh sách sản phẩm
     */
    public function index()
    {
        // Lấy các tham số từ URL
        $search = trim($_GET['search'] ?? '');
        $category_id = $_GET['category'] ?? ''; // Now expects category ID
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        // Xây dựng mảng options cho truy vấn
        $options = [
            'search' => $search,
            'category_id' => $category_id,
            'limit' => $limit,
            'offset' => $offset
        ];

        // Lấy dữ liệu từ model
        $products = $this->productModel->getFilteredProducts($options);
        $totalProducts = $this->productModel->countFilteredProducts($options);
        $totalPages = ceil($totalProducts / $limit);
        $categories = $this->categoryModel->getAllCategories();

        $data = [
            'title' => 'Danh sách sản phẩm - ' . APP_NAME,
            'page' => 'product',
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'selectedCategory' => $category_id,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts
        ];

        $this->view('product/index', $data);
    }

    /**
     * Trang chi tiết sản phẩm
     */
    public function detail($id)
    {
        $product = $this->productModel->getProductDetailsById($id);

        if (!$product) {
            // Nếu không tìm thấy sản phẩm, chuyển hướng về trang danh sách
            $this->redirect('product');
        }

        // Lấy sản phẩm liên quan (cùng danh mục)
        $relatedProducts = [];
        if (!empty($product['category_id'])) {
            $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $id, 4);
        }

        $data = [
            'title' => $product['title'] . ' - ' . APP_NAME,
            'page' => 'product',
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ];

        $this->view('product/detail', $data);
    }

    // ✅ ĐÃ XÓA method addToCart() CŨ
    // Giờ dùng CartController::add() để quản lý giỏ hàng
}
