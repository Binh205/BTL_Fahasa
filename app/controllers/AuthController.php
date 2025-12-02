<?php
// controllers/AuthController.php

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function login() {
        // 1. Nếu đã đăng nhập thì đá về trang tương ứng
        if (isset($_SESSION['users_id'])) {
            if (isset($_SESSION['users_role']) && $_SESSION['users_role'] === 'admin') {
                $this->redirect('admin');
            } else {
                $this->redirect('home');
            }
        }

        // 2. Xử lý khi bấm nút Đăng nhập (POST)
        if ($this->isPost()) {
            $emailOrPhone = trim($_POST['emailOrPhone'] ?? '');
            $password = $_POST['password'] ?? '';

            $errors = [];
            if ($emailOrPhone === '') $errors[] = 'Vui lòng nhập Email hoặc SĐT.';
            if ($password === '') $errors[] = 'Vui lòng nhập mật khẩu.';

            if (empty($errors)) {
                $userModel = $this->model('User'); 
                
                // Tìm user trong DB
                $user = $userModel->findUserByEmailOrPhone($emailOrPhone);

                // Kiểm tra mật khẩu
                if ($user && password_verify($password, $user['password'])) {
                    
                    // --- ĐĂNG NHẬP THÀNH CÔNG ---
                    $_SESSION['users_id'] = $user['id'];
                    $_SESSION['users_username'] = $user['username'];
                    $_SESSION['users_role'] = $user['role']; // QUAN TRỌNG CHO ADMIN

                    // Chuyển hướng đúng (Sửa lỗi Location /)
                    if ($user['role'] === 'admin') {
                        $this->redirect('admin');
                    } else {
                        $this->redirect('home');
                    }
                } else {
                    $errors[] = 'Tài khoản hoặc mật khẩu không đúng.';
                }
            }

            $data = [
                'errors' => $errors,
                'old' => ['emailOrPhone' => $emailOrPhone]
            ];
            $this->view('auth/login', $data);
        } 
        // 3. Hiển thị form (GET)
        else {
            $this->view('auth/login');
        }
    }

    // Hiển thị form đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $emailOrPhone = trim($_POST['emailOrPhone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirmPassword'] ?? '';

            $errors = [];
            if ($fullname === '') $errors[] = 'Vui lòng nhập họ và tên.';
            if ($emailOrPhone === '') $errors[] = 'Vui lòng nhập Email hoặc Số điện thoại.';
            if (strlen($password) < 6) $errors[] = 'Mật khẩu tối thiểu 6 ký tự.';
            if ($password !== $confirm) $errors[] = 'Mật khẩu xác nhận không khớp.';

            require_once APP_ROOT . '/models/User.php';
            $userModel = new User();

            // kiểm tra đã tồn tại
            if ($userModel->findUserByEmailOrPhone($emailOrPhone)) {
                $errors[] = 'Email hoặc Số điện thoại đã được sử dụng.';
            }

            if (empty($errors)) {
                $created = $userModel->create([
                    'fullname' => $fullname,
                    'email_or_phone' => $emailOrPhone,
                    'password' => $password, // model sẽ hash
                ]);

                if ($created) {
                    // tự động login hoặc chuyển tới trang login
                    header('Location: /auth/login');
                    exit;
                } else {
                    $errors[] = 'Có lỗi khi tạo tài khoản, thử lại sau.';
                }
            }

            $data = [
                'errors' => $errors,
                'old' => ['fullname' => $fullname, 'emailOrPhone' => $emailOrPhone],
            ];
            $this->view('auth/register', $data);
            return;
        }

        $this->view('auth/register');
    }

    // Logout
    public function logout() {
        if (!session_id()) session_start();
        session_destroy();
        $this->redirect('auth/login');
    }
}
