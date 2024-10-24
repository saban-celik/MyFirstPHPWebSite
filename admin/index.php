<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Sayfa içeriklerini yükleme
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$allowed_pages = ['home', 'about1', 'about2', 'about3', 'about4','services1','services2', 'home1', 'home2', 'home3', 'home4', 'home5', 'home6', 'home7','blog1','contact1','contact2'];
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

// Dosya yolu belirleme
if (in_array($page, ['home1', 'home2', 'home3', 'home4', 'home5', 'home6', 'home7'])) {
    $page_file = "./pages/home_pages/{$page}.php";
} elseif (in_array($page, ['about1', 'about2', 'about3', 'about4'])) {
    $page_file = "./pages/about_pages/{$page}.php";
} elseif (in_array($page, ['services1', 'services2'])) {
    $page_file = "./pages/services_pages/{$page}.php";
} elseif (in_array($page, ['blog1'])) {
    $page_file = "./pages/blog_pages/{$page}.php";
} elseif (in_array($page, ['contact1','contact2'])) {
    $page_file = "./pages/contact_pages/{$page}.php";
} else {
    $page_file = "./pages/{$page}.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/admin.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-white">Düzenlemeler</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" id="homeMenuToggle" data-toggle="collapse" data-target="#homeSubmenu" aria-expanded="false">Ana Sayfa </a>
                <div class="collapse list-group" id="homeSubmenu">
                    <a href="?page=home1" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 1</a>
                    <a href="?page=home2" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 2</a>
                    <a href="?page=home3" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 3</a>
                    <a href="?page=home4" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 4</a>
                    <a href="?page=home5" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 5</a>
                    <a href="?page=home6" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 6</a>
                </div>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" id="aboutMenuToggle" data-toggle="collapse" data-target="#aboutSubmenu" aria-expanded="false">Hakkımda </a>
                <div class="collapse list-group" id="aboutSubmenu">
                    <a href="?page=about1" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 1</a>
                    <a href="?page=about2" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 2</a>
                    <a href="?page=about3" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 3</a>
                    <a href="?page=about4" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 4</a>
                </div>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" id="servicesMenuToggle" data-toggle="collapse" data-target="#servicesSubmenu" aria-expanded="false">Hizmetlerimiz </a>
                <div class="collapse list-group" id="servicesSubmenu">
                    <a href="?page=services1" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 1</a>
                    <a href="?page=services2" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 2</a>
                </div>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" id="blogMenuToggle" data-toggle="collapse" data-target="#blogSubmenu" aria-expanded="false">Blog </a>
                <div class="collapse list-group" id="blogSubmenu">
                    <a href="?page=blog1" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 1</a>
                </div>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" id="contactToggle" data-toggle="collapse" data-target="#contactSubmenu" aria-expanded="false">İletişim</a>
                <div class="collapse list-group" id="contactSubmenu">
                    <a href="?page=contact1" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 1</a>
                    <a href="?page=contact2" class="list-group-item list-group-item-action bg-dark text-white">Sayfa 2</a>
                </div>

            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
                <button class="btn btn-primary" id="menu-toggle">&#9776;</button>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="?logout=true">Quit</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid">
                <?php include $page_file; ?>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="./js/admin.js"></script>
</body>
</html>
