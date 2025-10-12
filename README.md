# 📚 BTL FAHASA - Framework MVC PHP

## 🚀 Hướng dẫn cài đặt cho thành viên

### Bước 1: Clone/Download dự án
```bash
# Tải về và giải nén vào thư mục htdocs của XAMPP
# Ví dụ: C:/xampp/htdocs/BTL_Fahasa
```

### Bước 2: Cấu hình (CHỈ SỬA 1 FILE!)

Mở file `app/config/config.php` và sửa:

```php
// Dòng 13: Sửa tên thư mục của bạn
define('PROJECT_NAME', 'BTL_Fahasa'); // ← Đổi thành tên thư mục của bạn

// Dòng 5-8: Sửa thông tin database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fahasa_db'); // ← Đổi tên database
```

### Bước 3: Tạo database
```sql
CREATE DATABASE fahasa_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Bước 4: Truy cập
```
http://localhost/BTL_Fahasa/public/
```

## 📁 Cấu trúc thư mục

```
BTL_Fahasa/
├── app/
│   ├── config/
│   │   └── config.php          ← CHỈ SỬA FILE NÀY!
│   ├── controllers/
│   │   └── HomeController.php
│   ├── core/
│   │   ├── App.php
│   │   ├── Controller.php
│   │   └── DB.php
│   ├── models/
│   ├── views/
│   └── router.php
└── public/
    ├── css/
    ├── js/
    ├── images/
    ├── .htaccess
    └── index.php
```

## 🔗 URL Routing

- Trang chủ: `http://localhost/BTL_Fahasa/public/`
- Giới thiệu: `http://localhost/BTL_Fahasa/public/home/about`
- Sản phẩm: `http://localhost/BTL_Fahasa/public/product`

## ⚙️ Lưu ý quan trọng

1. ✅ **Chỉ cần sửa** `app/config/config.php`
2. ✅ Tên thư mục phải khớp với `PROJECT_NAME`
3. ✅ Bật Apache + MySQL trong XAMPP
4. ✅ Tạo database trước khi chạy

## 🆘 Xử lý lỗi thường gặp

### Lỗi "Failed to open stream"
→ Kiểm tra `PROJECT_NAME` trong config.php

### Lỗi "View does not exist"
→ Kiểm tra đường dẫn view có đúng không

### Lỗi database
→ Kiểm tra MySQL đã chạy chưa, database đã tạo chưa