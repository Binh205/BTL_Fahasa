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

    .article-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--fahasa-light-gray);
    }

    .article-category {
        background-color: var(--fahasa-red);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 15px;
    }

    .article-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--fahasa-dark);
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        color: var(--fahasa-gray);
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .article-author {
        display: flex;
        align-items: center;
    }

    .article-author i {
        margin-right: 8px;
    }

    .article-date {
        display: flex;
        align-items: center;
    }

    .article-date i {
        margin-right: 8px;
    }

    .article-stats {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .article-stats i {
        margin-right: 5px;
    }

    .article-image {
        width: 100%;
        height: 400px;
        overflow: hidden;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--fahasa-dark);
        margin-bottom: 40px;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-content h2 {
        color: var(--fahasa-red);
        margin: 2rem 0 1rem 0;
        font-size: 1.8rem;
    }

    .article-content h3 {
        color: var(--fahasa-dark);
        margin: 1.5rem 0 1rem 0;
        font-size: 1.5rem;
    }

    .article-content ul,
    .article-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .article-content li {
        margin-bottom: 0.5rem;
    }

    .social-share {
        display: flex;
        gap: 15px;
        margin: 30px 0;
        padding: 20px 0;
        border-top: 1px solid var(--fahasa-light-gray);
        border-bottom: 1px solid var(--fahasa-light-gray);
    }

    .social-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 30px;
        text-decoration: none;
        color: white;
        font-weight: 500;
        transition: transform 0.3s;
    }

    .social-btn:hover {
        transform: translateY(-2px);
    }

    .social-btn.facebook {
        background-color: #3b5998;
    }

    .social-btn.twitter {
        background-color: #1da1f2;
    }

    .social-btn.linkedin {
        background-color: #0077b5;
    }

    .social-btn.whatsapp {
        background-color: #25d366;
    }

    .related-articles {
        margin-top: 50px;
    }

    .section-title {
        color: var(--fahasa-red);
        font-weight: 700;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 3px;
        background-color: var(--fahasa-orange);
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    .related-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
        color: inherit;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .related-image {
        height: 180px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-content {
        padding: 15px;
    }

    .related-title {
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 1rem;
        color: var(--fahasa-dark);
    }

    .related-title:hover {
        color: var(--fahasa-red);
    }

    .related-meta {
        display: flex;
        justify-content: space-between;
        color: var(--fahasa-gray);
        font-size: 0.85rem;
    }

    .related-date {
        font-size: 0.8rem;
    }

    .article-navigation {
        display: flex;
        justify-content: space-between;
        margin: 40px 0;
        padding: 20px 0;
        border-top: 1px solid var(--fahasa-light-gray);
        border-bottom: 1px solid var(--fahasa-light-gray);
    }

    .nav-link {
        display: block;
        padding: 10px 20px;
        background-color: var(--fahasa-light-gray);
        border-radius: 4px;
        text-decoration: none;
        color: var(--fahasa-dark);
        transition: background-color 0.3s;
        max-width: 45%;
    }

    .nav-link:hover {
        background-color: var(--fahasa-red);
        color: white;
    }

    .nav-next {
        margin-left: auto;
        text-align: right;
    }

    @media (max-width: 767.98px) {
        .article-title {
            font-size: 1.8rem;
        }
        
        .article-meta {
            flex-direction: column;
            gap: 10px;
        }
        
        .article-image {
            height: 250px;
        }
        
        .social-share {
            flex-direction: column;
        }
        
        .article-navigation {
            flex-direction: column;
            gap: 15px;
        }
        
        .nav-link {
            max-width: 100%;
            text-align: center;
        }
        
        .nav-next {
            margin-left: 0;
            text-align: center;
        }
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>news">Tin tức</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($article['title']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <article class="article">
        <header class="article-header">
            <div class="article-category"><?= ucfirst(str_replace('-', ' ', $article['category'])) ?></div>
            <h1 class="article-title"><?= htmlspecialchars($article['title']) ?></h1>
            <div class="article-meta">
                <div class="article-author">
                    <i class="fas fa-user"></i>
                    <span><?= htmlspecialchars($article['author']) ?></span>
                </div>
                <div class="article-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span><?= date('d/m/Y', strtotime($article['published_date'])) ?></span>
                </div>
                <div class="article-stats">
                    <span><i class="fas fa-eye"></i> <?= $article['views'] ?> lượt xem</span>
                    <span><i class="fas fa-comment"></i> <?= $article['comments'] ?> bình luận</span>
                </div>
            </div>
            <div class="article-image">
                <img src="<?= BASE_URL . $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            </div>
        </header>
        
        <div class="article-content">
            <?php 
            // Convert newline characters to HTML paragraphs
            $content = htmlspecialchars($article['content']);
            $paragraphs = explode("\n", $content);
            foreach ($paragraphs as $paragraph):
                $paragraph = trim($paragraph);
                if (!empty($paragraph)):
                    echo "<p>" . $paragraph . "</p>";
                endif;
            endforeach;
            ?>
        </div>
        
        <div class="social-share">
            <a href="#" class="social-btn facebook">
                <i class="fab fa-facebook-f"></i>
                Chia sẻ
            </a>
            <a href="#" class="social-btn twitter">
                <i class="fab fa-twitter"></i>
                Tweet
            </a>
            <a href="#" class="social-btn linkedin">
                <i class="fab fa-linkedin-in"></i>
                LinkedIn
            </a>
            <a href="#" class="social-btn whatsapp">
                <i class="fab fa-whatsapp"></i>
                WhatsApp
            </a>
        </div>
        
        <?php if (!empty($relatedArticles)): ?>
        <div class="related-articles">
            <h2 class="section-title">Bài viết liên quan</h2>
            <div class="related-grid">
                <?php foreach ($relatedArticles as $related): ?>
                    <a href="<?= BASE_URL ?>news/detail/<?= $related['id'] ?>" class="related-card">
                        <div class="related-image">
                            <img src="<?= BASE_URL . $related['image'] ?>" alt="<?= htmlspecialchars($related['title']) ?>">
                        </div>
                        <div class="related-content">
                            <h3 class="related-title"><?= htmlspecialchars($related['title']) ?></h3>
                            <div class="related-meta">
                                <div class="related-author"><?= htmlspecialchars($related['author']) ?></div>
                                <div class="related-date"><?= date('d/m', strtotime($related['published_date'])) ?></div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </article>
</div>

<?php require_once APP_ROOT . '/views/components/footer.php'; ?>