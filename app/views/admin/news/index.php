<?php require_once APP_ROOT . '/views/admin/layout/header.php'; ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Quản lý Tin tức</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= BASE_URL ?>admin/createNews" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Thêm bài viết
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th class="w-1">ID</th>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Danh mục</th>
                            <th>Ngày đăng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($articles as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td>
                                <img src="<?= BASE_URL . $item['image'] ?>" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td class="text-wrap" style="max-width: 300px;">
                                <div class="font-weight-medium"><?= htmlspecialchars($item['title']) ?></div>
                                <div class="text-muted small text-truncate"><?= htmlspecialchars($item['summary']) ?></div>
                            </td>
                            <td><span class="badge bg-green-lt"><?= $item['category'] ?></span></td>
                            <td><?= date('d/m/Y', strtotime($item['published_date'])) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>admin/editNews?id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">Sửa</a>
                                <a href="<?= BASE_URL ?>admin/deleteNews?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_ROOT . '/views/admin/layout/footer.php'; ?>