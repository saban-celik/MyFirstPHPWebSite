<?php
require 'admin/db_connect.php';
// Mevcut içerikleri çekme
$query = "SELECT * FROM services1";
$result = $conn->query($query);
if (!$result) {
    die("Veritabanı hatası: " . $conn->error);
}
$services1Contents = $result->fetch_all(MYSQLI_ASSOC);

// home3_cards tablosundan verileri çekme
$query = "SELECT * FROM home3_cards";
$result = $conn->query($query);
if (!$result) {
    die("Veritabanı hatası: " . $conn->error);
}
$home3Cards = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hizmetler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="main-services-div">
    <div class="services-one-content-all">
            <div class="services-one-content container">
                <?php if (!empty($services1Contents)): ?>
                    <?php foreach ($services1Contents as $content): ?>
                        <h2><?php echo htmlspecialchars($content['title']); ?></h2>
                        <p><?php echo htmlspecialchars($content['content']); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Henüz herhangi bir hizmet içeriği eklenmemiş.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="services-two-content-all">
            <div class="services-two-content">
                <div class="container">
                    <div class="row" id="services-cards">
                        <!-- Kartlar buraya eklenecek -->
                        <?php foreach ($home3Cards as $card): ?>
                      <div class="col-md-4 mb-4">
                         <div class="card h-100">
                      <?php if (!empty($card['card1_image'])): ?>
                   <!-- Resim yolunu doğru aldığınızdan emin olun -->
                <img src="img/<?php echo htmlspecialchars($card['card1_image']); ?>" class="card-img-top" alt="Hizmet Resmi">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($card['card1_title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($card['card1_text']); ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>