<div class="container mt-4">
    <h2>Chỉnh sửa trang: <?= ucfirst($currPage) ?></h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Nội dung bài viết:</label>
            <textarea name="content" rows="10" class="form-control"><?= htmlspecialchars($content) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật nội dung</button>
        <a href="<?= BASE_URL ?>admin" class="btn btn-secondary">Quay lại</a>
    </form>
</div>