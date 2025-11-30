<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Trang Quản Trị</h1>
    <div class="list-group mt-4">
        <a href="<?= BASE_URL ?>admin/settings" class="list-group-item list-group-item-action">1. Quản lý Thông tin chung</a>
        <a href="<?= BASE_URL ?>admin/contacts" class="list-group-item list-group-item-action">2. Quản lý Liên hệ khách hàng</a>
        <a href="<?= BASE_URL ?>admin/pageContent?page=about" class="list-group-item list-group-item-action">3. Sửa nội dung trang Giới thiệu</a>
        <a href="<?= BASE_URL ?>admin/qa" class="list-group-item list-group-item-action">4. Quản lý Hỏi/Đáp (QA)</a>
    </div>
</div>
</body></html>