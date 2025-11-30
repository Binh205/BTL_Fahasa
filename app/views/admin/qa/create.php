<div class="container mt-4">
    <h2>Thêm câu hỏi mới</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Câu hỏi:</label>
            <input type="text" name="question" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Trả lời:</label>
            <textarea name="answer" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Danh mục:</label>
            <select name="category" class="form-control">
                <option value="Chung">Chung</option>
                <option value="Thanh toán">Thanh toán</option>
                <option value="Vận chuyển">Vận chuyển</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu lại</button>
    </form>
</div>