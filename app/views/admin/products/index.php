

<style>
    .admin-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .card-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e0e0e0;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #c92127;
        color: white;
    }

    .btn-primary:hover {
        background: #a01b20;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f8f9fa;
    }

    th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e0e0e0;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .bg-success {
        background: #10b981;
        color: white;
    }

    .bg-danger {
        background: #ef4444;
        color: white;
    }

    .bg-azure {
        background: #4299e1;
        color: white;
    }

    .bg-secondary {
        background: #94a3b8;
        color: white;
    }

    .text-danger {
        color: #c92127;
    }

    .text-decoration-line-through {
        text-decoration: line-through;
    }

    .text-muted {
        color: #94a3b8;
    }

    .fw-bold {
        font-weight: 600;
    }

    .rounded {
        border-radius: 6px;
    }

    .text-center {
        text-align: center;
    }
</style>

<div class="admin-card">
    <div class="card-header-actions">
        <h2 class="card-title">Danh sách sản phẩm</h2>
        <a href="<?= BASE_URL ?>admin/createProduct" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm sản phẩm
        </a>
    </div>

    <div class="table-container">
        <table>
                    <thead>
                        <tr>
                            <th class="w-1">ID</th>
                            <th>Ảnh</th>
                            <th>Tên sách</th>
                            <th>Tác giả</th>
                            <th>Giá bán</th>
                            <th>Giá gốc</th>
                            <th>Tồn kho</th>
                            <th>Danh mục</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach($products as $p): ?>
                            <tr>
                                <td><?= $p['product_id'] ?></td>
                                <td>
                                    <?php if (!empty($p['image_url'])): ?>
                                        <img src="<?= BASE_URL . $p['image_url'] ?>" class="rounded" style="width: 40px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>images/default-book.jpg" class="rounded" style="width: 40px; height: 50px; object-fit: cover;">
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?= htmlspecialchars($p['title']) ?></td>
                                <td><?= htmlspecialchars($p['author'] ?? 'N/A') ?></td>
                                <td class="text-danger fw-bold"><?= number_format($p['price']) ?>đ</td>
                                <td class="text-decoration-line-through text-muted">
                                    <?= $p['old_price'] ? number_format($p['old_price']) . 'đ' : '-' ?>
                                </td>
                                <td>
                                    <span class="badge <?= $p['stock_quantity'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $p['stock_quantity'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($p['category_name'])): ?>
                                        <span class="badge bg-azure"><?= htmlspecialchars($p['category_name']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Chưa phân loại</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>admin/editProduct/<?= $p['product_id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="<?= BASE_URL ?>admin/deleteProduct?id=<?= $p['product_id'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">Chưa có sản phẩm nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
        </table>
    </div>
</div>
