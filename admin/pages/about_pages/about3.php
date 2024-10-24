<?php
require '../admin/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // İçerik yükleme
    if (isset($_POST['submit'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);
        
        $query = "INSERT INTO about3 (title, content) VALUES ('$title', '$content')";
        if ($conn->query($query)) {
            $about3_id = $conn->insert_id;
            echo "İçerik başarıyla yüklendi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }

    // Kart ekleme
    if (isset($_POST['add_card'])) {
        $about3_id = $_POST['about3_id'];
        $card_title = $conn->real_escape_string($_POST['card_title']);
        $card_content = $conn->real_escape_string($_POST['card_content']);
        
        $query = "INSERT INTO about3_cards (about3_id, card_title, card_content) VALUES ('$about3_id', '$card_title', '$card_content')";
        if ($conn->query($query)) {
            echo "Kart başarıyla eklendi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }

    // İçerik güncelleme
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $content = $conn->real_escape_string($_POST['content']);
        $title = $conn->real_escape_string($_POST['title']);

        $query = "UPDATE about3 SET title = '$title', content = '$content' WHERE id = $id";
        if ($conn->query($query)) {
            echo "İçerik başarıyla güncellendi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }

    // İçerik silme
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM about3 WHERE id = $id";
        if ($conn->query($query)) {
            echo "İçerik başarıyla silindi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }
}

// İçerikleri çekme
$query = "SELECT * FROM about3";
$result = $conn->query($query);
if (!$result) {
    die("Veritabanı hatası: " . $conn->error);
}
$about3Contents = $result->fetch_all(MYSQLI_ASSOC);

foreach ($about3Contents as &$content) {
    // Her içerik için kartları çekme
    $about3_id = $content['id'];
    $cardQuery = "SELECT * FROM about3_cards WHERE about3_id = $about3_id";
    $cardResult = $conn->query($cardQuery);
    if ($cardResult) {
        $content['cards'] = $cardResult->fetch_all(MYSQLI_ASSOC);
    } else {
        $content['cards'] = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About3 Content Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
    <style>
        .content-container {
            margin-bottom: 30px;
        }
        .content-text {
            max-width: 100%;
        }
        .card-container {
            margin-top: 20px;
        }
        .table-card-inputs td {
            padding: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Başlık ve Paragraf</h2>

        <!-- İçerik Yükleme Formu -->
        <form action="" method="POST">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>İçerik</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="title" class="form-control" required>
                        </td>
                        <td>
                            <textarea name="content" class="form-control" required></textarea>
                        </td>
                        <td>
                            <button type="submit" name="submit" class="btn btn-primary">İçerik Yükle</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <!-- İçerik Listeleme -->
        <div class="row mt-5">
            <?php foreach ($about3Contents as $content): ?>
                <div class="col-md-12 mb-4">
                    <div class="content-container">
                        <h3><?php echo htmlspecialchars($content['title']); ?></h3>
                        <p><?php echo htmlspecialchars($content['content']); ?></p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal<?php echo $content['id']; ?>">Güncelle</button>
                        <form action="" method="POST" class="d-inline" onsubmit="return confirm('Bu içeriği silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                            <button type="submit" name="delete" class="btn btn-secondary">Sil</button>
                        </form>
                         <!-- Kart Ekleme Formu -->
                         <h5 class="mt-3">Yeni Kart Ekle</h5>
                            <form action="" method="POST">
                                <input type="hidden" name="about3_id" value="<?php echo $content['id']; ?>">
                                <table class="table table-bordered table-card-inputs">
                                    <thead>
                                        <tr>
                                            <th>Kart Başlığı</th>
                                            <th>Kart İçeriği</th>
                                            <th>İşlem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="card_title" class="form-control" required>
                                            </td>
                                            <td>
                                                <textarea name="card_content" class="form-control" required></textarea>
                                            </td>
                                            <td>
                                                <button type="submit" name="add_card" class="btn btn-primary">Kart Ekle</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        <!-- Kartlar -->
                        <div class="card-container">
                            <h4>Kartlar:</h4>
                            <div class="row">
                                <?php foreach ($content['cards'] as $card): ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($card['card_title']); ?></h5>
                                                <p class="card-text"><?php echo htmlspecialchars($card['card_content']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                           
                        </div>
                    </div>

                    <!-- Güncelleme Modalı -->
                    <div class="modal fade" id="updateModal<?php echo $content['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?php echo $content['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel<?php echo $content['id']; ?>">İçerik Güncelle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                        <div class="form-group">
                                            <label for="title">Başlık:</label>
                                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($content['title']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">İçerik:</label>
                                            <textarea name="content" class="form-control" required><?php echo htmlspecialchars($content['content']); ?></textarea>
                                        </div>
                                        <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
