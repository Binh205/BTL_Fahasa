<?php
/**
 * File cấu hình chính của ứng dụng
 * Chứa tất cả các thiết lập và hằng số toàn cục
 */

// =================================
// CẤU HÌNH DATABASE
// =================================
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fahasa_db');

// =================================
// CẤU HÌNH ỨNG DỤNG
// =================================
define('APP_NAME', 'BTL FAHASA');
define('BASE_URL', 'http://localhost/BTL_FAHASA/public/');
define('APP_ROOT', dirname(dirname(__FILE__))); // Đường dẫn gốc của app/

// =================================
// CẤU HÌNH MÔI TRƯỜNG
// =================================
define('ENVIRONMENT', 'development');

// Bật/tắt hiển thị lỗi
if(ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// =================================
// CẤU HÌNH KHÁC
// =================================
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Múi giờ VN
define('CHARSET', 'UTF-8');