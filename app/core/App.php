<?php
/**
 * APP CLASS - Xử lý routing và khởi tạo controller
 */

class App {
    protected $controller = "LandingController"; // Trang mặc định
    protected $method = "index";
    protected $params = [];

    public function __construct() {
        // đảm bảo session đã bắt đầu (nhiều phần khác phụ thuộc vào session)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $url = $this->parseURL();

        // --- Xử lý Controller ---
        if (isset($url[0]) && !empty($url[0])) {
            // sanitize segment: chỉ chấp nhận a-z A-Z 0-9 - _
            $controllerSegment = preg_replace('/[^a-zA-Z0-9\-_]/', '', $url[0]);

            // chuẩn tên file controller theo cấu trúc: <Ucfirst(segment)>Controller.php
            $expectedControllerFile = APP_ROOT . '/controllers/' . ucfirst($controllerSegment) . 'Controller.php';
            $foundControllerFile = '';

            // nếu file tồn tại chính xác
            if (file_exists($expectedControllerFile)) {
                $foundControllerFile = $expectedControllerFile;
                $this->controller = ucfirst($controllerSegment) . 'Controller';
                unset($url[0]);
            } else {
                // Thử lookup case-insensitive trong thư mục controllers
                $controllersDir = APP_ROOT . '/controllers';
                if (is_dir($controllersDir)) {
                    $files = scandir($controllersDir);
                    $needle = strtolower(ucfirst($controllerSegment) . 'controller.php');
                    foreach ($files as $f) {
                        if (is_file($controllersDir . '/' . $f) && strtolower($f) === $needle) {
                            $foundControllerFile = $controllersDir . '/' . $f;
                            // lấy class name từ file: giữ quy ước ucfirst(segment) . 'Controller'
                            $this->controller = pathinfo($f, PATHINFO_FILENAME); // tên file không có .php
                            unset($url[0]);
                            break;
                        }
                    }
                }
            }

            // nếu không tìm thấy file controller → redirect về landing
            if (empty($foundControllerFile)) {
                $this->redirectToLanding();
                return;
            }

            // Load controller file
            require_once $foundControllerFile;
        } else {
            // Không có segment -> load default controller file
            $defaultFile = APP_ROOT . '/controllers/' . $this->controller . '.php';
            if (!file_exists($defaultFile)) {
                // nếu file default không tồn tại -> 500 hoặc redirect landing
                $this->redirectToLanding();
                return;
            }
            require_once $defaultFile;
        }

        // instantiate controller class (giữ nguyên tên thuộc tính $this->controller)
        if (!class_exists($this->controller)) {
            // nếu class không tồn tại trong file (có thể tên class khác) -> redirect landing
            $this->redirectToLanding();
            return;
        }

        $this->controller = new $this->controller;

        // --- Xử lý Method ---
        if (isset($url[1]) && !empty($url[1])) {
            $methodSegment = preg_replace('/[^a-zA-Z0-9\-_]/', '', $url[1]);
            if (method_exists($this->controller, $methodSegment)) {
                $this->method = $methodSegment;
                unset($url[1]);
            } else {
                // Method không tồn tại -> chuyển về landing
                $this->redirectToLanding();
                return;
            }
        }

        // --- Xử lý Parameters ---
        $this->params = $url ? array_values($url) : [];

        // --- Gọi controller -> method với params (giới hạn tham số theo Reflection) ---
        try {
            $ref = new ReflectionMethod($this->controller, $this->method);
            $expectedParamsCount = $ref->getNumberOfParameters();
            // chỉ truyền tối đa số params method cần
            $callParams = array_slice($this->params, 0, $expectedParamsCount);

            call_user_func_array([$this->controller, $this->method], $callParams);
        } catch (ReflectionException $re) {
            // Nếu method không tồn tại hay Reflection lỗi: redirect landing
            $this->redirectToLanding();
            return;
        } catch (Throwable $t) {
            // Hiện thông báo lỗi để debug (ở production bạn có thể ghi log và hiển thị trang lỗi)
            http_response_code(500);
            echo "<h1>500 Internal Server Error</h1>";
            echo "<pre>" . htmlspecialchars($t->getMessage()) . "</pre>";
            return;
        }
    }

    /**
     * Parse URL thành mảng
     */
    private function parseURL() {
        if (isset($_GET["url"])) {
            // Loại bỏ trailing slash, sanitize toàn bộ url trước khi explode
            $raw = rtrim($_GET['url'], '/');
            // Loại bỏ ký tự lạ, nhưng giữ / để explode
            $raw = filter_var($raw, FILTER_SANITIZE_URL);
            // explode và decode từng phần
            $parts = explode('/', $raw);
            $cleanParts = [];
            foreach ($parts as $p) {
                $p = trim($p);
                if ($p === '') continue;
                // urldecode và only allow certain chars (để an toàn)
                $p = urldecode($p);
                $p = preg_replace('/[^\p{L}\p{N}\-_\.]/u', '', $p); // cho phép chữ unicode, số, -, _, .
                if ($p !== '') $cleanParts[] = $p;
            }
            return $cleanParts;
        }
        return [];
    }

    /**
     * Chuyển về trang landing khi lỗi
     */
    private function redirectToLanding() {
        // Giữ nguyên hành vi cũ: dùng BASE_URL . 'landing'
        if (defined('BASE_URL')) {
            header('Location: ' . BASE_URL . 'landing');
        } else {
            // nếu BASE_URL chưa định nghĩa, redirect relative
            header('Location: /landing');
        }
        exit();
    }
}
