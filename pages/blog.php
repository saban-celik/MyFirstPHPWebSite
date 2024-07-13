<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/blog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="main-blog-div">
        <div class="blog-one-content-all">
            <div class="blog-one-content container">
                <h2>Blog</h2>
                <div class="search-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i> <!-- Arama simgesi -->
                    <input type="text" placeholder="Ara...">
                </div>
            </div>
        </div>
        <div class="blog-two-content-all">
            <div class="blog-two-content">
                <div class="container">
                    <div class="row" id="blog-cards-container">
                    </div>
                    <div class="more-content">
                        <button id="load-more-btn" class="btn btn-primary">Daha Fazla Görüntüle</button>
                        <p id="no-more-posts" class="text-muted" style="display: none;">Gösterilecek başka gönderi yok</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
