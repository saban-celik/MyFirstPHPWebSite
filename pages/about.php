<?php
require 'admin/db_connect.php';

// Mevcut içerikleri çekme
$query = "SELECT * FROM about1";
$result = $conn->query($query);
if (!$result) {
    die("Veritabanı hatası: " . $conn->error);
}
$about1Contents = $result->fetch_all(MYSQLI_ASSOC);

// about2 tablosundan veri çekme
$queryAbout2 = "SELECT * FROM about2";
$resultAbout2 = $conn->query($queryAbout2);
if (!$resultAbout2) {
    die("Veritabanı hatası: " . $conn->error);
}
$about2Contents = $resultAbout2->fetch_all(MYSQLI_ASSOC);

// about3 tablosundan veri çekme
$queryAbout3 = "SELECT * FROM about3";
$resultAbout3 = $conn->query($queryAbout3);
if (!$resultAbout3) {
    die("Veritabanı hatası: " . $conn->error);
}
$about3Contents = $resultAbout3->fetch_all(MYSQLI_ASSOC);

// about3_cards tablosundan veri çekme
$queryAbout3Cards = "SELECT * FROM about3_cards";
$resultAbout3Cards = $conn->query($queryAbout3Cards);
if (!$resultAbout3Cards) {
    die("Veritabanı hatası: " . $conn->error);
}
$about3CardsContents = $resultAbout3Cards->fetch_all(MYSQLI_ASSOC);

// about4 tablosundan veri çekme
$queryAbout4 = "SELECT * FROM about4";
$resultAbout4 = $conn->query($queryAbout4);
if (!$resultAbout4) {
    die("Veritabanı hatası: " . $conn->error);
}
$about4Contents = $resultAbout4->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hizmetler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+CL:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="main-about-div">
    <!-- About One Content -->
    <div class="about-one-content-all">
        <div class="about-one-content container">
            <?php if (!empty($about1Contents)): ?>
                <?php foreach ($about1Contents as $content): ?>
                    <h2><?php echo htmlspecialchars($content['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($content['content'])); ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="contact-info">
                <a href="index.php?page=contact" class="btn btn-primary">İletişime Geç</a>
            </div>
        </div>
    </div>

    <!-- About Two Content -->
    <div class="about-two-content-all">
        <div class="about-two-content-half black"></div>
        <div class="about-two-content-half white"></div>
        <div class="about-two-content">
            <?php if (!empty($about1Contents)): ?>
                <?php foreach ($about1Contents as $content): ?>
                    <?php if (!empty($content['image'])): ?>
                        <img src="img/<?php echo htmlspecialchars($content['image']); ?>" alt="About Image" class="img-fluid">
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Gösterilecek içerik bulunamadı.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- About Three Content -->
    <div class="about-three-content-all">
        <?php if (!empty($about2Contents)): ?>
            <?php foreach ($about2Contents as $content): ?>
                <div class="about-three-content container">
                    <?php if (!empty($content['image'])): ?>
                        <img src="img/<?php echo htmlspecialchars($content['image']); ?>" alt="Story Image" class="img-fluid">
                    <?php endif; ?>
                    <div class="about-three-text">
                        <h2><?php echo htmlspecialchars($content['title']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($content['content'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Gösterilecek içerik bulunamadı.</p>
        <?php endif; ?>
    </div>

    <!-- About Four Content -->
    <div class="about-four-content-all">
        <div class="about-four-content container">
            <?php if (!empty($about3Contents)): ?>
                <?php foreach ($about3Contents as $content): ?>
                    <h2><?php echo htmlspecialchars($content['title']); ?></h2>
                    <div class="line"></div>
                    <p><?php echo nl2br(htmlspecialchars($content['content'])); ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Gösterilecek içerik bulunamadı.</p>
            <?php endif; ?>
            <div class="row">
                <?php if (!empty($about3CardsContents)): ?>
                    <?php foreach ($about3CardsContents as $card): ?>
                        <div class="col-md-4 value-card">
                            <h3><?php echo htmlspecialchars($card['card_title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($card['card_content'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Gösterilecek kart içeriği bulunamadı.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="about-five-content-all">
        <div class="about-five-content container">
            <?php if (!empty($about4Contents)): ?>
                <?php foreach ($about4Contents as $content): ?>
                    <h2><?php echo htmlspecialchars($content['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($content['content'])); ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Gösterilecek kart içeriği bulunamadı.</p>
            <?php endif; ?>
            <a href="index.php?page=contact" class="btn btn-primary">İletişime Geç</a>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
