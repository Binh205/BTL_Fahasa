<?php
/**
 * HOME CONTROLLER
 * Xử lý các trang chính của website
 */

class HomeController extends Controller {
    
    /**
     * Trang chủ
     */
    public function index() {
        $data = [
            'title' => 'Trang chủ - ' . APP_NAME,
            'page' => 'home'
        ];
        
        // Tạm thời redirect về landing, sau này sẽ có view riêng
        $this->redirect('landing');
    }
    
    /**
     * Trang giới thiệu
     */
    public function about() {
        $data = [
            'title' => 'Giới thiệu - ' . APP_NAME,
            'page' => 'about'
        ];
        
        $this->view('about', $data);
    }
    
    /**
     * Trang hỏi đáp
     */
    public function qa() {
        $data = [
            'title' => 'Hỏi/Đáp - ' . APP_NAME,
            'page' => 'qa'
        ];
        
        $this->view('qa', $data);
    }
}
