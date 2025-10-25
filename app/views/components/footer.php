    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h5>Về FAHASA</h5>
                        <ul class="list-unstyled">
                            <li><a href="<?= BASE_URL ?>home/about">Giới thiệu về Fahasa</a></li>
                            <li><a href="#">Tuyển dụng</a></li>
                            <li><a href="#">Chính sách bảo mật</a></li>
                            <li><a href="#">Điều khoản sử dụng</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Hỗ trợ khách hàng</h5>
                        <ul class="list-unstyled">
                            <li><a href="<?= BASE_URL ?>home/qa">Câu hỏi thường gặp</a></li>
                            <li><a href="#">Chính sách đổi trả</a></li>
                            <li><a href="#">Phương thức thanh toán</a></li>
                            <li><a href="#">Hướng dẫn mua hàng</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Liên hệ</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-map-marker-alt"></i> 60-62 Lê Lợi, Q.1, TP.HCM</li>
                            <li><i class="fas fa-phone"></i> 1900-6656</li>
                            <li><i class="fas fa-envelope"></i> info@fahasa.com</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5>Kết nối với chúng tôi</h5>
                        <div class="social-links">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                        </div>
                        <div class="mt-3">
                            <h6>Phương thức thanh toán</h6>
                            <div class="payment-methods">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="mb-0">&copy; 2024 <?= APP_NAME ?>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        .footer {
            background-color: var(--fahasa-dark);
            color: white;
            margin-top: 50px;
        }
        
        .footer-top {
            padding: 40px 0;
        }
        
        .footer h5 {
            color: var(--fahasa-orange);
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .footer h6 {
            color: white;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .footer ul li {
            margin-bottom: 10px;
        }
        
        .footer ul li a {
            color: #cccccc;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .footer ul li a:hover {
            color: var(--fahasa-orange);
        }
        
        .footer ul li i {
            margin-right: 8px;
            color: var(--fahasa-orange);
        }
        
        .social-links {
            display: flex;
            gap: 10px;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background-color: var(--fahasa-orange);
            color: white;
            transform: translateY(-3px);
        }
        
        .payment-methods i {
            font-size: 24px;
            margin-right: 10px;
            color: var(--fahasa-orange);
        }
        
        .footer-bottom {
            background-color: rgba(0,0,0,0.2);
            padding: 20px 0;
        }
        
        .footer-bottom p {
            color: #cccccc;
            font-size: 14px;
        }
    </style>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
