<div class="container mt-4">
    <h2>Danh sách liên hệ</h2>
    <table class="table table-bordered">
        <thead><tr><th>Tên</th><th>Email</th><th>Tin nhắn</th><th>Xóa</th></tr></thead>
        <tbody>
            <?php foreach($contacts as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['message']) ?></td>
                <td>
                    <form method="POST" action="<?= BASE_URL ?>admin/deleteContact" onsubmit="return confirm('Xóa?')">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?= BASE_URL ?>admin" class="btn btn-secondary">Quay lại</a>
</div>