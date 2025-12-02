<?php
class AdminController extends Controller {

    private $adminModel;

    public function __construct() {
        // Khởi tạo Model 1 lần dùng cho toàn bộ controller
        $this->adminModel = $this->model('Admin');
        
        // Check quyền admin ở đây nếu cần
        if (!isset($_SESSION['users_role']) || $_SESSION['users_role'] !== 'admin') { 
            $this->redirect('home'); 
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
}