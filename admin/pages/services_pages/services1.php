<?php
require '../admin/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // İçerik yükleme
    if (isset($_POST['submit'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);

        $query = "INSERT INTO services1 (title, content) VALUES ('$title', '$content')";
        if ($conn->query($query)) {
            echo "İçerik başarıyla yüklendi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }

    // İçerik güncelleme
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);

        $query = "UPDATE services1 SET title = '$title', content = '$content' WHERE id = $id";
        if ($conn->query($query)) {
            echo "İçerik başarıyla güncellendi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }

    // İçerik silme
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $query = "DELETE FROM services1 WHERE id = $id";
        if ($conn->query($query)) {
            echo "İçerik başarıyla silindi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }
}

// Mevcut içerikleri çekme
$query = "SELECT * FROM services1";
$result = $conn->query($query);
if (!$result) {
    die("Veritabanı hatası: " . $conn->error);
}
$services1Contents = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services1 Content Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Hizmetler Başlık-İçerik Yönetimi</h2>

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
            <?php foreach ($services1Contents as $content): ?>
                <div class="col-md-12 mb-4">
                    <div>
                        <h3><?php echo htmlspecialchars($content['title']); ?></h3>
                        <p><?php echo htmlspecialchars($content['content']); ?></p>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal<?php echo $content['id']; ?>">Güncelle</button>
                        <form action="" method="POST" class="d-inline" onsubmit="return confirm('Bu içeriği silmek istediğinize emin misiniz?');">
                            <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                            <button type="submit" name="delete" class="btn btn-secondary">Sil</button>
                        </form>
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
