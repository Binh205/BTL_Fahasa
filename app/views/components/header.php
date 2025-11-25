<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'BTL FAHASA' ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --fahasa-red: #C92127;
            --fahasa-orange: #F7941E;
            --fahasa-dark: #2C2C2C;
            --fahasa-gray: #666666;
            --fahasa-light-gray: #F5F5F5;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: var(--fahasa-dark);
        }

        /* Header Styles */
        .top-header {
            background-color: var(--fahasa-red);
            color: white;
            padding: 8px 0;
            font-size: 13px;
        }

        .top-header a {
            color: white;
            text-decoration: none;
        }

        .top-header a:hover {
            text-decoration: underline;
        }

        .main-header {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px 0;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: var(--fahasa-red);
            text-decoration: none;
        }

        .logo:hover {
            color: var(--fahasa-orange);
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            border: 2px solid var(--fahasa-red);
            border-radius: 4px;
            padding: 10px 50px 10px 15px;
        }

        .search-box button {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            background-color: var(--fahasa-red);
            border: none;
            color: white;
            padding: 0 20px;
            border-radius: 0 4px 4px 0;
        }

        .search-box button:hover {
            background-color: #a81b20;
        }

        .nav-menu {
            background-color: var(--fahasa-light-gray);
            padding: 12px 0;
        }

        .nav-menu .nav-link {
            color: var(--fahasa-dark);
            font-weight: 500;
            padding: 8px 20px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-menu .nav-link:hover,
        .nav-menu .nav-link.active {
            color: var(--fahasa-red);
            background-color: white;
            border-radius: 4px;
        }

        .header-icons a {
            color: var(--fahasa-dark);
            font-size: 20px;
            margin-left: 20px;
            text-decoration: none;
            position: relative;
        }

        .header-icons a:hover {
            color: var(--fahasa-red);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--fahasa-red);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <i class="fas fa-phone"></i> Hotline: 1900-6656
                </div>
                <div class="col-md-6 text-end">
                    <a href="#"><i class="fas fa-user"></i> Đăng nhập</a>
                    <span class="mx-2">|</span>
                    <a href="#"><i class="fas fa-user-plus"></i> Đăng ký</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a href="<?= BASE_URL ?>" class="logo">
                        <i class="fas fa-book-open"></i> FAHASA
                    </a>
                </div>
                <div class="col-md-7">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Tìm kiếm sách, tác giả, nhà xuất bản...">
                        <button type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <div class="header-icons">
                        <a href="#" title="Yêu thích">
                            <i class="far fa-heart"></i>
                        </a>
                        <a href="#" title="Giỏ hàng">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="nav-menu">
        <div class="container">
            <div class="d-flex justify-content-start">
                <a href="<?= BASE_URL ?>home" class="nav-link <?= ($page ?? '') == 'home' ? 'active' : '' ?>">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
                <a href="<?= BASE_URL ?>home/about" class="nav-link <?= ($page ?? '') == 'about' ? 'active' : '' ?>">
                    <i class="fas fa-info-circle"></i> Giới thiệu
                </a>
                <a href="<?= BASE_URL ?>home/qa" class="nav-link <?= ($page ?? '') == 'qa' ? 'active' : '' ?>">
                    <i class="fas fa-question-circle"></i> Hỏi/Đáp
                </a>
                <a href="<?= BASE_URL ?>product" class="nav-link <?= ($page ?? '') == 'product' ? 'active' : '' ?>">
                    <i class="fas fa-book"></i> Sản phẩm
                </a>
                <a href="<?= BASE_URL ?>news" class="nav-link <?= ($page ?? '') == 'news' ? 'active' : '' ?>">
                    <i class="fas fa-newspaper"></i> Tin tức
                </a>
                <a href="<?= BASE_URL ?>contact" class="nav-link <?= ($page ?? '') == 'contact' ? 'active' : '' ?>">
                    <i class="fas fa-phone"></i> Liên hệ
                </a>
            </div>
        </div>
    </div>
