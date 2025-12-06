<?php require_once APP_ROOT . '/views/admin/layout/header.php'; ?>

<div class="page-body">
    <div class="container-xl">
        <form action="" method="POST" enctype="multipart/form-data" class="card">
            <div class="card-header"><h3 class="card-title">Thêm bài viết mới</h3></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Tiêu đề bài viết</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Danh mục</label>
                        <select class="form-select" name="category">
                            <option value="kien-thuc">Kiến thức</option>
                            <option value="sach-hay">Sách hay</option>
                            <option value="hoat-dong">Hoạt động</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hình ảnh đại diện</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tóm tắt ngắn</label>
                    <textarea class="form-control" name="summary" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nội dung chi tiết (HTML)</label>
                    <textarea class="form-control" name="content" rows="10"></textarea>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="<?= BASE_URL ?>admin/news" class="btn btn-link">Hủy</a>
                <button type="submit" class="btn btn-primary">Đăng bài</button>
            </div>
        </form>
    </div>
</div>

<?php require_once APP_ROOT . '/views/admin/layout/footer.php'; ?>