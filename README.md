# 📚 BTL FAHASA - Website Bán Sách Trực Tuyến

> Dự án Bài Tập Lớn môn Lập Trình Web - Xây dựng website bán sách trực tuyến sử dụng kiến trúc MVC thuần PHP

## 📋 Mô tả dự án

Website bán sách trực tuyến **BTL Fahasa** được xây dựng với các tính năng:

### 🎯 Chức năng cho Khách hàng

- 🔍 Tìm kiếm và lọc sản phẩm theo danh mục
- 📖 Xem chi tiết sản phẩm, sản phẩm liên quan (còn comment đánh giá)
- 🛒 Giỏ hàng: Thêm/Xóa/Cập nhật số lượng (đã xong)
- 👤 Đăng ký/Đăng nhập tài khoản (đã xong)
- 📦 Quản lý đơn hàng cá nhân (còn cập nhật đơn hàng của tôi)
- ❤️ Danh sách sản phẩm yêu thích
- 🔔 Thông báo đơn hàng và khuyến mãi
- 📰 Đọc tin tức, bài viết (Hiếu làm)
- ❓ Hỏi đáp (Nghi làm)

### 🔧 Chức năng cho Admin

- 📚 Quản lý sản phẩm (CRUD) (cơ bản xong)
- Quản lý đơn hàng (cơ bản xong)
-     Quản lý danh mục sản phẩm                                                                (cơ bản xong)
- 📰 Quản lý tin tức/bài viết (Hiếu làm)
- ❓ Quản lý câu hỏi/câu trả lời (Nghi làm)
- 📧 Quản lý khách hàng (cơ bản xong)
- ⚙️ Cấu hình thông tin website
- 📝 Chỉnh sửa nội dung trang tĩnh

### 💻 Công nghệ sử dụng

- **Backend:** PHP thuần (không framework)
- **Database:** MySQL/MariaDB
- **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript
- **Icon:** Font Awesome 6
- **Architecture:** MVC Pattern
- **Security:** PDO Prepared Statements, Password Hashing

---

## 🚀 Hướng dẫn cài đặt

### Yêu cầu hệ thống

- PHP >= 7.4
- MySQL/MariaDB
- Apache Server (hoặc XAMPP/WAMP/LAMP)
- Extension: PDO, PDO_MySQL

### Bước 1: Clone/Download dự án

```bash
# Clone từ Git
git clone https://github.com/Binh205/BTL_Fahasa.git

# Hoặc tải về và giải nén vào thư mục htdocs của XAMPP
# Ví dụ: C:/xampp/htdocs/BTL_Fahasa
```

### Bước 2: Import Database

1. Mở phpMyAdmin
2. Tạo database mới tên `fahasa`
3. Import file `db/fahasa.sql`

```sql
# Hoặc chạy lệnh SQL:
CREATE DATABASE fahasa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fahasa;
SOURCE db/fahasa.sql;
```

### Bước 3: Cấu hình Database

Mở file `app/config/config.php` và sửa thông tin database:

```php
// Dòng 10-15: Cấu hình database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');           // ← Sửa username MySQL của bạn
define('DB_PASS', '');               // ← Sửa password MySQL của bạn
define('DB_NAME', 'fahasa');         // ← Tên database
define('DB_PORT', 3307);             // ← Sửa port nếu khác (mặc định: 3306)

// Dòng 23: Sửa tên thư mục dự án
define('PROJECT_NAME', 'BTL_Fahasa'); // ← Tên thư mục trong htdocs
```

### Bước 4: Tạo thư mục upload (nếu chưa có)

```bash
# Tạo thư mục lưu ảnh upload
mkdir public/images/uploads
chmod 755 public/images/uploads
```

### Bước 5: Khởi động server

1. Bật **Apache** và **MySQL** trong XAMPP Control Panel
2. Truy cập: `http://localhost/BTL_Fahasa/public/`

### Bước 6: Đăng nhập Admin (tùy chọn)

Sau khi import database, sử dụng tài khoản admin:

```
Email/SĐT: admin@fahasa.com
Mật khẩu: (xem trong database hoặc tạo mới qua register)
```

---

## 📁 Cấu trúc thư mục

