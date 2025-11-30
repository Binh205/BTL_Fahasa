<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Danh sách Hỏi/Đáp</h2>
        <a href="<?= BASE_URL ?>admin/createQa" class="btn btn-success">Thêm câu hỏi</a>
    </div>
    <table class="table table-bordered mt-3">
        <thead><tr><th>Câu hỏi</th><th>Trả lời</th><th>Danh mục</th><th>Thao tác</th></tr></thead>
        <tbody>
            <?php foreach($qaList as $qa): ?>
            <tr>
                <td><?= htmlspecialchars($qa['question']) ?></td>
                <td><?= htmlspecialchars($qa['answer']) ?></td>
                <td><?= htmlspecialchars($qa['category']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>admin/deleteQa?id=<?= $qa['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa?')">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= BASE_URL ?>admin" class="btn btn-secondary">Quay lại</a>
</div>