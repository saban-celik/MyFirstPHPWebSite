<?php
require './db_connect.php';

// Veritabanına ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        if (isset($_POST['title']) && isset($_POST['content'])) {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            $query = "INSERT INTO home3 (title, content) VALUES ('$title', '$content')";
            if (!$conn->query($query)) {
                echo "Hata: " . $conn->error;
            }
        }

        if (isset($_POST['card1_title']) && isset($_POST['card1_text'])) {
            $card1_title = mysqli_real_escape_string($conn, $_POST['card1_title']);
            $card1_text = mysqli_real_escape_string($conn, $_POST['card1_text']);
            $card1_image = '';

            if (!empty($_FILES['card1_image']['name'])) {
                $target_dir = "../img/"; // Burada dizin yolunu kontrol edin
                $card1_image = $target_dir . basename($_FILES['card1_image']['name']);
                if (move_uploaded_file($_FILES['card1_image']['tmp_name'], $card1_image)) {
                    echo "Resim başarıyla yüklendi.";
                } else {
                    echo "Resim yükleme hatası.";
                }
            }

            $query = "INSERT INTO home3_cards (card1_title, card1_text, card1_image) VALUES ('$card1_title', '$card1_text', '$card1_image')";
            if (!$conn->query($query)) {
                echo "Hata: " . $conn->error;
            }
        }
    }

    // Güncelleme işlemi
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content'])) {
            $id = intval($_POST['id']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            $query = "UPDATE home3 SET title = '$title', content = '$content' WHERE id = $id";
            if (!$conn->query($query)) {
                echo "Hata: " . $conn->error;
            }
        }

        if (isset($_POST['card_id']) && isset($_POST['card1_title']) && isset($_POST['card1_text'])) {
            $card_id = intval($_POST['card_id']);
            $card1_title = mysqli_real_escape_string($conn, $_POST['card1_title']);
            $card1_text = mysqli_real_escape_string($conn, $_POST['card1_text']);
            $card1_image = '';

            if (!empty($_FILES['card1_image']['name'])) {
                $target_dir = "../img/"; // Burada dizin yolunu kontrol edin
                $card1_image = $target_dir . basename($_FILES['card1_image']['name']);
                if (move_uploaded_file($_FILES['card1_image']['tmp_name'], $card1_image)) {
                    echo "Resim başarıyla yüklendi.";
                } else {
                    echo "Resim yükleme hatası.";
                }
            }

            $query = "UPDATE home3_cards SET card1_title = '$card1_title', card1_text = '$card1_text', card1_image = '$card1_image' WHERE id = $card_id";
            if (!$conn->query($query)) {
                echo "Hata: " . $conn->error;
            }
        }
    }

    // Silme işlemi
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $query = "DELETE FROM home3 WHERE id = $id";
            if (!$conn->query($query)) {
                echo "Hata: " . $conn->error;
            }
        }

        if (isset($_POST['card_id'])) {
            $card_id = intval($_POST['card_id']);
            $query = "DELETE FROM home3_cards WHERE id = $card_id";
            if (!$conn->query($query)) {
                echo "Hata: " . $conn->error;
            }
        }
    }
}

// Başlık ve Paragraf verilerini çekme
$query = "SELECT * FROM home3";
$result = $conn->query($query);

// Kart verilerini çekme
$cards_query = "SELECT * FROM home3_cards";
$cards_result = $conn->query($cards_query);

// Başlık ve paragraf olup olmadığını kontrol et
$title_content_exists = $result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Home3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php if (!$title_content_exists) { ?>
        <h1>Başlık ve Paragraf Ekle</h1>
        <form action="?page=home3" method="post">
            <input type="hidden" name="action" value="add">
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="content" class="form-label">Paragraf</label>
                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Yükle</button>
        </form>
    <?php } ?>

    <h1 class="mt-5">Kartlar İçeriği Ekle</h1>
    <form action="?page=home3" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="row mb-3">
            <div class="col-md-4 mb-3">
                <label for="card1_image" class="form-label">Kart 1 Resim</label>
                <input type="file" class="form-control" id="card1_image" name="card1_image" accept="image/*">
            </div>
            <div class="col-md-4 mb-3">
                <label for="card1_title" class="form-label">Kart 1 Başlık</label>
                <input type="text" class="form-control" id="card1_title" name="card1_title" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="card1_text" class="form-label">Kart 1 Açıklama</label>
                <textarea class="form-control" id="card1_text" name="card1_text" rows="3" required></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>

    <h1 class="mt-5">Başlık ve Paragraf </h1>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-12 mb-3">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <form action="?page=home3" method="post" class="d-inline">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn btn-secondary">Sil</button>
                </form>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $row['id']; ?>">Güncelle</button>

                <!-- Güncelle Modal -->
                <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel">Güncelle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="?page=home3" method="post">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="update_title" class="form-label">Başlık</label>
                                        <input type="text" class="form-control" id="update_title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="update_content" class="form-label">Paragraf</label>
                                        <textarea class="form-control" id="update_content" name="content" rows="3" required><?php echo htmlspecialchars($row['content']); ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <h1 class="mt-5">Kart İçerikleri</h1>
    <div class="row">
        <?php while ($card = $cards_result->fetch_assoc()) { ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <?php if (!empty($card['card1_image'])) { ?>
                        <img src="<?php echo htmlspecialchars($card['card1_image']); ?>" class="card-img-top" alt="Resim">
                    <?php } ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($card['card1_title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($card['card1_text']); ?></p>
                        <form action="?page=home3" method="post" class="d-inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                            <button type="submit" class="btn btn-secondary">Sil</button>
                        </form>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateCardModal<?php echo $card['id']; ?>">Güncelle</button>

                        <!-- Güncelle Kart Modal -->
                        <div class="modal fade" id="updateCardModal<?php echo $card['id']; ?>" tabindex="-1" aria-labelledby="updateCardModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateCardModalLabel">Güncelle Kart</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="?page=home3" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                            <div class="mb-3">
                                                <label for="update_card_image" class="form-label">Resim</label>
                                                <input type="file" class="form-control" id="update_card_image" name="card1_image" accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_card_title" class="form-label">Başlık</label>
                                                <input type="text" class="form-control" id="update_card_title" name="card1_title" value="<?php echo htmlspecialchars($card['card1_title']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="update_card_text" class="form-label">Açıklama</label>
                                                <textarea class="form-control" id="update_card_text" name="card1_text" rows="3" required><?php echo htmlspecialchars($card['card1_text']); ?></textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Güncelle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
