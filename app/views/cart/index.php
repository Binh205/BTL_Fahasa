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

    .cart-container {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
        margin-bottom: 50px;
    }

    .cart-items {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .cart-header {
        background-color: var(--fahasa-light-gray);
        padding: 15px 20px;
        font-weight: 600;
        border-bottom: 2px solid var(--fahasa-red);
    }

    .cart-item {
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 20px;
        padding: 20px;
        border-bottom: 1px solid var(--fahasa-light-gray);
        align-items: center;
        transition: background-color 0.3s;
    }

    .cart-item:hover {
        background-color: #fafafa;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 100px;
        height: 130px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        overflow: hidden;
    }

    .item-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .item-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .item-title {
        font-weight: 600;
        color: var(--fahasa-dark);
        font-size: 1rem;
        line-height: 1.4;
    }

    .item-author {
        color: var(--fahasa-gray);
        font-size: 0.9rem;
    }

    .item-price {
        color: var(--fahasa-red);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .item-old-price {
        color: #999;
        text-decoration: line-through;
        font-size: 0.9rem;
        margin-left: 8px;
    }

    .item-controls {
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: flex-end;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-btn {
        width: 32px;
        height: 32px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .quantity-btn:hover {
        background-color: var(--fahasa-red);
        color: white;
        border-color: var(--fahasa-red);
    }

    .quantity-input {
        width: 60px;
        height: 32px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-weight: 600;
    }

    .item-subtotal {
        font-weight: 700;
        color: var(--fahasa-dark);
        font-size: 1.1rem;
    }

    .remove-btn {
        background: none;
        border: none;
        color: var(--fahasa-gray);
        cursor: pointer;
        font-size: 0.9rem;
        transition: color 0.3s;
    }

    .remove-btn:hover {
        color: var(--fahasa-red);
    }

    .cart-summary {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 25px;
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    .summary-title {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--fahasa-dark);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--fahasa-light-gray);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: var(--fahasa-dark);
    }

    .summary-label {
        color: var(--fahasa-gray);
    }

    .summary-value {
        font-weight: 600;
    }

    .summary-discount {
        color: var(--fahasa-red);
    }

    .summary-total {
        border-top: 2px solid var(--fahasa-light-gray);
        padding-top: 15px;
        margin-top: 15px;
        font-size: 1.3rem;
    }

    .summary-total .summary-label {
        color: var(--fahasa-dark);
        font-weight: 700;
    }

    .summary-total .summary-value {
        color: var(--fahasa-red);
        font-weight: 700;
    }

    .checkout-btn {
        width: 100%;
        background-color: var(--fahasa-red);
        color: white;
        border: none;
        padding: 15px 20px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .checkout-btn:hover {
        background-color: #a81b20;
    }

    .continue-shopping {
        width: 100%;
        background-color: white;
        color: var(--fahasa-red);
        border: 2px solid var(--fahasa-red);
        padding: 12px 20px;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .continue-shopping:hover {
        background-color: var(--fahasa-red);
        color: white;
    }

    .empty-cart {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .empty-cart i {
        font-size: 80px;
        color: var(--fahasa-light-gray);
        margin-bottom: 20px;
    }

    .empty-cart h3 {
        color: var(--fahasa-dark);
        margin-bottom: 10px;
    }

    .empty-cart p {
        color: var(--fahasa-gray);
        margin-bottom: 30px;
    }

    .shop-now-btn {
        display: inline-block;
        background-color: var(--fahasa-red);
        color: white;
        padding: 12px 30px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .shop-now-btn:hover {
        background-color: #a81b20;
        color: white;
    }

    @media (max-width: 991.98px) {
        .cart-container {
            grid-template-columns: 1fr;
        }

        .cart-summary {
            position: static;
        }
    }

    @media (max-width: 767.98px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: 15px;
        }

        .item-image {
            width: 80px;
            height: 100px;
        }

        .item-controls {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <h1 class="page-title">Giỏ hàng của bạn</h1>

    <?php if (!empty($cartItems)): ?>
        <div class="cart-container">
            <!-- Cart Items -->
            <div class="cart-items">
                <div class="cart-header">
                    Sản phẩm (<?= count($cartItems) ?>)
                </div>
                
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item" data-product-id="<?= $item['product']['id'] ?>">
                        <div class="item-image">
                            <img src="<?= BASE_URL . $item['product']['image'] ?>" alt="<?= htmlspecialchars($item['product']['name']) ?>">
                        </div>
                        
                        <div class="item-info">
                            <div class="item-title"><?= htmlspecialchars($item['product']['name']) ?></div>
                            <div class="item-author"><?= htmlspecialchars($item['product']['author']) ?></div>
                            <div class="item-price">
                                <?= number_format($item['product']['price']) ?>đ
                                <?php if ($item['product']['old_price'] > $item['product']['price']): ?>
                                    <span class="item-old-price"><?= number_format($item['product']['old_price']) ?>đ</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="item-controls">
                            <div class="quantity-control">
                                <button class="quantity-btn" onclick="decreaseQuantity(<?= $item['product']['id'] ?>)">-</button>
                                <input type="number" 
                                       id="quantity-<?= $item['product']['id'] ?>" 
                                       class="quantity-input" 
                                       value="<?= $item['quantity'] ?>" 
                                       min="1" 
                                       max="99"
                                       onchange="updateQuantity(<?= $item['product']['id'] ?>, this.value)">
                                <button class="quantity-btn" onclick="increaseQuantity(<?= $item['product']['id'] ?>)">+</button>
                            </div>
                            
                            <div class="item-subtotal"><?= number_format($item['subtotal']) ?>đ</div>
                            
                            <button class="remove-btn" onclick="removeFromCart(<?= $item['product']['id'] ?>)">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <div class="summary-title">Thông tin đơn hàng</div>
                
                <div class="summary-row">
                    <span class="summary-label">Tạm tính:</span>
                    <span class="summary-value"><?= number_format($summary['subtotal']) ?>đ</span>
                </div>
                
                <?php if ($summary['discount'] > 0): ?>
                    <div class="summary-row">
                        <span class="summary-label">Giảm giá:</span>
                        <span class="summary-value summary-discount">-<?= number_format($summary['discount']) ?>đ</span>
                    </div>
                <?php endif; ?>
                
                <div class="summary-row">
                    <span class="summary-label">Phí vận chuyển:</span>
                    <span class="summary-value"><?= number_format($summary['shipping']) ?>đ</span>
                </div>
                
                <div class="summary-row summary-total">
                    <span class="summary-label">Tổng cộng:</span>
                    <span class="summary-value"><?= number_format($summary['total']) ?>đ</span>
                </div>
                
                <button class="checkout-btn" onclick="handleCheckout()">
                    <i class="fas fa-check-circle"></i> Tiến hành thanh toán
                </button>
                
                <a href="<?= BASE_URL ?>product" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua hàng
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty Cart -->
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Giỏ hàng của bạn đang trống</h3>
            <p>Hãy khám phá và thêm sản phẩm yêu thích vào giỏ hàng nhé!</p>
            <a href="<?= BASE_URL ?>product" class="shop-now-btn">
                <i class="fas fa-shopping-bag"></i> Mua sắm ngay
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
    // Tăng số lượng
    function increaseQuantity(productId) {
        const input = document.getElementById(`quantity-${productId}`);
        let value = parseInt(input.value) || 0;
        if (value < 99) {
            input.value = value + 1;
            updateQuantity(productId, input.value);
        }
    }

    // Giảm số lượng
    function decreaseQuantity(productId) {
        const input = document.getElementById(`quantity-${productId}`);
        let value = parseInt(input.value) || 1;
        if (value > 1) {
            input.value = value - 1;
            updateQuantity(productId, input.value);
        }
    }

    // Cập nhật số lượng sản phẩm
    async function updateQuantity(productId, quantity) {
        try {
            const response = await fetch('<?= BASE_URL ?>cart/updateQuantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            });

            const result = await response.json();

            if (result.success) {
                // Reload trang để cập nhật tổng tiền
                location.reload();
            } else {
                alert(result.message || 'Lỗi khi cập nhật số lượng');
            }
        } catch (error) {
            alert('Lỗi kết nối khi cập nhật số lượng');
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    async function removeFromCart(productId) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            return;
        }

        try {
            const response = await fetch('<?= BASE_URL ?>cart/removeFromCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}`
            });

            const result = await response.json();

            if (result.success) {
                // Reload trang để cập nhật giỏ hàng
                location.reload();
            } else {
                alert(result.message || 'Lỗi khi xóa sản phẩm');
            }
        } catch (error) {
            alert('Lỗi kết nối khi xóa sản phẩm');
        }
    }

    // Xử lý thanh toán
    function handleCheckout() {
        alert('Chức năng thanh toán sẽ được phát triển trong phiên bản tiếp theo!');
        // Trong thực tế, chuyển hướng đến trang thanh toán
        // window.location.href = '<?= BASE_URL ?>checkout';
    }
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
