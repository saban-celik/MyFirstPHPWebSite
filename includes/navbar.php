
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=home">
            <img src="img/fotox-logo.jpg" alt="Logo" style="width:60px;">
            Foto X
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'home') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=home">Ana Sayfa</a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'about') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=about">Hakkımda</a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'product_photography') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=product_photography">Ürün Çekimi</a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'services') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=services">Hizmetlerimiz</a>
                </li>
               
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'blog') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=blog">Blog</a>
                </li>
                <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'contact') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php?page=contact">İletişim</a>
                </li>
               
            </ul>
        </div>
        <div class="d-flex">
        <button class="btn btn-outline-light btn-sm custom-button" data-bs-toggle="modal" data-bs-target="#contactModal">
         <div>
         <i class="fa-solid fa-square-phone"></i> Sizi<br>Arayalım
        </div>
</button>

        </div>
    </div>
</nav>