```
BTL_Fahasa/
├── app/                          # Thư mục chứa code chính
│   ├── config/
│   │   └── config.php           # Cấu hình database, URL, constants
│   ├── controllers/             # Controllers xử lý logic
│   │   ├── HomeController.php   # Trang chủ, giới thiệu, QA
│   │   ├── ProductController.php # Sản phẩm, chi tiết, tìm kiếm
│   │   ├── CartController.php   # Giỏ hàng
│   │   ├── AuthController.php   # Đăng nhập/Đăng ký
│   │   ├── CustomerController.php # Trang cá nhân khách hàng
│   │   ├── AdminController.php  # Quản trị viên
│   │   ├── NewsController.php   # Tin tức
│   │   ├── ContactController.php # Liên hệ
│   │   └── ...
│   ├── core/                    # Core classes của MVC
│   │   ├── App.php             # Router chính, xử lý URL
│   │   ├── Controller.php      # Base Controller
│   │   └── DB.php              # Database wrapper (PDO)
│   ├── models/                  # Models tương tác database
│   │   ├── User.php            # Model User
│   │   ├── Admin.php           # Model Admin
│   │   └── ...
│   ├── views/                   # Views hiển thị giao diện
│   │   ├── components/         # Header, Footer
│   │   ├── home.php            # Trang chủ
│   │   ├── product/            # Trang sản phẩm
│   │   ├── cart/               # Giỏ hàng
│   │   ├── auth/               # Đăng nhập/Đăng ký
│   │   ├── customer/           # Trang cá nhân
│   │   ├── admin/              # Admin panel
│   │   └── ...
│   └── router.php              # Load config và core classes
├── db/                          # Database files
│   └── fahasa.sql              # File SQL dump
├── public/                      # Thư mục public (document root)
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   ├── images/                 # Hình ảnh
│   │   └── uploads/           # Ảnh upload từ admin
│   ├── .htaccess              # URL rewriting
│   └── index.php              # Entry point
└── README.md                   # File này
```

## 🔗 Cấu trúc URL & Routing

### Trang công khai

| Chức năng         | URL                            | Controller        | Method    |
| ----------------- | ------------------------------ | ----------------- | --------- |
| Trang chủ         | `/public/` hoặc `/public/home` | HomeController    | index()   |
| Giới thiệu        | `/public/home/about`           | HomeController    | about()   |
| Hỏi/Đáp           | `/public/home/qa`              | HomeController    | qa()      |
| Liên hệ           | `/public/contact`              | ContactController | index()   |
| Sản phẩm          | `/public/product`              | ProductController | index()   |
| Chi tiết SP       | `/public/product/detail/1`     | ProductController | detail(1) |
| Tin tức           | `/public/news`                 | NewsController    | index()   |
| Chi tiết bài viết | `/public/news/detail/1`        | NewsController    | detail(1) |

### Giỏ hàng

| Chức năng         | URL                           | Method      |
| ----------------- | ----------------------------- | ----------- |
| Xem giỏ hàng      | `/public/cart`                | GET         |
| Cập nhật số lượng | `/public/cart/updateQuantity` | POST (AJAX) |
| Xóa sản phẩm      | `/public/cart/removeFromCart` | POST (AJAX) |

### Xác thực

| Chức năng | URL                     | Yêu cầu      |
| --------- | ----------------------- | ------------ |
| Đăng nhập | `/public/auth/login`    | -            |
| Đăng ký   | `/public/auth/register` | -            |
| Đăng xuất | `/public/auth/logout`   | Đã đăng nhập |

### Trang khách hàng (Yêu cầu đăng nhập)

| Chức năng           | URL                              |
| ------------------- | -------------------------------- |
| Thông tin tài khoản | `/public/customer`               |
| Đơn hàng của tôi    | `/public/customer/orders`        |
| Sản phẩm yêu thích  | `/public/customer/wishlist`      |
| Thông báo           | `/public/customer/notifications` |

### Trang Admin (Yêu cầu role='admin')

| Chức năng        | URL                      |
| ---------------- | ------------------------ |
| Dashboard        | `/public/admin`          |
| Quản lý sản phẩm | `/public/admin/products` |
| Quản lý tin tức  | `/public/admin/news`     |
| Quản lý Q&A      | `/public/admin/qa`       |
| Quản lý liên hệ  | `/public/admin/contacts` |
| Cấu hình         | `/public/admin/settings` |

