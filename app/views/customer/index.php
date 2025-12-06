<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<style>
    .customer-container {
        padding: 40px 0;
        background-color: #f8f9fa;
        min-height: calc(100vh - 200px);
    }
    
    .customer-content {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 30px;
    }
    
    .page-title {
        color: var(--fahasa-dark);
        font-weight: 700;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--fahasa-light-gray);
    }
    
    .page-title i {
        color: var(--fahasa-red);
        margin-right: 10px;
    }
    
    .profile-form .form-label {
        font-weight: 500;
        color: var(--fahasa-dark);
        margin-bottom: 8px;
    }
    
    .profile-form .form-control,
    .profile-form .form-select {
        border: 1px solid #ddd;
        padding: 10px 15px;
        border-radius: 6px;
    }
    
    .profile-form .form-control:focus,
    .profile-form .form-select:focus {
        border-color: var(--fahasa-orange);
        box-shadow: 0 0 0 0.2rem rgba(247, 148, 30, 0.25);
    }
    
    .btn-save {
        background-color: var(--fahasa-red);
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-save:hover {
        background-color: #a51b1f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(201, 33, 39, 0.3);
    }
    
    .btn-cancel {
        background-color: var(--fahasa-gray);
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-cancel:hover {
        background-color: #555;
    }
    
    .info-card {
        background: var(--fahasa-light-gray);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .info-card-title {
        font-weight: 600;
        color: var(--fahasa-dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    
    .info-card-title i {
        color: var(--fahasa-orange);
        margin-right: 10px;
    }
</style>

<div class="customer-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <?php require_once APP_ROOT . '/views/customer/sidebar.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="customer-content">
                    <h2 class="page-title">
                        <i class="fas fa-user"></i>
                        Thông tin tài khoản
                    </h2>
                    
                    <!-- Account Info Card -->
                    <div class="info-card">
                        <div class="info-card-title">
                            <i class="fas fa-info-circle"></i>
                            Thông tin cơ bản
                        </div>
                        <p class="mb-0 text-muted">
                            Quản lý thông tin hồ sơ để bảo mật tài khoản của bạn
                        </p>
                    </div>
                    
                    <!-- Profile Form -->
                    <form class="profile-form" id="profileForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Họ và tên *</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" 
                                       value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Giới tính</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="male" <?= ($user['gender'] ?? 'male') === 'male' ? 'selected' : '' ?>>Nam</option>
                                    <option value="female" <?= ($user['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
                                    <option value="other" <?= ($user['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Khác</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birthday" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" 
                                       value="<?= htmlspecialchars($user['birthday'] ?? '') ?>">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thành viên từ</label>
                                <input type="text" class="form-control" 
                                       value="<?= date('d/m/Y', strtotime($user['created_at'] ?? 'now')) ?>" readonly disabled>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="mt-4 d-flex gap-3">
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                            <button type="button" class="btn btn-cancel" onclick="window.location.reload()">
                                <i class="fas fa-times me-2"></i>Hủy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simulate save
    const btn = this.querySelector('.btn-save');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang lưu...';
    btn.disabled = true;
    
    setTimeout(function() {
        btn.innerHTML = '<i class="fas fa-check me-2"></i>Đã lưu!';
        
        // Show success alert
        const alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show mt-3';
        alert.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            Cập nhật thông tin thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.querySelector('.profile-form').insertBefore(alert, document.querySelector('.profile-form').firstChild);
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert.remove();
        }, 2000);
    }, 1500);
});
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
