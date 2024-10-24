<?php
require 'admin/db_connect.php'; 

// home1 tablosundan veri çekme
$query1 = "SELECT * FROM home1 LIMIT 1";
$result1 = $conn->query($query1);
$home1Content = $result1->fetch_assoc();

// home2 tablosundan veri çekme
$query2 = "SELECT * FROM home2 LIMIT 1";
$result2 = $conn->query($query2);
$home2Content = $result2->fetch_assoc();

// home3 tablosundan veri çekme
$query3 = "SELECT * FROM home3 LIMIT 1";
$result3 = $conn->query($query3);
$home3Content = $result3->fetch_assoc();

// home3_cards tablosundan veri çekme
$query4 = "SELECT * FROM home3_cards LIMIT 6" ;
$result4 = $conn->query($query4);
$home3Cards = $result4->fetch_all(MYSQLI_ASSOC);

// home4 tablosundan veri çekme
$query5 = "SELECT * FROM home4";
$result5 = $conn->query($query5);
$home4Content = $result5->fetch_all(MYSQLI_ASSOC);

// Verileri çekme
$query_home5 = "SELECT * FROM home5 LIMIT 1"; // Veriyi çekmek için LIMIT 1 ekledim
$result_home5 = $conn->query($query_home5);
$home5Content = $result_home5->fetch_assoc(); // Veriyi almayı unutmayın

$query_brands = "SELECT * FROM home5_brands";
$result_brands = $conn->query($query_brands);

// Markaları array'e at
$brands = [];
while ($row = $result_brands->fetch_assoc()) {
    $brands[] = $row;
}

// İlk iki marka adı ve açıklamasını belirleyelim
$brand_names = array_column($brands, 'brand_name');
$brand_descriptions = array_column($brands, 'brand_description');

// Blog tablosundan verileri çekme
$query = "SELECT * FROM blog ORDER BY date DESC LIMIT 3";
$result = $conn->query($query);
$blogs = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hizmetler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <div class="home-home-content">
        <div class="container home-content">
            <div class="text-image-side-by-side">
                <div class="text-content">
                    <?php if (!empty($home1Content)): ?>
                        <h1><?php echo nl2br(htmlspecialchars($home1Content['title'])); ?></h1>
                        <p><?php echo nl2br(htmlspecialchars($home1Content['content'])); ?></p>
                    <?php else: ?>
                        <p>No content available.</p>
                    <?php endif; ?>
                    <a href="index.php?page=services" class="btn btn-primary">Hizmetleri Gör</a>
                    <a href="index.php?page=contact" class="btn btn-secondary">İletişime Geç</a>
                </div>
                <div class="image-content">
                    <?php if (!empty($home1Content)): ?>
                        <img src="img/<?php echo htmlspecialchars($home1Content['image']); ?>" alt="Photo Example" class="img-fluid">
                    <?php else: ?>
                        <p>No image available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="home-two-content" id="about-section">
        <div class="container home-content">
            <div class="about-section">
                <?php if (!empty($home2Content)): ?>
                    <div class="image-content">
                        <img src="img/<?php echo htmlspecialchars($home2Content['image1']); ?>" alt="Image 1" class="img-fluid">
                    </div>
                    <div class="about-text-content">
                        <h1><?php echo nl2br(htmlspecialchars($home2Content['title'])); ?></h1>
                        <p><?php echo nl2br(htmlspecialchars($home2Content['content'])); ?></p>
                        <a href="index.php?page=about" class="btn btn-primary">Devamını Oku</a>
                    </div>
                    <div class="about-images">
                        <img src="img/<?php echo htmlspecialchars($home2Content['image2']); ?>" alt="Example Image 1" class="about-image about-image-left">
                        <img src="img/<?php echo htmlspecialchars($home2Content['image3']); ?>" alt="Example Image 2" class="about-image about-image-bottom">
                    </div>
                <?php else: ?>
                    <p>No content available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="outer-container">
        <div class="container services-content">
            <?php if (!empty($home3Content)): ?>
                <h2><?php echo nl2br(htmlspecialchars($home3Content['title'])); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($home3Content['content'])); ?></p>
            <?php else: ?>
                <p>No content available.</p>
            <?php endif; ?>
            <a href="index.php?page=services" class="btn btn-primary">Tüm hizmetleri görüntüle</a>
            
            <div class="row">
                <?php foreach ($home3Cards as $card): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <?php if (!empty($card['card1_image'])): ?>
                                <img src="img/<?php echo htmlspecialchars($card['card1_image']); ?>" class="card-img-top" alt="Kart Resmi">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($card['card1_title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($card['card1_text']); ?></p>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="home-four-content">
        <div class="container">
            <h2>Ekibimiz</h2>
            <div class="row">
                <?php foreach ($home4Content as $member): ?>
                    <div class="col-md-3 mb-3">
                        <div class="team-member">
                            <?php if (!empty($member['image'])): ?>
                                <img src="img/<?php echo htmlspecialchars($member['image']); ?>" alt="Team Member" class="img-fluid">
                            <?php endif; ?>
                            <div class="overlay"><?php echo htmlspecialchars($member['name']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="home-five-content">
        <div class="container equipment-content">
            <div class="equipment-list">
                <?php if (!empty($home5Content)): ?>
                    <h2><?php echo htmlspecialchars($home5Content['title']); ?></h2>
                    <p><?php echo htmlspecialchars($home5Content['description']); ?></p>
                <?php else: ?>
                    <p>No content available.</p>
                <?php endif; ?>
                <div class="equipment-lists">
                    <ul>
                        <?php foreach ($brand_names as $name): ?>
                            <li>= <?php echo htmlspecialchars($name); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <ul>
                        <?php foreach ($brand_descriptions as $description): ?>
                            <li>= <?php echo htmlspecialchars($description); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="equipment-image">
                <?php
                if (!empty($home5Content['image'])): ?>
                    <img src="img/<?php echo htmlspecialchars($home5Content['image']); ?>" alt="Ekipman Görseli" class="img-fluid">
                <?php else: ?>
                    <p>Resim mevcut değil.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="home-six-content">
    <div class="container">
        <div class="header">
            <h2>Blog</h2>
            <a href="index.php?page=blog" class="btn btn-primary">Tüm İçerikler</a>
        </div>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
