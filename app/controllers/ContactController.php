<?php
/**
 * CONTACT CONTROLLER
 * Trang Liên hệ
 */

class ContactController extends Controller {

    /**
     * Trang liên hệ chính
     */
    public function index() {
        $data = [
            'title' => 'Liên hệ - ' . APP_NAME,
            'page' => 'contact'
        ];

        $this->view('contact', $data);
    }

    /**
     * Xử lý gửi liên hệ
     */
    public function submit() {
        // Xử lý form liên hệ
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate dữ liệu đầu vào
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            // Validation
            $errors = [];
            
            if (empty($name)) {
                $errors['name'] = 'Vui lòng nhập họ tên';
            }
            
            if (empty($email)) {
                $errors['email'] = 'Vui lòng nhập email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email không hợp lệ';
            }
            
            if (empty($phone)) {
                $errors['phone'] = 'Vui lòng nhập số điện thoại';
            }
            
            if (empty($subject)) {
                $errors['subject'] = 'Vui lòng nhập tiêu đề';
            }
            
            if (empty($message)) {
                $errors['message'] = 'Vui lòng nhập nội dung';
            }

            if (empty($errors)) {
                // Gửi thông tin liên hệ (trong thực tế sẽ lưu vào DB hoặc gửi email)
                // Ở đây chỉ redirect về trang liên hệ với thông báo thành công
                
                $data = [
                    'title' => 'Liên hệ - ' . APP_NAME,
                    'page' => 'contact',
                    'success' => 'Cảm ơn bạn đã gửi liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.'
                ];
                
                $this->view('contact', $data);
            } else {
                // Trở lại trang liên hệ với lỗi
                $data = [
                    'title' => 'Liên hệ - ' . APP_NAME,
                    'page' => 'contact',
                    'errors' => $errors,
                    'old_data' => [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'subject' => $subject,
                        'message' => $message
                    ]
                ];
                
                $this->view('contact', $data);
            }
        } else {
            // Nếu không phải POST thì redirect về trang liên hệ
            header('Location: ' . BASE_URL . 'contact');
        }
    }
}