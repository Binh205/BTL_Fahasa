<style>
    .admin-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .card-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e0e0e0;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card.primary .stat-value { color: #c92127; }
    .stat-card.warning .stat-value { color: #f59e0b; }
    .stat-card.success .stat-value { color: #10b981; }
    .stat-card.info .stat-value { color: #3b82f6; }
    .stat-card.danger .stat-value { color: #ef4444; }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f8f9fa;
    }

    th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e0e0e0;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge.pending { background: #fef3c7; color: #92400e; }
    .badge.processing { background: #dbeafe; color: #1e40af; }
    .badge.completed { background: #d1fae5; color: #065f46; }
    .badge.cancelled { background: #fee2e2; color: #991b1b; }
    .badge.shipped { background: #e0e7ff; color: #3730a3; }

    .btn {
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }

    .btn-primary {
        background: #c92127;
        color: white;
    }

    .btn-primary:hover {
        background: #a01b20;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .btn-info {
        background: #3b82f6;
        color: white;
    }

    .btn-info:hover {
        background: #2563eb;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .text-danger {
        color: #c92127;
    }

    .fw-bold {
        font-weight: 600;
    }

    .text-center {
        text-align: center;
    }

    .text-muted {
        color: #94a3b8;
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-value"><?= $stats['total_orders'] ?? 0 ?></div>
        <div class="stat-label">Tổng đơn hàng</div>
    </div>
    <div class="stat-card warning">
        <div class="stat-value"><?= $stats['pending_orders'] ?? 0 ?></div>
        <div class="stat-label">Chờ xử lý</div>
    </div>
    <div class="stat-card info">
        <div class="stat-value"><?= $stats['processing_orders'] ?? 0 ?></div>
        <div class="stat-label">Đang xử lý</div>
    </div>
    <div class="stat-card success">
        <div class="stat-value"><?= $stats['completed_orders'] ?? 0 ?></div>
        <div class="stat-label">Hoàn thành</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-value"><?= $stats['cancelled_orders'] ?? 0 ?></div>
        <div class="stat-label">Đã hủy</div>
    </div>
    <div class="stat-card primary">
        <div class="stat-value"><?= number_format($stats['total_revenue'] ?? 0) ?>đ</div>
        <div class="stat-label">Tổng doanh thu</div>
    </div>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <div class="card-header-actions">
        <h2 class="card-title">Danh sách đơn hàng</h2>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Liên hệ</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phí ship</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td class="fw-bold">#<?= $order['order_id'] ?></td>
                        <td><?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?></td>
                        <td>
                            <div><?= htmlspecialchars($order['customer_phone'] ?? 'N/A') ?></div>
                            <div class="text-muted" style="font-size: 12px;"><?= htmlspecialchars($order['customer_email'] ?? '') ?></div>
                        </td>
                        <td><?= date('d/m/Y', strtotime($order['created_date'])) ?></td>
                        <td class="text-danger fw-bold"><?= number_format($order['total']) ?>đ</td>
                        <td><?= number_format($order['shipping_fee']) ?>đ</td>
                        <td>
                            <span class="badge" style="background: #e0e7ff; color: #3730a3;">
                                <?= htmlspecialchars($order['payment_method'] ?? 'N/A') ?>
                            </span>
                        </td>
                        <td>
                            <?php
                            $statusClass = match($order['status']) {
                                'pending' => 'pending',
                                'processing' => 'processing',
                                'shipped' => 'shipped',
                                'completed' => 'completed',
                                'cancelled' => 'cancelled',
                                default => 'pending'
                            };
                            $statusText = match($order['status']) {
                                'pending' => 'Chờ xử lý',
                                'processing' => 'Đang xử lý',
                                'shipped' => 'Đang giao',
                                'completed' => 'Hoàn thành',
                                'cancelled' => 'Đã hủy',
                                default => $order['status']
                            };
                            ?>
                            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/orderDetail/<?= $order['order_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Chi tiết
                            </a>
                            <a href="<?= BASE_URL ?>admin/deleteOrder?id=<?= $order['order_id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Chưa có đơn hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
