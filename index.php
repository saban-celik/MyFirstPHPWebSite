<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHOTO X</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body class="home">
    <?php include 'includes/navbar.php'; ?>
    <div id="content">
        <?php
        // Sayfa parametresini al
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        // Dinamik içerik sayfalarını yükle
        $allowedPages = ['home', 'about', 'services', 'blog', 'contact','product_photography'];
        if (in_array($page, $allowedPages)) {
            include "pages/$page.php";
        } else {
            echo "<p>İçerik bulunamadı.</p>"; 
        }
        ?>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Bize Ulaşın</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Aşağıdaki formu doldursanız, kısa süre içinde sizinle iletişime geçeceğiz.</p>
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Adınız Soyadınız *</label>
                            <input type="text" class="form-control" id="name" placeholder="Adınız Soyadınız" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresi *</label>
                            <input type="email" class="form-control" id="email" placeholder="E-mail" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefon Numarası *</label>
                            <input type="tel" class="form-control" id="phone" placeholder="+90" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mesaj</label>
                            <textarea class="form-control" id="message" rows="3" placeholder="Mesajınızı giriniz..." maxlength="180"></textarea>
                            <div class="form-text">0 / 180</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