---

## 🏗️ Kiến trúc MVC

### Flow hoạt động

```
User Request
    ↓
public/index.php (Entry point)
    ↓
app/router.php (Load config & core)
    ↓
app/core/App.php (Parse URL → Controller/Method/Params)
    ↓
app/controllers/*Controller.php (Xử lý logic)
    ↓
app/models/*.php (Tương tác database) ←→ Database
    ↓
app/views/*.php (Render giao diện)
    ↓
Response to User
```

### Core Classes

**1. App.php** - Router chính

- Parse URL thành `[controller, method, params]`
- Load controller tương ứng
- Gọi method với parameters
- Redirect về landing nếu không tìm thấy

**2. Controller.php** - Base Controller

- `model($name)` - Load model
- `view($view, $data)` - Render view
- `redirect($path)` - Chuyển hướng
- `isPost()`, `isGet()` - Kiểm tra request method

**3. DB.php** - Database wrapper

- PDO với prepared statements
- `query($sql, $params)` - Thực thi truy vấn
- `single($sql, $params)` - Lấy 1 dòng
- `all($sql, $params)` - Lấy tất cả dòng

---

## 🔒 Bảo mật

### Các biện pháp đã áp dụng

✅ **SQL Injection Prevention**

- Sử dụng PDO Prepared Statements
- Bind parameters cho mọi query

✅ **Password Security**

- Hash password với `password_hash()` (bcrypt)
- Verify với `password_verify()`

✅ **XSS Prevention**

- Escape output với `htmlspecialchars()` trong views
- Function helper `e($value)` trong header.php

✅ **Session Security**

- Session-based authentication
- Role-based access control (admin/user)
- Middleware check trong constructor của AdminController và CustomerController

✅ **CSRF Protection (Cần bổ sung)**

- Chưa implement CSRF token cho forms

---

## 📊 Cấu trúc Database

### Các bảng chính

```sql
users                    # Tài khoản người dùng
├── user_id (PK)
├── fullname
├── email
├── phone
├── password (hashed)
├── role (user/admin)
└── created_date

products                 # Sản phẩm
├── product_id (PK)
├── name
├── price
├── old_price
├── category
├── description
└── image

cart                     # Giỏ hàng
├── cart_id (PK)
├── customer_id (FK)
└── quantity

orders                   # Đơn hàng
├── order_id (PK)
├── customer_id (FK)
├── total
├── status
└── order_date

author_of_product        # Tác giả - Sản phẩm (N-N)
├── product_id (FK)
└── author_name

categorizes              # Phân loại danh mục
└── ...
```

---

## 🎨 Frontend Stack

### Libraries & Frameworks

- **Bootstrap 5.3** - CSS Framework
- **Font Awesome 6** - Icons
- **Google Fonts** - Roboto font
- **Vanilla JavaScript** - AJAX requests

### Color Scheme (Fahasa Style)

```css
--fahasa-red: #C92127      /* Màu đỏ chủ đạo */
--fahasa-orange: #F7941E   /* Màu cam phụ */
--fahasa-dark: #2C2C2C     /* Màu chữ */
--fahasa-gray: #666666     /* Màu phụ */
--fahasa-light-gray: #F5F5F5 /* Nền sáng */
```

---

## 📝 Quy ước đặt tên

### Controllers

- `{Name}Controller.php` - PascalCase, suffix "Controller"
- Method: `camelCase`

### Models

- `{Name}.php` - PascalCase, singular noun

### Views

- Folder: `snake_case` hoặc `kebab-case`
- File: `lowercase.php`

### Database

- Table: `snake_case`, plural
- Column: `snake_case`

---

## ⚙️ Lưu ý quan trọng

### Cấu hình

1. ✅ **Chỉ cần sửa** `app/config/config.php`
2. ✅ Tên thư mục phải khớp với `PROJECT_NAME`
3. ✅ Bật Apache + MySQL trong XAMPP
4. ✅ Import database `db/fahasa.sql` trước khi chạy
5. ✅ Tạo thư mục `public/images/uploads/` và chmod 755

### Session Cart

