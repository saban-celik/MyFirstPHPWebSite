<?php
require '../admin/db_connect.php';

function uploadImage($file) {
    $targetDir = "../img/";
    $uniqueName = time() . '_' . basename($file["name"]);
    $targetFile = $targetDir . $uniqueName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Dosyanın bir resim olup olmadığını kontrol et
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Dosya bir resim değil.";
        $uploadOk = 0;
    }

    // Dosya boyutunu kontrol et (5MB'dan büyük olamaz)
    if ($file["size"] > 5000000) {
        echo "Dosya boyutu çok büyük.";
        $uploadOk = 0;
    }

    // Belirli dosya türlerine izin ver
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Yalnızca JPG, JPEG, PNG ve GIF dosya türlerine izin verilir.";
        $uploadOk = 0;
    }

    // Kontrol sonucu bir sorun yoksa dosyayı yükle
    if ($uploadOk == 1) {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            echo "Dosya yükleme sırasında hata oluştu.";
        }
    } else {
        echo "Dosya yükleme başarısız oldu.";
    }

    return null;
}

// İşlem kontrolü
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Ekleme işlemi (Sadece bir kez eklenir)
    if ($action == 'add') {
        $existingEntry = $conn->query("SELECT * FROM about1")->fetch_assoc();
        if (!$existingEntry) {
            $title = $conn->real_escape_string($_POST['title']);
            $content = $conn->real_escape_string($_POST['content']);
            $imagePath = uploadImage($_FILES['image']);

            if ($imagePath) {
                $query = "INSERT INTO about1 (title, content, image) VALUES ('$title', '$content', '$imagePath')";
            } else {
                $query = "INSERT INTO about1 (title, content) VALUES ('$title', '$content')";
            }

            $conn->query($query);
        } else {
            echo "Zaten bir içerik mevcut, lütfen önce mevcut içeriği silin.";
        }
    }

    // Güncelleme işlemi (Eğer bir kayıt varsa güncellenir)
    if ($action == 'update') {
        $id = $conn->real_escape_string($_POST['id']);
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);
        $imagePath = uploadImage($_FILES['image']);

        if ($imagePath) {
            $query = "UPDATE about1 SET title='$title', content='$content', image='$imagePath' WHERE id='$id'";
        } else {
            $query = "UPDATE about1 SET title='$title', content='$content' WHERE id='$id'";
        }

        $conn->query($query);
    }

    // Silme işlemi (Kayıt silindiğinde tekrar eklenebilir)
    if ($action == 'delete') {
        $id = $conn->real_escape_string($_POST['id']);
        $query = "DELETE FROM about1 WHERE id='$id'";
        $conn->query($query);
    }
}

// Mevcut içerikleri çekme
$query = "SELECT * FROM about1";
$result = $conn->query($query);
$about1Contents = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About1 Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>About1 Yönetimi</h1>

    <!-- Yeni İçerik Ekleme Formu -->
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>İçerik</th>
                    <th>Resim</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="form-control" name="title" required></td>
                    <td><textarea class="form-control" name="content" rows="3" required></textarea></td>
                    <td><input type="file" class="form-control" name="image"></td>
                    <td><button type="submit" class="btn btn-primary">Ekle</button></td>
                </tr>
            </tbody>
        </table>
    </form>

    <hr>
    <h2>Mevcut İçerikler</h2>

    <!-- Mevcut İçerikler Tablosu -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Başlık</th>
                <th>İçerik</th>
                <th>Resim</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($about1Contents as $content): ?>
                <tr>
                    <td><?php echo htmlspecialchars($content['title']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($content['content'])); ?></td>
                    <td>
                        <?php if (!empty($content['image'])): ?>
                            <img src="<?php echo $content['image']; ?>" alt="Resim" class="img-thumbnail" style="max-width: 100px;">
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $content['id']; ?>">Güncelle</button>
                        <form method="post" action="" class="d-inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                            <button type="submit" class="btn btn-secondary">Sil</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Güncelleme Modalı -->
    <?php foreach ($about1Contents as $content): ?>
        <div class="modal fade" id="updateModal<?php echo $content['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?php echo $content['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?php echo $content['id']; ?>">İçeriği Güncelle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                            <div class="mb-3">
                                <label for="title<?php echo $content['id']; ?>" class="form-label">Başlık</label>
                                <input type="text" class="form-control" id="title<?php echo $content['id']; ?>" name="title" value="<?php echo htmlspecialchars($content['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="content<?php echo $content['id']; ?>" class="form-label">İçerik</label>
                                <textarea class="form-control" id="content<?php echo $content['id']; ?>" name="content" rows="5" required><?php echo htmlspecialchars($content['content']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image<?php echo $content['id']; ?>" class="form-label">Resim</label>
                                <input type="file" class="form-control" id="image<?php echo $content['id']; ?>" name="image">
                               <?php if (!empty($content['image'])): ?>
                                <img src="<?php echo $content['image']; ?>" alt="Resim" class="img-thumbnail mt-2" style="max-width: 100px;">
                            <?php endif; ?>
                            
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<script src="js/script.js"></script>
</body>
</html>
