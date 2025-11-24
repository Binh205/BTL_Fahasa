<?php require_once APP_ROOT . '/views/components/header.php'; ?>

<style>
    .breadcrumb-section {
        background-color: var(--fahasa-light-gray);
        padding: 15px 0;
        margin-bottom: 30px;
    }

    .breadcrumb {
        background: none;
        margin-bottom: 0;
        padding: 0;
    }

    .breadcrumb-item a {
        color: var(--fahasa-gray);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: var(--fahasa-red);
    }

    .breadcrumb-item.active {
        color: var(--fahasa-dark);
    }

    .page-title {
        color: var(--fahasa-red);
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background-color: var(--fahasa-orange);
    }

    .contact-hero {
        background: linear-gradient(135deg, var(--fahasa-red) 0%, var(--fahasa-orange) 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 50px;
        border-radius: 10px;
        text-align: center;
    }

    .contact-hero h2 {
        font-weight: 700;
        margin-bottom: 20px;
    }

    .contact-hero p {
        font-size: 18px;
        margin-bottom: 0;
    }

    .contact-info {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        background-color: var(--fahasa-light-gray);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .contact-icon i {
        font-size: 24px;
        color: var(--fahasa-red);
    }

    .contact-details h5 {
        color: var(--fahasa-red);
        font-weight: 600;
        margin-bottom: 5px;
    }

    .contact-details p {
        color: var(--fahasa-gray);
        margin-bottom: 0;
        line-height: 1.6;
    }

    .contact-form {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 500;
        color: var(--fahasa-dark);
        margin-bottom: 8px;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 12px 15px;
    }

    .form-control:focus {
        border-color: var(--fahasa-red);
        box-shadow: 0 0 0 0.2rem rgba(201, 33, 39, 0.25);
    }

    .form-control.error {
        border-color: #dc3545;
    }

    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }

    .btn-submit {
        background-color: var(--fahasa-red);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #a81b20;
    }

    .contact-map {
        height: 300px;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .map-placeholder {
        width: 100%;
        height: 100%;
        background-color: var(--fahasa-light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--fahasa-gray);
        font-size: 18px;
    }

    .social-contacts {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: var(--fahasa-light-gray);
        color: var(--fahasa-dark);
        text-decoration: none;
        transition: all 0.3s;
    }

    .social-btn:hover {
        background-color: var(--fahasa-red);
        color: white;
        transform: translateY(-3px);
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border: 1px solid #c3e6cb;
    }

    .hours-table {
        width: 100%;
        border-collapse: collapse;
    }

    .hours-table th,
    .hours-table td {
        padding: 8px 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .hours-table th {
        color: var(--fahasa-red);
        font-weight: 600;
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="contact-hero">
        <h2><i class="fas fa-phone-alt"></i> Liên hệ với chúng tôi</h2>
        <p>Tiệm sách FAHASA - Nơi chia sẻ tri thức, lan tỏa yêu thương</p>
    </div>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-md-5">
            <div class="contact-info">
                <h3 class="page-title mb-4">Thông tin liên hệ</h3>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Địa chỉ</h5>
                        <p>60 - 62 Lê Lợi, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh</p>
                        <p>123 Nguyễn Trãi, Phường Nguyễn Cư Trinh, Quận 1, TP. Hồ Chí Minh</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Điện thoại</h5>
                        <p>Hotline: 1900 636 099</p>
                        <p>Bộ phận chăm sóc khách hàng: (028) 3920 7999</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Email</h5>
                        <p>info@fahasa.com.vn</p>
                        <p>hotro@fahasa.com.vn</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Thời gian làm việc</h5>
                        <table class="hours-table">
                            <tr>
                                <td>Thứ 2 - Thứ 6</td>
                                <td>8:00 - 21:00</td>
                            </tr>
                            <tr>
                                <td>Thứ 7 - Chủ nhật</td>
                                <td>8:00 - 22:00</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="social-contacts">
                    <a href="#" class="social-btn" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-btn" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-btn" title="Zalo">
                        <i class="fab fa-zalo"></i>
                    </a>
                    <a href="#" class="social-btn" title="Youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Map -->
            <div class="contact-map">
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i> Bản đồ vị trí cửa hàng
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-7">
            <div class="contact-form">
                <h3 class="page-title mb-4">Gửi yêu cầu liên hệ</h3>
                
                <?php if (isset($success)): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= BASE_URL ?>contact/submit" id="contactForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['name']) ? 'error' : '' ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?= htmlspecialchars($old_data['name'] ?? '') ?? '' ?>" 
                                       placeholder="Nhập họ tên của bạn">
                                <?php if (isset($errors['name'])): ?>
                                    <div class="error-message"><?= $errors['name'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control <?= isset($errors['email']) ? 'error' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?= htmlspecialchars($old_data['email'] ?? '') ?? '' ?>" 
                                       placeholder="Nhập địa chỉ email">
                                <?php if (isset($errors['email'])): ?>
                                    <div class="error-message"><?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= isset($errors['phone']) ? 'error' : '' ?>" 
                               id="phone" 
                               name="phone" 
                               value="<?= htmlspecialchars($old_data['phone'] ?? '') ?? '' ?>" 
                               placeholder="Nhập số điện thoại">
                        <?php if (isset($errors['phone'])): ?>
                            <div class="error-message"><?= $errors['phone'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= isset($errors['subject']) ? 'error' : '' ?>" 
                               id="subject" 
                               name="subject" 
                               value="<?= htmlspecialchars($old_data['subject'] ?? '') ?? '' ?>" 
                               placeholder="Nhập tiêu đề">
                        <?php if (isset($errors['subject'])): ?>
                            <div class="error-message"><?= $errors['subject'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                        <textarea class="form-control <?= isset($errors['message']) ? 'error' : '' ?>" 
                                  id="message" 
                                  name="message" 
                                  rows="5" 
                                  placeholder="Nhập nội dung tin nhắn của bạn"><?= htmlspecialchars($old_data['message'] ?? '') ?? '' ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <div class="error-message"><?= $errors['message'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Gửi yêu cầu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Real-time form validation
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        let isValid = true;
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const subject = document.getElementById('subject').value.trim();
        const message = document.getElementById('message').value.trim();
        
        // Clear previous error messages
        const errorElements = document.querySelectorAll('.error-message');
        errorElements.forEach(el => el.parentNode.removeChild(el));
        
        // Validate name
        if (!name) {
            addErrorMessage('name', 'Vui lòng nhập họ tên');
            isValid = false;
        }
        
        // Validate email
        if (!email) {
            addErrorMessage('email', 'Vui lòng nhập email');
            isValid = false;
        } else if (!isValidEmail(email)) {
            addErrorMessage('email', 'Email không hợp lệ');
            isValid = false;
        }
        
        // Validate phone
        if (!phone) {
            addErrorMessage('phone', 'Vui lòng nhập số điện thoại');
            isValid = false;
        } else if (!isValidPhone(phone)) {
            addErrorMessage('phone', 'Số điện thoại không hợp lệ');
            isValid = false;
        }
        
        // Validate subject
        if (!subject) {
            addErrorMessage('subject', 'Vui lòng nhập tiêu đề');
            isValid = false;
        }
        
        // Validate message
        if (!message) {
            addErrorMessage('message', 'Vui lòng nhập nội dung');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });

    function addErrorMessage(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        field.classList.add('error');
        field.parentNode.appendChild(errorDiv);
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidPhone(phone) {
        const phoneRegex = /^[0-9]{10,11}$/;
        return phoneRegex.test(phone);
    }
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>