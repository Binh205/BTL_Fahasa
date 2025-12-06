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
    
    .order-filters {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 10px 20px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }
    
    .filter-btn:hover {
        border-color: var(--fahasa-orange);
        color: var(--fahasa-orange);
    }
    
    .filter-btn.active {
        background-color: var(--fahasa-red);
        color: white;
        border-color: var(--fahasa-red);
    }
    
    .order-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: box-shadow 0.3s;
    }
    
    .order-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .order-header {
        background-color: var(--fahasa-light-gray);
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .order-id {
        font-weight: 600;
        color: var(--fahasa-dark);
    }
    
    .order-status {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-shipping {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .status-processing {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .order-body {
        padding: 20px;
    }
    
    .order-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid var(--fahasa-light-gray);
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .order-item-image {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        background-color: var(--fahasa-light-gray);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .order-item-image i {
        font-size: 2rem;
        color: var(--fahasa-gray);
    }
    
    .order-item-info {
        flex: 1;
    }
    
    .order-item-name {
        font-weight: 600;
        color: var(--fahasa-dark);
        margin-bottom: 5px;
    }
    
    .order-item-qty {
        color: var(--fahasa-gray);
        font-size: 0.9rem;
    }
    
    .order-item-price {
        font-weight: 600;
        color: var(--fahasa-red);
        text-align: right;
    }
    
    .order-footer {
        padding: 15px 20px;
        background-color: #fafafa;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .order-total {
        font-size: 1.1rem;
    }
    
    .order-total-label {
        color: var(--fahasa-gray);
        margin-right: 10px;
    }
    
    .order-total-amount {
        font-weight: 700;
        color: var(--fahasa-red);
        font-size: 1.3rem;
    }
    
    .order-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-order {
        padding: 8px 20px;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-view {
        background-color: var(--fahasa-orange);
        color: white;
    }
    
    .btn-view:hover {
        background-color: #e68419;
    }
    
    .btn-reorder {
        background-color: var(--fahasa-red);
        color: white;
    }
    
    .btn-reorder:hover {
        background-color: #a51b1f;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: var(--fahasa-gray);
        margin-bottom: 20px;
    }
    
    .empty-state h4 {
        color: var(--fahasa-dark);
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: var(--fahasa-gray);
    }
    
    @media (max-width: 767.98px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .order-item {
            flex-direction: column;
        }
        
        .order-item-price {
            text-align: left;
        }
        
        .order-footer {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .order-actions {
            width: 100%;
        }
        
        .btn-order {
            flex: 1;
        }
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
                        <i class="fas fa-box"></i>
                        Đơn hàng của tôi
                    </h2>
                    
                    <!-- Order Filters -->
                    <div class="order-filters">
                        <button class="filter-btn active" data-status="all">
                            <i class="fas fa-list me-2"></i>Tất cả
                        </button>
                        <button class="filter-btn" data-status="processing">
                            <i class="fas fa-clock me-2"></i>Đang xử lý
                        </button>
                        <button class="filter-btn" data-status="shipping">
                            <i class="fas fa-shipping-fast me-2"></i>Đang giao
                        </button>
                        <button class="filter-btn" data-status="completed">
                            <i class="fas fa-check-circle me-2"></i>Hoàn thành
                        </button>
                        <button class="filter-btn" data-status="cancelled">
                            <i class="fas fa-times-circle me-2"></i>Đã hủy
                        </button>
                    </div>
                    
                    <!-- Orders List -->
                    <div class="orders-list">
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <div class="order-card" data-status="<?= $order['status'] ?>">
                                    <!-- Order Header -->
                                    <div class="order-header">
                                        <div>
                                            <span class="order-id">
                                                <i class="fas fa-hashtag"></i>
                                                <?= htmlspecialchars($order['order_id']) ?>
                                            </span>
                                            <span class="text-muted ms-3">
                                                <i class="far fa-calendar-alt"></i>
                                                <?= date('d/m/Y', strtotime($order['order_date'])) ?>
                                            </span>
                                        </div>
                                        <span class="order-status status-<?= $order['status'] ?>">
                                            <?= htmlspecialchars($order['status_text']) ?>
                                        </span>
                                    </div>
                                    
                                    <!-- Order Body -->
                                    <div class="order-body">
                                        <?php foreach ($order['items'] as $item): ?>
                                            <div class="order-item">
                                                <div class="order-item-image">
                                                    <img src="<?= BASE_URL . $item['image'] ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                                </div>
                                                <div class="order-item-info">
                                                    <div class="order-item-name">
                                                        <?= htmlspecialchars($item['product_name']) ?>
                                                    </div>
                                                    <div class="order-item-qty">
                                                        Số lượng: <?= $item['quantity'] ?>
                                                    </div>
                                                </div>
                                                <div class="order-item-price">
                                                    <?= number_format($item['price'] * $item['quantity']) ?>đ
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Order Footer -->
                                    <div class="order-footer">
                                        <div class="order-total">
                                            <span class="order-total-label">Tổng tiền:</span>
                                            <span class="order-total-amount">
                                                <?= number_format($order['total']) ?>đ
                                            </span>
                                        </div>
                                        <div class="order-actions">
                                            <button class="btn-order btn-view">
                                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                                            </button>
                                            <?php if ($order['status'] === 'completed'): ?>
                                                <button class="btn-order btn-reorder">
                                                    <i class="fas fa-redo me-2"></i>Mua lại
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h4>Chưa có đơn hàng nào</h4>
                                <p>Bạn chưa có đơn hàng nào. Hãy khám phá và mua sắm ngay!</p>
                                <a href="<?= BASE_URL ?>product" class="btn btn-order btn-reorder mt-3">
                                    <i class="fas fa-shopping-cart me-2"></i>Mua sắm ngay
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter orders by status
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const status = this.dataset.status;
        const orders = document.querySelectorAll('.order-card');
        
        orders.forEach(order => {
            if (status === 'all' || order.dataset.status === status) {
                order.style.display = 'block';
            } else {
                order.style.display = 'none';
            }
        });
    });
});

// View order detail
document.querySelectorAll('.btn-view').forEach(btn => {
    btn.addEventListener('click', function() {
        alert('Chức năng xem chi tiết đơn hàng đang được phát triển!');
    });
});

// Reorder
document.querySelectorAll('.btn-reorder').forEach(btn => {
    btn.addEventListener('click', function() {
        if (confirm('Bạn có muốn mua lại đơn hàng này?')) {
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        }
    });
});
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
