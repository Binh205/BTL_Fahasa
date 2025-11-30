<?php
// controllers/AuthController.php

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emailOrPhone = trim($_POST['emailOrPhone'] ?? '');
            $password = $_POST['password'] ?? '';

            // simple server-side validation
            $errors = [];
            if ($emailOrPhone === '') $errors[] = 'Vui lòng nhập Email hoặc Số điện thoại.';
            if ($password === '') $errors[] = 'Vui lòng nhập mật khẩu.';

            if (empty($errors)) {
                require_once APPROOT . '/models/User.php';
                $userModel = new User();
                $user = $userModel->findByEmailOrPhone($emailOrPhone);

                if ($user && password_verify($password, $user['password'])) {
                    // login success: set session
                    session_regenerate_id(true);
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['fullname'] ?? $user['email'],
                        'email' => $user['email'] ?? '',
                    ];
                    // redirect về trang chủ hoặc trang trước đó
                    header('Location: /');
                    exit;
                } else {
                    $errors[] = 'Email/SĐT hoặc mật khẩu không đúng.';
                }
            }

            $data = [
                'errors' => $errors,
                'old' => ['emailOrPhone' => $emailOrPhone],
            ];
            $this->view('auth/login', $data);
            return;
        }

        // GET: show login form
        $this->view('auth/login');
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

            require_once APPROOT . '/models/User.php';
            $userModel = new User();

            // kiểm tra đã tồn tại
            if ($userModel->findByEmailOrPhone($emailOrPhone)) {
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
    public function logout()
    {
        session_start();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: /');
        exit;
    }
}
