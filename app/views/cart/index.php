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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        grid-template-columns: 100px 2fr 120px 100px 80px;
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


.item-title-link {
    text-decoration: none; 
    color: inherit; 
    display: block; 
}

.item-title-link:hover {
    color: #007bff; 
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
        align-items: center;
        justify-content: center;
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
        color: var(--fahasa-red);
        font-size: 1.1rem;
        text-align: right;
    }

    .remove-btn {
        background: none;
        border: none;
        color: var(--fahasa-gray);
        cursor: pointer;
        font-size: 0.9rem;
        transition: color 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .remove-btn:hover {
        color: var(--fahasa-red);
    }

    .cart-summary {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

<div class="container">
    <h1 class="page-title">Giỏ hàng của bạn</h1>

    <?php if (!empty($cartItems)): ?>
        <div class="cart-container">
            <div class="cart-items" id="cart-items-list">
                <div class="cart-header">
                    Sản phẩm (<span id="cart-count-display"><?= count($cartItems) ?></span>)
                </div>

                <?php foreach ($cartItems as $item):
                    // Dùng biến local để tránh lặp lại $_SESSION['users_id'] trong JS
                    $isLoggedInJS = json_encode($isLoggedIn);
                ?>
                    <div class="cart-item" data-product-id="<?= $item['product_id'] ?>" id="cart-item-<?= $item['product_id'] ?>">
                        <div class="item-image">
                            <img src="<?= BASE_URL . $item['image_url'] ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        </div>

                        <div class="item-info">
                            <a href="<?= BASE_URL . 'product/detail/' . $item['product_id'] ?>" class="item-title-link">
                                <div class="item-title"><?= htmlspecialchars($item['title']) ?></div>
                            </a>
                            <div class="item-author"><?= htmlspecialchars($item['author']) ?></div>
                            <div class="item-price" data-price="<?= $item['price'] ?>">
                                <?= number_format($item['price']) ?>
                            </div>
                        </div>

                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="decreaseQuantity(<?= $item['product_id'] ?>, <?= $isLoggedInJS ?>)">-</button>
                            <input type="number"
                                id="quantity-<?= $item['product_id'] ?>"
                                class="quantity-input"
                                value="<?= $item['quantity'] ?>"
                                min="1"
                                max="99"
                                onchange="updateQuantity(<?= $item['product_id'] ?>, this.value, <?= $isLoggedInJS ?>)">
                            <button class="quantity-btn" onclick="increaseQuantity(<?= $item['product_id'] ?>, <?= $isLoggedInJS ?>)">+</button>
                        </div>

                        <div class="item-subtotal" id="subtotal-<?= $item['product_id'] ?>" data-subtotal="<?= $item['subtotal'] ?>">
                            <?= number_format($item['subtotal']) ?>đ
                        </div>

                        <button class="remove-btn" onclick="removeFromCart(<?= $item['product_id'] ?>, <?= $isLoggedInJS ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary" id="cart-summary">
                <div class="summary-title">Thông tin đơn hàng</div>

                <div class="summary-row">
                    <span class="summary-label">Tạm tính:</span>
                    <span class="summary-value" id="summary-subtotal"><?= number_format($summary['subtotal']) ?>đ</span>
                </div>

                <?php if ($summary['discount'] > 0): ?>
                    <div class="summary-row">
                        <span class="summary-label">Giảm giá:</span>
                        <span class="summary-value summary-discount" id="summary-discount">-<?= number_format($summary['discount']) ?>đ</span>
                    </div>
                <?php endif; ?>

                <div class="summary-row">
                    <span class="summary-label">Phí vận chuyển:</span>
                    <span class="summary-value" id="summary-shipping"><?= number_format($summary['shipping']) ?>đ</span>
                </div>

                <div class="summary-row summary-total">
                    <span class="summary-label">Tổng cộng:</span>
                    <span class="summary-value" id="summary-total"><?= number_format($summary['total']) ?>đ</span>
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
        <div class="empty-cart" id="empty-cart-message">
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
    // Hàm format tiền tệ
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount).replace('₫', 'đ');
    }

    // --- LOGIC LOCAL STORAGE (Cho trường hợp chưa đăng nhập) ---
    const LOCAL_CART_KEY = 'local_cart';

    // Lấy giỏ hàng từ Local Storage
    function getLocalCart() {
        const cartJson = localStorage.getItem(LOCAL_CART_KEY);
        return cartJson ? JSON.parse(cartJson) : [];
    }

    // Lưu giỏ hàng vào Local Storage
    function saveLocalCart(cart) {
        localStorage.setItem(LOCAL_CART_KEY, JSON.stringify(cart));
        // Cập nhật cookie để Controller có thể đọc (cho lần load trang tiếp theo)
        document.cookie = `local_cart=${JSON.stringify(cart)}; path=/; max-age=${3600*24*7}`; // 7 ngày
    }

    // Cập nhật Local Cart (chỉ dùng khi chưa đăng nhập)
    function updateLocalCart(productId, quantity) {
        let cart = getLocalCart();
        const index = cart.findIndex(item => item.product_id == productId);

        if (quantity <= 0) {
            // Xóa sản phẩm nếu quantity <= 0
            if (index !== -1) {
                cart.splice(index, 1);
            }
        } else if (index !== -1) {
            // Cập nhật số lượng
            cart[index].quantity = quantity;
        }

        saveLocalCart(cart);
    }

    // Xóa sản phẩm khỏi Local Cart (chỉ dùng khi chưa đăng nhập)
    function removeLocalCartItem(productId) {
        let cart = getLocalCart();
        cart = cart.filter(item => item.product_id != productId);
        saveLocalCart(cart);
    }


    // --- LOGIC CẬP NHẬT GIO HÀNG (AJAX & UI) ---

    // Tính toán lại tổng tiền trên UI
    function recalculateSummary() {
        let subtotal = 0;
        const cartItemsList = document.querySelectorAll('.cart-item');

        cartItemsList.forEach(item => {
            const subtotalElement = item.querySelector('.item-subtotal');
            if (subtotalElement) {
                subtotal += parseInt(subtotalElement.dataset.subtotal) || 0;
            }
        });

        // Áp dụng logic tính tổng của Controller (giả định)
        const discount = 0; // Thay đổi nếu có logic giảm giá
        const shipping = subtotal > 0 ? 30000 : 0;
        const total = subtotal - discount + shipping;

        // Cập nhật UI Summary
        document.getElementById('summary-subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('summary-shipping').textContent = formatCurrency(shipping);
        document.getElementById('summary-total').textContent = formatCurrency(total);
        document.getElementById('cart-count-display').textContent = cartItemsList.length;

        // Xử lý giỏ hàng rỗng
        if (cartItemsList.length === 0) {
            const container = document.querySelector('.cart-container');
            if (container) container.remove();

            const emptyMessage = document.getElementById('empty-cart-message');
            if (!emptyMessage) {
                // Nếu chưa có message thì thêm vào (hoặc reload)
                // Tốt nhất là hiện message đã có trong View
                location.reload(); // Hoặc render lại empty cart HTML
            }
        }
    }


    // Tăng số lượng
    function increaseQuantity(productId, isLoggedIn) {
        const input = document.getElementById(`quantity-${productId}`);
        let value = parseInt(input.value) || 0;
        if (value < 99) {
            input.value = value + 1;
            updateQuantity(productId, input.value, isLoggedIn);
        }
    }

    // Giảm số lượng
    function decreaseQuantity(productId, isLoggedIn) {
        const input = document.getElementById(`quantity-${productId}`);
        let value = parseInt(input.value) || 1;
        if (value > 1) {
            input.value = value - 1;
            updateQuantity(productId, input.value, isLoggedIn);
        }
    }

    // Cập nhật số lượng sản phẩm
    async function updateQuantity(productId, quantity, isLoggedIn) {
        quantity = parseInt(quantity);
        if (quantity < 1 || quantity > 99) return;

        const itemElement = document.getElementById(`cart-item-${productId}`);
        const priceElement = itemElement.querySelector('.item-price');
        const subtotalElement = document.getElementById(`subtotal-${productId}`);
        const price = parseInt(priceElement.dataset.price);

        // Cập nhật UI tạm thời
        const newSubtotal = price * quantity;
        subtotalElement.dataset.subtotal = newSubtotal;
        subtotalElement.textContent = formatCurrency(newSubtotal);
        recalculateSummary();

        // 1. Xử lý Local Storage (chưa đăng nhập)
        if (!isLoggedIn) {
            updateLocalCart(productId, quantity);
            return; // Xong việc, không cần AJAX lên server
        }

        // 2. Xử lý Database (đã đăng nhập)
        try {
            const response = await fetch('<?= BASE_URL ?>cart/updateQuantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            });

            const result = await response.json();

            if (!result.success) {
                alert(result.message || 'Lỗi khi cập nhật số lượng');
                location.reload(); // Nếu lỗi thì reload để đồng bộ
            }
        } catch (error) {
            console.error('Lỗi kết nối khi cập nhật số lượng:', error);
            alert('Lỗi kết nối khi cập nhật số lượng');
        }
        // Không cần reload vì đã cập nhật UI và server (hoặc localStorage)
    }

    // Xóa sản phẩm khỏi giỏ hàng
    async function removeFromCart(productId, isLoggedIn) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            return;
        }

        const itemElement = document.getElementById(`cart-item-${productId}`);
        itemElement.remove();
        recalculateSummary(); // Cập nhật lại tổng tiền ngay lập tức

        // 1. Xử lý Local Storage (chưa đăng nhập)
        if (!isLoggedIn) {
            removeLocalCartItem(productId);
            return; // Xong việc, không cần AJAX lên server
        }

        // 2. Xử lý Database (đã đăng nhập)
        try {
            const response = await fetch('<?= BASE_URL ?>cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}`
            });

            const result = await response.json();

            if (!result.success) {
                alert(result.message || 'Lỗi khi xóa sản phẩm');
                location.reload(); // Nếu lỗi thì reload để đồng bộ
            }
        } catch (error) {
            console.error('Lỗi kết nối khi xóa sản phẩm:', error);
            alert('Lỗi kết nối khi xóa sản phẩm');
        }
        // Không cần reload vì đã cập nhật UI và server (hoặc localStorage)
    }

    // Xử lý thanh toán
    function handleCheckout() {
        alert('Chức năng thanh toán sẽ được phát triển trong phiên bản tiếp theo!');
        // Trong thực tế, chuyển hướng đến trang thanh toán
    }
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>