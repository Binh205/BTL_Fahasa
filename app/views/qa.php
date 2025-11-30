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
    
    .qa-hero {
        background: linear-gradient(135deg, var(--fahasa-red) 0%, var(--fahasa-orange) 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 50px;
        border-radius: 10px;
        text-align: center;
    }
    
    .qa-hero h2 {
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .qa-hero p {
        font-size: 18px;
        margin-bottom: 30px;
    }
    
    .search-qa {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }
    
    .search-qa input {
        width: 100%;
        padding: 15px 60px 15px 20px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
    }
    
    .search-qa button {
        position: absolute;
        right: 5px;
        top: 5px;
        background-color: var(--fahasa-red);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 50px;
        cursor: pointer;
    }
    
    .search-qa button:hover {
        background-color: #a81b20;
    }
    
    .category-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    
    .category-tab {
        padding: 12px 25px;
        background-color: white;
        border: 2px solid var(--fahasa-light-gray);
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        color: var(--fahasa-dark);
        font-weight: 500;
    }
    
    .category-tab:hover,
    .category-tab.active {
        background-color: var(--fahasa-red);
        color: white;
        border-color: var(--fahasa-red);
    }
    
    .accordion-item {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
    }
    
    .accordion-button {
        background-color: white;
        color: var(--fahasa-dark);
        font-weight: 600;
        padding: 20px 25px;
        font-size: 16px;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: var(--fahasa-light-gray);
        color: var(--fahasa-red);
        box-shadow: none;
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: var(--fahasa-red);
    }
    
    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23C92127'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
    
    .accordion-body {
        padding: 20px 25px;
        color: var(--fahasa-gray);
        line-height: 1.8;
    }
    
    .contact-box {
        background: linear-gradient(135deg, var(--fahasa-red) 0%, var(--fahasa-orange) 100%);
        color: white;
        padding: 40px;
        border-radius: 10px;
        text-align: center;
        margin-top: 50px;
    }
    
    .contact-box h4 {
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .contact-box p {
        font-size: 16px;
        margin-bottom: 25px;
    }
    
    .contact-methods {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }
    
    .contact-method {
        background-color: rgba(255,255,255,0.2);
        padding: 20px 30px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    .contact-method:hover {
        background-color: rgba(255,255,255,0.3);
        transform: translateY(-3px);
    }
    
    .contact-method i {
        font-size: 32px;
        margin-bottom: 10px;
    }
    
    .contact-method .label {
        font-size: 14px;
        margin-bottom: 5px;
        opacity: 0.9;
    }
    
    .contact-method .value {
        font-size: 18px;
        font-weight: 600;
    }
    
    .popular-questions {
        background-color: var(--fahasa-light-gray);
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    
    .popular-questions h5 {
        color: var(--fahasa-red);
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    .popular-questions ul {
        list-style: none;
        padding: 0;
    }
    
    .popular-questions ul li {
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }
    
    .popular-questions ul li:last-child {
        border-bottom: none;
    }
    
    .popular-questions ul li a {
        color: var(--fahasa-dark);
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: color 0.3s;
    }
    
    .popular-questions ul li a:hover {
        color: var(--fahasa-red);
    }
    
    .popular-questions ul li a i {
        margin-right: 10px;
        color: var(--fahasa-orange);
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hỏi/Đáp</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Hero Section -->
<div class="container">
    <div class="qa-hero">
        <div class="container">
            <h2><i class="fas fa-question-circle"></i> Câu hỏi thường gặp</h2>
            <p>Tìm câu trả lời nhanh chóng cho các thắc mắc của bạn</p>
            <div class="search-qa">
                <input type="text" placeholder="Tìm kiếm câu hỏi...">
                <button type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <!-- Category Tabs -->
            <div class="category-tabs">
                <a href="#" class="category-tab active" data-category="all">
                    <i class="fas fa-th"></i> Tất cả
                </a>
                <a href="#" class="category-tab" data-category="order">
                    <i class="fas fa-shopping-cart"></i> Đặt hàng
                </a>
                <a href="#" class="category-tab" data-category="payment">
                    <i class="fas fa-credit-card"></i> Thanh toán
                </a>
                <a href="#" class="category-tab" data-category="shipping">
                    <i class="fas fa-truck"></i> Vận chuyển
                </a>
                <a href="#" class="category-tab" data-category="return">
                    <i class="fas fa-undo"></i> Đổi trả
                </a>
                <a href="#" class="category-tab" data-category="account">
                    <i class="fas fa-user"></i> Tài khoản
                </a>
            </div>
            
            <!-- Đặt hàng -->
            <h3 class="page-title">Về đặt hàng</h3>
            <div class="accordion" id="orderAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#order1">
                            <i class="fas fa-question-circle me-2"></i> Làm thế nào để đặt hàng trên website?
                        </button>
                    </h2>
                    <div id="order1" class="accordion-collapse collapse show" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            <strong>Các bước đặt hàng:</strong>
                            <ol>
                                <li>Tìm kiếm sản phẩm bạn muốn mua</li>
                                <li>Nhấn nút "Thêm vào giỏ hàng"</li>
                                <li>Vào giỏ hàng và kiểm tra lại đơn hàng</li>
                                <li>Nhấn "Thanh toán" và điền thông tin giao hàng</li>
                                <li>Chọn phương thức thanh toán và hoàn tất đơn hàng</li>
                            </ol>
                            Bạn sẽ nhận được email xác nhận đơn hàng sau khi đặt hàng thành công.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order2">
                            <i class="fas fa-question-circle me-2"></i> Tôi có thể đặt hàng qua điện thoại không?
                        </button>
                    </h2>
                    <div id="order2" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            Có, bạn có thể gọi đến hotline <strong>1900-6656</strong> để được hỗ trợ đặt hàng. 
                            Đội ngũ tư vấn viên của chúng tôi sẵn sàng phục vụ từ 8:00 - 22:00 hàng ngày.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#order3">
                            <i class="fas fa-question-circle me-2"></i> Tôi có thể hủy đơn hàng không?
                        </button>
                    </h2>
                    <div id="order3" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                        <div class="accordion-body">
                            Bạn có thể hủy đơn hàng trước khi đơn hàng được xác nhận và chuẩn bị giao. 
                            Vui lòng liên hệ ngay với bộ phận chăm sóc khách hàng qua hotline hoặc email để được hỗ trợ.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Thanh toán -->
            <h3 class="page-title mt-5">Về thanh toán</h3>
            <div class="accordion" id="paymentAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment1">
                            <i class="fas fa-question-circle me-2"></i> Có những phương thức thanh toán nào?
                        </button>
                    </h2>
                    <div id="payment1" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                        <div class="accordion-body">
                            <strong>Chúng tôi hỗ trợ các phương thức thanh toán sau:</strong>
                            <ul>
                                <li><strong>Thanh toán khi nhận hàng (COD):</strong> Thanh toán bằng tiền mặt khi nhận hàng</li>
                                <li><strong>Chuyển khoản ngân hàng:</strong> Chuyển khoản trực tiếp vào tài khoản công ty</li>
                                <li><strong>Thẻ ATM/Visa/Master:</strong> Thanh toán online qua cổng thanh toán</li>
                                <li><strong>Ví điện tử:</strong> MoMo, ZaloPay, VNPay</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment2">
                            <i class="fas fa-question-circle me-2"></i> Thanh toán online có an toàn không?
                        </button>
                    </h2>
                    <div id="payment2" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                        <div class="accordion-body">
                            Hoàn toàn an toàn! Chúng tôi sử dụng cổng thanh toán được mã hóa SSL 256-bit, 
                            đảm bảo thông tin thẻ của bạn được bảo mật tuyệt đối. Thông tin thanh toán không 
                            được lưu trữ trên hệ thống của chúng tôi.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Vận chuyển -->
            <h3 class="page-title mt-5">Về vận chuyển</h3>
            <div class="accordion" id="shippingAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping1">
                            <i class="fas fa-question-circle me-2"></i> Thời gian giao hàng là bao lâu?
                        </button>
                    </h2>
                    <div id="shipping1" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                        <div class="accordion-body">
                            <strong>Thời gian giao hàng dự kiến:</strong>
                            <ul>
                                <li><strong>Nội thành TP.HCM:</strong> 1-2 ngày làm việc</li>
                                <li><strong>Các tỉnh thành khác:</strong> 2-4 ngày làm việc</li>
                                <li><strong>Vùng xa, hải đảo:</strong> 4-7 ngày làm việc</li>
                            </ul>
                            Thời gian có thể thay đổi tùy theo điều kiện thực tế và thời tiết.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping2">
                            <i class="fas fa-question-circle me-2"></i> Phí vận chuyển là bao nhiêu?
                        </button>
                    </h2>
                    <div id="shipping2" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                        <div class="accordion-body">
                            <strong>Chính sách phí vận chuyển:</strong>
                            <ul>
                                <li><strong>Miễn phí:</strong> Đơn hàng từ 150.000đ trở lên</li>
                                <li><strong>30.000đ:</strong> Đơn hàng dưới 150.000đ (nội thành)</li>
                                <li><strong>40.000đ:</strong> Đơn hàng dưới 150.000đ (ngoại thành)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping3">
                            <i class="fas fa-question-circle me-2"></i> Làm thế nào để theo dõi đơn hàng?
                        </button>
                    </h2>
                    <div id="shipping3" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                        <div class="accordion-body">
                            Bạn có thể theo dõi đơn hàng bằng cách:
                            <ol>
                                <li>Đăng nhập vào tài khoản</li>
                                <li>Vào mục "Đơn hàng của tôi"</li>
                                <li>Xem chi tiết trạng thái đơn hàng</li>
                            </ol>
                            Hoặc sử dụng mã vận đơn trong email xác nhận để tra cứu trên website đơn vị vận chuyển.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Đổi trả -->
            <h3 class="page-title mt-5">Về đổi trả hàng</h3>
            <div class="accordion" id="returnAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return1">
                            <i class="fas fa-question-circle me-2"></i> Chính sách đổi trả như thế nào?
                        </button>
                    </h2>
                    <div id="return1" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                        <div class="accordion-body">
                            <strong>Điều kiện đổi trả:</strong>
                            <ul>
                                <li>Sản phẩm còn nguyên tem, mác, chưa qua sử dụng</li>
                                <li>Đổi trả trong vòng 7 ngày kể từ ngày nhận hàng</li>
                                <li>Có hóa đơn mua hàng hoặc đơn hàng điện tử</li>
                                <li>Sản phẩm bị lỗi từ nhà sản xuất</li>
                            </ul>
                            <strong>Lưu ý:</strong> Không áp dụng đổi trả với sách đã qua sử dụng hoặc có dấu hiệu hư hỏng do người dùng.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return2">
                            <i class="fas fa-question-circle me-2"></i> Quy trình đổi trả hàng?
                        </button>
                    </h2>
                    <div id="return2" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                        <div class="accordion-body">
                            <strong>Các bước đổi trả:</strong>
                            <ol>
                                <li>Liên hệ bộ phận CSKH qua hotline hoặc email</li>
                                <li>Cung cấp thông tin đơn hàng và lý do đổi trả</li>
                                <li>Đóng gói sản phẩm và gửi lại theo hướng dẫn</li>
                                <li>Chờ xác nhận và xử lý (2-3 ngày làm việc)</li>
                                <li>Nhận sản phẩm mới hoặc hoàn tiền</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Popular Questions -->
            <div class="popular-questions">
                <h5><i class="fas fa-fire"></i> Câu hỏi phổ biến</h5>
                <ul>
                    <li>
                        <a href="#order1" data-bs-toggle="collapse">
                            <i class="fas fa-chevron-right"></i>
                            Cách đặt hàng trên website
                        </a>
                    </li>
                    <li>
                        <a href="#payment1" data-bs-toggle="collapse">
                            <i class="fas fa-chevron-right"></i>
                            Phương thức thanh toán
                        </a>
                    </li>
                    <li>
                        <a href="#shipping1" data-bs-toggle="collapse">
                            <i class="fas fa-chevron-right"></i>
                            Thời gian giao hàng
                        </a>
                    </li>
                    <li>
                        <a href="#shipping2" data-bs-toggle="collapse">
                            <i class="fas fa-chevron-right"></i>
                            Phí vận chuyển
                        </a>
                    </li>
                    <li>
                        <a href="#return1" data-bs-toggle="collapse">
                            <i class="fas fa-chevron-right"></i>
                            Chính sách đổi trả
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Quick Links -->
            <div class="popular-questions">
                <h5><i class="fas fa-link"></i> Liên kết hữu ích</h5>
                <ul>
                    <li>
                        <a href="<?= BASE_URL ?>home/about">
                            <i class="fas fa-chevron-right"></i>
                            Giới thiệu về Fahasa
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Hướng dẫn mua hàng
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Chính sách bảo mật
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Điều khoản sử dụng
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Contact Box -->
    <div class="contact-box">
        <h4>Không tìm thấy câu trả lời?</h4>
        <p>Đừng lo lắng! Đội ngũ chăm sóc khách hàng của chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
        <div class="contact-methods">
            <div class="contact-method">
                <i class="fas fa-phone-alt"></i>
                <div class="label">Hotline</div>
                <div class="value">1900-6656</div>
            </div>
            <div class="contact-method">
                <i class="fas fa-envelope"></i>
                <div class="label">Email</div>
                <div class="value">support@fahasa.com</div>
            </div>
            <div class="contact-method">
                <i class="fab fa-facebook-messenger"></i>
                <div class="label">Messenger</div>
                <div class="value">m.me/fahasa</div>
            </div>
        </div>
    </div>
</div>

<script>
    // Category tab switching
    document.querySelectorAll('.category-tab').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Here you can add filtering logic based on data-category attribute
            const category = this.getAttribute('data-category');
            console.log('Selected category:', category);
        });
    });
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
