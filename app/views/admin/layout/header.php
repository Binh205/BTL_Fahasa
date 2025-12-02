<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title><?= $title ?? 'Admin Dashboard' ?> - FAHASA</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root { --tblr-font-sans-serif: 'Inter Var', sans-serif; }
      body { font-feature-settings: "cv03", "cv04", "cv11"; }
    </style>
  </head>
  <body >
    <div class="page">
      <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark">
            <a href="<?= BASE_URL ?>admin">FAHASA ADMIN</a>
          </h1>
          <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
              <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin">
                  <span class="nav-link-icon"><i class="fas fa-home"></i></span>
                  <span class="nav-link-title">Dashboard</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/settings">
                  <span class="nav-link-icon"><i class="fas fa-cogs"></i></span>
                  <span class="nav-link-title">Cấu hình chung</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/contacts">
                  <span class="nav-link-icon"><i class="fas fa-envelope"></i></span>
                  <span class="nav-link-title">Liên hệ</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/qa">
                  <span class="nav-link-icon"><i class="fas fa-question-circle"></i></span>
                  <span class="nav-link-title">Hỏi đáp</span>
                </a>
              </li>
               <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>admin/pageContent?page=about">
                  <span class="nav-link-icon"><i class="fas fa-file-alt"></i></span>
                  <span class="nav-link-title">Trang Giới thiệu</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </aside>

      <div class="page-wrapper">
        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
          <div class="container-xl">
            <div class="navbar-nav flex-row order-md-last">
              <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                  <div class="d-none d-xl-block ps-2">
                    <div><?= $_SESSION['user_name'] ?? 'Admin' ?></div>
                    <div class="mt-1 small text-secondary">Administrator</div>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="<?= BASE_URL ?>" class="dropdown-item">Xem trang chủ</a>
                    <a href="<?= BASE_URL ?>auth/logout" class="dropdown-item text-danger">Đăng xuất</a>
                </div>
              </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu"></div>
          </div>
        </header>
        
        <div class="page-body">
          <div class="container-xl"></div>


<li class="nav-item">
  <a class="nav-link" href="<?= BASE_URL ?>admin/news">
    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fas fa-newspaper"></i></span>
    <span class="nav-link-title">Quản lý Tin tức</span>
  </a>
</li>

<li class="nav-item">
  <a class="nav-link" href="<?= BASE_URL ?>admin/products">
    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="fas fa-box"></i></span>
    <span class="nav-link-title">Quản lý Sản phẩm</span>
  </a>
</li>