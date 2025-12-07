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

    .search-section {
        background-color: var(--fahasa-light-gray);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .search-form {
        display: flex;
        gap: 15px;
    }

    .search-input {
        flex: 1;
        position: relative;
    }

    .search-input input {
        width: 100%;
        padding: 12px 45px 12px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    .search-input button {
        position: absolute;
        right: 5px;
        top: 5px;
        background-color: var(--fahasa-red);
        border: none;
        color: white;
        padding: 6px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .filter-section {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .filter-title {
        font-weight: 600;
        color: var(--fahasa-dark);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .filter-title i {
        margin-right: 10px;
        color: var(--fahasa-red);
    }

    .category-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .category-btn {
        padding: 8px 15px;
        background-color: var(--fahasa-light-gray);
        border: none;
        border-radius: 20px;
        color: var(--fahasa-dark);
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }

    .category-btn:hover,
    .category-btn.active {
        background-color: var(--fahasa-red);
        color: white;
    }

    .sort-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .results-info {
        color: var(--fahasa-gray);
        font-size: 14px;
    }

    .sort-options select {
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: white;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .product-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: var(--fahasa-red);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        z-index: 10;
    }

    .product-image {
        height: 220px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-info {
        padding: 15px;
    }

    .product-title {
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.9rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.5em;
        line-height: 1.2em;
    }

    .product-author {
        color: var(--fahasa-gray);
        font-size: 0.8rem;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        color: var(--fahasa-red);
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .product-old-price {
        color: #999;
        text-decoration: line-through;
        font-size: 0.8rem;
        margin-left: 8px;
    }

    .product-rating {
        display: flex;
        align-items: center;
        margin-top: 5px;
    }

    .stars {
        color: #ffc107;
        margin-right: 5px;
    }

    .rating-count {
        color: var(--fahasa-gray);
        font-size: 0.8rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .page-item {
        margin: 0 5px;
    }

    .page-link {
        display: block;
        padding: 8px 15px;
        border: 1px solid #ddd;
        text-decoration: none;
        color: var(--fahasa-dark);
        border-radius: 4px;
        transition: all 0.3s;
    }

    .page-link:hover,
    .page-link.active {
        background-color: var(--fahasa-red);
        color: white;
        border-color: var(--fahasa-red);
    }

    .no-results {
        text-align: center;
        padding: 50px 20px;
        color: var(--fahasa-gray);
    }

    .no-results i {
        font-size: 48px;
        margin-bottom: 15px;
        color: var(--fahasa-light-gray);
    }

    .no-results h4 {
        color: var(--fahasa-dark);
        margin-bottom: 10px;
    }

    @media (max-width: 767.98px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
        
        .search-form {
            flex-direction: column;
        }
        
        .sort-section {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <h1 class="page-title">Danh sách sản phẩm</h1>

    <!-- Search Section -->
    <div class="search-section">
        <form method="GET" action="<?= BASE_URL ?>product" class="search-form">
            <div class="search-input">
                <input type="text" 
                       name="search" 
                       placeholder="Tìm kiếm sách, tác giả, thể loại..." 
                       value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button type="submit" class="btn" style="background-color: var(--fahasa-red); color: white; border: none; padding: 8px 20px; border-radius: 4px;">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </form>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <i class="fas fa-filter"></i>
            <h3>Danh mục sản phẩm</h3>
        </div>
        <div class="category-filter">
            <a href="?category=all" class="category-btn <?= $selectedCategory == 'all' || $selectedCategory == '' ? 'active' : '' ?>">Tất cả</a>
            <?php foreach ($categories as $cat):
            ?>
                <a href="?category=<?= $cat['category_id'] ?>" class="category-btn <?= $selectedCategory == $cat['category_id'] ? 'active' : '' ?>">
                    <?= htmlspecialchars($cat['category_name']) ?>
                </a>
            <?php endforeach;
            ?>
        </div>
    </div>

    <!-- Sort and Results Info -->
    <div class="sort-section">
        <div class="results-info">
            <strong><?= $totalProducts ?></strong> sản phẩm
            <?php if (!empty($search)):
            ?>
                cho từ khóa "<strong><?= htmlspecialchars($search) ?></strong>"
            <?php endif;
            ?>
            <?php if (!empty($selectedCategory) && $selectedCategory != 'all'): 
            ?>
                <?php 
                    $categoryName = '';
                    foreach ($categories as $cat) {
                        if ($cat['category_id'] == $selectedCategory) {
                            $categoryName = $cat['category_name'];
                            break;
                        }
                    }
                ?>
                trong danh mục <strong><?= htmlspecialchars($categoryName) ?></strong>
            <?php endif;
            ?>
        </div>
        <div class="sort-options">
            <select name="sort" id="sortSelect" onchange="handleSortChange(this.value)">
                <option value="">Sắp xếp theo</option>
                <option value="price-asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-asc') ? 'selected' : '' ?>>Giá: Thấp đến cao</option>
                <option value="price-desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price-desc') ? 'selected' : '' ?>>Giá: Cao đến thấp</option>
                <option value="name-asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name-asc') ? 'selected' : '' ?>>Tên: A-Z</option>
                <option value="name-desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name-desc') ? 'selected' : '' ?>>Tên: Z-A</option>
                <!-- <option value="rating" <?= (isset($_GET['sort']) && $_GET['sort'] == 'rating') ? 'selected' : '' ?>>Đánh giá</option> -->
            </select>
        </div>
    </div>

    <!-- Product Grid -->
    <?php if (!empty($products)): 
    ?>
        <div class="product-grid">
            <?php foreach ($products as $product):
                // Check if product has an old price and if it's greater than the current price
                $isDiscounted = isset($product['old_price']) && $product['old_price'] > $product['price'];
                $discountPercentage = $isDiscounted ? round(100 - ($product['price'] / $product['old_price']) * 100) : 0;
            ?>
                <a href="<?= BASE_URL ?>product/detail/<?= $product['product_id'] ?>" class="product-card">
                    <?php if ($isDiscounted): 
                        // Display discount badge if the product is discounted
                    ?>
                        <div class="product-badge">Giảm <?= $discountPercentage ?>%</div>
                    <?php endif;
                    ?>
                    <div class="product-image">
                        <img src="<?= BASE_URL . $product['image_url'] ?>" alt="<?= htmlspecialchars($product['title']) ?>">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?= htmlspecialchars($product['title']) ?></h3>
                        <div class="product-author"><?= htmlspecialchars($product['author']) ?></div>
                        <div class="product-price">
                            <?= number_format($product['price']) ?>đ
                            <?php if ($isDiscounted): 
                                // Display old price if the product is discounted
                            ?>
                                <span class="product-old-price"><?= number_format($product['old_price']) ?>đ</span>
                            <?php endif;
                            ?>
                        </div>
                        <!-- Tạm thời ẩn phần đánh giá sản phẩm để tránh lỗi "Undefined array key \"rating\"". Sẽ bổ sung sau. -->
                        <!-- 
                        <div class="product-rating">
                            <div class="stars">
                                <?php /* for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $product['rating']): ?>
                                        <i class="fas fa-star"></i>
                                    <?php else: ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php endif; ?>
                                <?php endfor; */ ?>
                            </div>
                            <div class="rating-count">(<?php //= $product['reviews'] ?>)</div>
                        </div>
                        -->
                    </div>
                </a>
            <?php endforeach;
            ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): 
            // Determine the range of pages to display, showing current page and a few around it
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $currentPage + 2);
        ?>
            <nav class="pagination">
                <ul class="pagination-list">
                    <?php for ($i = $startPage; $i <= $endPage; $i++):
                        // Highlight the current page
                    ?>
                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?><?= !empty($selectedCategory) ? '&category=' . urlencode($selectedCategory) : '' ?>"><?= $i ?></a>
                        </li>
                    <?php endfor;
                    ?>
                </ul>
            </nav>
        <?php endif;
        ?>
    <?php else:
        // Display a message if no products are found
    ?>
        <div class="no-results">
            <i class="fas fa-search"></i>
            <h4>Không tìm thấy sản phẩm nào</h4>
            <p>Vui lòng thử lại với từ khóa khác</p>
        </div>
    <?php endif;
    ?>
</div>

<script>
    function handleSortChange(sortValue) {
        const urlParams = new URLSearchParams(window.location.search);
        if (sortValue) {
            urlParams.set('sort', sortValue);
        } else {
            urlParams.delete('sort');
        }
        urlParams.delete('page'); // Reset page when sorting
        window.location.search = urlParams.toString();
    }
</script>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>
