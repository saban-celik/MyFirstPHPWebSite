<?php
require 'admin/db_connect.php'; 

// Blog tablosundan verileri çekme
$query = "SELECT * FROM blog ORDER BY date DESC ";
$result = $conn->query($query);
$blogs = $result->fetch_all(MYSQLI_ASSOC);
?>

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
                    <div class="row">
                    <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <?php if (!empty($blog['image'])): ?>
                            <img src="img/<?php echo htmlspecialchars($blog['image']); ?>" class="card-img-top" alt="Blog Resmi">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($blog['content']); ?></p>
                            <p class="card-date"><?php echo htmlspecialchars($blog['date']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Henüz blog eklenmemiş.</p>
        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
