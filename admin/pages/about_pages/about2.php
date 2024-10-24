<?php
require '../admin/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Resim ve içerik yükleme
    if (isset($_POST['submit'])) {
        $target_dir = "../img/";
        $uploadOk = 1;
        $image = '';
        $title = $conn->real_escape_string($_POST['title']);

        if (!empty($_FILES["image"]["name"])) {
            $target_file = $target_dir . uniqid() . '-' . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Resim dosyası olup olmadığını kontrol et
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Dosya bir resim değil.";
                $uploadOk = 0;
            }

            // Dosya zaten mevcutsa kontrol et
            if (file_exists($target_file)) {
                echo "Üzgünüz, dosya zaten var.";
                $uploadOk = 0;
            }

            // Dosya boyutunu kontrol et (5MB'den fazla olmamalı)
            if ($_FILES["image"]["size"] > 5000000) {
                echo "Üzgünüz, dosyanız çok büyük.";
                $uploadOk = 0;
            }

            // Belirli dosya türlerine izin ver
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Yalnızca JPG, JPEG, PNG & GIF dosya türlerine izin verilmektedir.";
                $uploadOk = 0;
            }

            // Dosya yükleme
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = basename($target_file);
                } else {
                    echo "Üzgünüz, dosya yüklenirken bir hata oluştu.";
                    $uploadOk = 0;
                }
            }
        } else {
            echo "Lütfen bir resim seçin.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            $content = $conn->real_escape_string($_POST['content']);
            $query = "INSERT INTO about2 (image, content, title) VALUES ('$image', '$content', '$title')";
            if ($conn->query($query)) {
                echo "İçerik başarıyla yüklendi.";
            } else {
                echo "Veritabanı hatası: " . $conn->error;
            }
        }
    }

    // İçerik güncelleme
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $content = $conn->real_escape_string($_POST['content']);
        $title = $conn->real_escape_string($_POST['title']);
        $image = $_POST['existing_image'];
        $target_dir = "../img/";

        // Yeni resim yüklenmişse
        if (!empty($_FILES["image"]["name"])) {
            $target_file = $target_dir . uniqid() . '-' . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = basename($target_file);
            }
        }

        $query = "UPDATE about2 SET image = '$image', content = '$content', title = '$title' WHERE id = $id";
        if ($conn->query($query)) {
            echo "İçerik başarıyla güncellendi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }

    // İçerik silme
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $query = "SELECT image FROM about2 WHERE id = $id";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_path = "../img/" . $row['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $query = "DELETE FROM about2 WHERE id = $id";
        if ($conn->query($query)) {
            echo "İçerik başarıyla silindi.";
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    }
}

// Mevcut içerikleri çekme
$query = "SELECT * FROM about2";
$result = $conn->query($query);
if (!$result) {
    die("Veritabanı hatası: " . $conn->error);
}
$about2Contents = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About2 Content Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
    <style>
        .content-container {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        .content-container img {
            max-width: 200px; /* Küçültme */
            height: auto;
            margin-right: 20px;
        }
        .content-text {
            max-width: 70%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Resim-Paragraf</h2>

        <!-- İçerik Yükleme Formu -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Resim Yükle</th>
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
                            <input type="file" name="image" class="form-control" required>
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
            <?php foreach ($about2Contents as $content): ?>
                <div class="col-md-12 mb-4">
                    <div class="content-container">
                        <img src="../img/<?php echo htmlspecialchars($content['image']); ?>" alt="Content Image">
                        <div class="content-text">
                            <h3><?php echo htmlspecialchars($content['title']); ?></h3>
                            <p><?php echo htmlspecialchars($content['content']); ?></p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal<?php echo $content['id']; ?>">Güncelle</button>
                            <form action="" method="POST" class="d-inline" onsubmit="return confirm('Bu içeriği silmek istediğinize emin misiniz?');">
                                <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-secondary">Sil</button>
                            </form>
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
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                                        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($content['image']); ?>">
                                        <div class="form-group">
                                            <label for="title">Başlık:</label>
                                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($content['title']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Yeni Resim (isteğe bağlı):</label>
                                            <input type="file" name="image" class="form-control">
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
