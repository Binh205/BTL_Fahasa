<?php require_once APP_ROOT . '/views/admin/layout/header.php'; ?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Quản lý Sản phẩm</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= BASE_URL ?>admin/createProduct" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="fas fa-plus"></i> Thêm sản phẩm
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
                            <th>Ảnh</th>
                            <th>Tên sách</th>
                            <th>Giá bán</th>
                            <th>Giá gốc</th>
                            <th>Danh mục</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <img src="<?= BASE_URL . $p['image'] ?>" class="rounded" style="width: 40px; height: 50px; object-fit: cover;">
                            </td>
                            <td class="fw-bold"><?= htmlspecialchars($p['name']) ?></td>
                            <td class="text-danger fw-bold"><?= number_format($p['price']) ?>đ</td>
                            <td class="text-decoration-line-through text-muted"><?= number_format($p['old_price']) ?>đ</td>
                            <td><span class="badge bg-azure"><?= $p['category'] ?></span></td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">Sửa</a>
                                <a href="<?= BASE_URL ?>admin/deleteProduct?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">Xóa</a>
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