<?php
class AdminController extends Controller {

    private $adminModel;

    public function __construct() {
        // Khởi tạo Model 1 lần dùng cho toàn bộ controller
        $this->adminModel = $this->model('AdminModel');
        
        // Check quyền admin ở đây nếu cần
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') { 
            $this->redirect('auth/login'); 
        }
    }

    public function index() {
        $this->view('admin/dashboard');
    }

    // --- TASK #1: CẤU HÌNH & LIÊN HỆ ---

    public function settings() {
        if ($this->isPost()) {
            $this->adminModel->updateSetting('phone', $_POST['phone']);
            $this->adminModel->updateSetting('email', $_POST['email']);
            $this->adminModel->updateSetting('address', $_POST['address']);
            $this->redirect('admin/settings');
        }
        
        $data = ['settings' => $this->adminModel->getSettings()];
        $this->view('admin/settings/general', $data);
    }

    public function contacts() {
        $data = ['contacts' => $this->adminModel->getAllContacts()];
        $this->view('admin/contacts/index', $data);
    }

    public function deleteContact() {
        if ($this->isPost()) {
            $this->adminModel->deleteContact($_POST['id']);
            $this->redirect('admin/contacts');
        }
    }

    // --- TASK #2: GIỚI THIỆU & QA ---

    public function pageContent() {
        $page = $_GET['page'] ?? 'about';
        
        if ($this->isPost()) {
            $this->adminModel->updatePageContent($page, $_POST['content']);
            $this->redirect("admin/pageContent?page=$page");
        }
        
        $data = [
            'currPage' => $page,
            'content' => $this->adminModel->getPageContent($page)
        ];
        $this->view('admin/pages/edit', $data);
    }

    public function qa() {
        $data = ['qaList' => $this->adminModel->getAllQA()];
        $this->view('admin/qa/index', $data);
    }

    public function createQa() {
        if ($this->isPost()) {
            $this->adminModel->createQA($_POST['question'], $_POST['answer'], $_POST['category']);
            $this->redirect('admin/qa');
        } else {
            $this->view('admin/qa/create');
        }
    }

    public function deleteQa() {
        // Lưu ý: Thực tế nên dùng POST để xóa an toàn hơn
        $id = $_GET['id'] ?? 0;
        $this->adminModel->deleteQA($id);
        $this->redirect('admin/qa');
    }
    // --- HELPER: UPLOAD ẢNH ---
    private function uploadImage($file) {
        if (isset($file) && $file['error'] == 0) {
            $target_dir = "images/uploads/"; // Lưu trong public/images/uploads/
            // Tạo thư mục nếu chưa có (bạn cần tự tạo folder này thủ công 1 lần)
            $fileName = time() . '_' . basename($file["name"]);
            $target_file = ROOT . '/public/' . $target_dir . $fileName;
            
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_dir . $fileName; // Trả về đường dẫn để lưu DB
            }
        }
        return null;
    }

    // ================= NEWS CONTROLLER LOGIC =================
    public function news() {
        $data = ['articles' => $this->adminModel->getAllArticles()];
        $this->view('admin/news/index', $data);
    }

    public function createNews() {
        if ($this->isPost()) {
            $imagePath = $this->uploadImage($_FILES['image']);
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => $_POST['content'],
                'category' => $_POST['category'],
                'author' => $_SESSION['user_name'] ?? 'Admin',
                'image' => $imagePath ?? 'images/default-news.jpg'
            ];
            $this->adminModel->addArticle($data);
            $this->redirect('admin/news');
        }
        $this->view('admin/news/create');
    }

    public function editNews() {
        $id = $_GET['id'] ?? 0;
        if ($this->isPost()) {
            $imagePath = $this->uploadImage($_FILES['image']);
            $data = [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'content' => $_POST['content'],
                'category' => $_POST['category']
            ];
            if ($imagePath) $data['image'] = $imagePath;
            
            $this->adminModel->updateArticle($id, $data);
            $this->redirect('admin/news');
        }
        $data = ['article' => $this->adminModel->getArticleById($id)];
        $this->view('admin/news/edit', $data);
    }

    public function deleteNews() {
        $id = $_GET['id'] ?? 0;
        $this->adminModel->deleteArticle($id);
        $this->redirect('admin/news');
    }

    // ================= PRODUCT CONTROLLER LOGIC =================
    public function products() {
        $data = ['products' => $this->adminModel->getAllProducts()];
        $this->view('admin/products/index', $data);
    }

    public function createProduct() {
        if ($this->isPost()) {
            $imagePath = $this->uploadImage($_FILES['image']);
            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'old' => $_POST['old_price'],
                'desc' => $_POST['description'],
                'cat' => $_POST['category'],
                'image' => $imagePath ?? 'images/default-book.jpg'
            ];
            $this->adminModel->addProduct($data);
            $this->redirect('admin/products');
        }
        $this->view('admin/products/create');
    }
    
    // Tương tự cho editProduct và deleteProduct... bạn tự viết thêm nhé hoặc dùng logic giống News
    public function deleteProduct() {
        $this->adminModel->deleteProduct($_GET['id']);
        $this->redirect('admin/products');
    }
}