- Giỏ hàng lưu trong `$_SESSION['cart']`
- Format: `[product_id => quantity]`
- Không cần đăng nhập để thêm vào giỏ

### Admin Access

- Kiểm tra `$_SESSION['users_role'] === 'admin'` trong constructor
- Redirect về home nếu không phải admin

---

## 🆘 Xử lý lỗi thường gặp

### ❌ Lỗi "Failed to open stream" / "No such file"

**Nguyên nhân:** Sai tên thư mục hoặc sai cấu hình `PROJECT_NAME`

**Giải pháp:**

1. Kiểm tra tên thư mục trong htdocs: `C:/xampp/htdocs/BTL_Fahasa`
2. Mở `app/config/config.php`, sửa dòng 23:
   ```php
   define('PROJECT_NAME', 'BTL_Fahasa'); // Tên phải khớp với thư mục
   ```

---

### ❌ Lỗi "View does not exist"

**Nguyên nhân:** Đường dẫn view không đúng

**Giải pháp:**

1. Kiểm tra file view có tồn tại trong `app/views/`
2. Kiểm tra tên file view trong controller:
   ```php
   $this->view('product/index', $data); // ← Tìm app/views/product/index.php
   ```

---

### ❌ Lỗi "Connection failed" / Database error

**Nguyên nhân:** Chưa khởi động MySQL hoặc sai thông tin database

**Giải pháp:**

1. Bật MySQL trong XAMPP Control Panel
2. Kiểm tra port MySQL (mặc định 3306, có thể là 3307)
3. Mở `app/config/config.php`, kiểm tra:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');           // Password MySQL
   define('DB_NAME', 'fahasa');     // Tên database
   define('DB_PORT', 3307);         // Port (3306 hoặc 3307)
   ```
4. Đảm bảo đã import file `db/fahasa.sql` vào phpMyAdmin

---

### ❌ Lỗi "Call to undefined method"

**Nguyên nhân:** Model không có method được gọi

**Giải pháp:**

1. Kiểm tra method có tồn tại trong Model
2. Kiểm tra tên method có đúng không (phân biệt hoa/thường)

---

### ❌ Lỗi 404 / Blank page

**Nguyên nhân:** URL rewriting không hoạt động

**Giải pháp:**

1. Kiểm tra file `public/.htaccess` có tồn tại
2. Bật `mod_rewrite` trong Apache:
   - Mở `httpd.conf` trong XAMPP
   - Tìm dòng `#LoadModule rewrite_module modules/mod_rewrite.so`
   - Xóa dấu `#` để uncomment
   - Restart Apache

---

### ❌ Lỗi upload ảnh

**Nguyên nhân:** Thư mục uploads không tồn tại hoặc không có quyền ghi

**Giải pháp:**

1. Tạo thư mục: `public/images/uploads/`
2. Cấp quyền ghi (Linux/Mac):
   ```bash
   chmod 755 public/images/uploads
   ```
3. Windows: Click phải → Properties → Security → Cho phép Write

---

## 🚀 Phát triển tiếp

### Các tính năng cần bổ sung

- [ ] Tích hợp payment gateway (VNPay, MoMo)
- [ ] Email notification (PHPMailer)
- [ ] CSRF protection
- [ ] Rate limiting
- [ ] Search optimization (Full-text search)
- [ ] Product reviews & ratings
- [ ] Coupon/Voucher system
- [ ] Order tracking
- [ ] Export reports (Excel/PDF)
- [ ] RESTful API

### Cải tiến hiệu năng

- [ ] Caching (Redis, Memcached)
- [ ] Database indexing
- [ ] Image optimization
- [ ] Lazy loading
- [ ] CDN cho static assets

---

## 👥 Nhóm phát triển

- **Thành viên 1:** [Tên]
- **Thành viên 2:** [Tên]
- **Thành viên 3:** [Tên]

---

## 📄 License

Dự án này được phát triển cho mục đích học tập (Bài Tập Lớn môn Lập Trình Web).

---

## 📞 Liên hệ & Hỗ trợ

Nếu gặp vấn đề, vui lòng:

1. Kiểm tra phần **Xử lý lỗi thường gặp** ở trên
2. Tạo issue trên GitHub
3. Liên hệ team qua email

---

**🎉 Chúc bạn triển khai thành công!**
