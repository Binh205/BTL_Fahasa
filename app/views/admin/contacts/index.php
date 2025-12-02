<?php require_once APP_ROOT . '/views/admin/layout/header.php'; ?>

<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Danh sách Hỏi/Đáp (Q&A)</h3>
            <a href="<?= BASE_URL ?>admin/createQa" class="btn btn-success d-none d-sm-inline-block">
                <i class="fas fa-plus me-1"></i> Thêm câu hỏi
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th class="w-1">ID</th>
                        <th>Câu hỏi</th>
                        <th>Câu trả lời</th>
                        <th>Danh mục</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($qaList)): ?>
                        <?php foreach($qaList as $qa): ?>
                        <tr>
                            <td><span class="text-secondary"><?= $qa['id'] ?></span></td>
                            <td class="text-wrap" style="max-width: 300px;">
                                <div class="font-weight-medium"><?= htmlspecialchars($qa['question']) ?></div>
                            </td>
                            <td class="text-wrap" style="max-width: 400px;">
                                <div class="text-secondary"><?= htmlspecialchars($qa['answer']) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-blue-lt"><?= htmlspecialchars($qa['category']) ?></span>
                            </td>
                            <td class="text-end">
                                <a href="<?= BASE_URL ?>admin/deleteQa?id=<?= $qa['id'] ?>" class="btn btn-danger btn-sm btn-icon" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Chưa có dữ liệu nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once APP_ROOT . '/views/admin/layout/footer.php'; ?>