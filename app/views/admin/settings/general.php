<div class="container mt-4">
    <h2>Cấu hình thông tin chung</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Hotline:</label>
            <input type="text" name="phone" class="form-control" value="<?= $settings['phone'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="text" name="email" class="form-control" value="<?= $settings['email'] ?? '' ?>">
        </div>
        <div class="mb-3">
            <label>Địa chỉ:</label>
            <input type="text" name="address" class="form-control" value="<?= $settings['address'] ?? '' ?>">
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="<?= BASE_URL ?>admin" class="btn btn-secondary">Quay lại</a>
    </form>
</div>