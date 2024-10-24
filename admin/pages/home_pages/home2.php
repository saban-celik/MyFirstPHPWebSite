<?php
require './db_connect.php';

// Resim yükleme ve veritabanına ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        // Güncelleme işlemi
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Dosya yükleme işlemi
        for ($i = 0; $i < 3; $i++) {
            $target_dir = "../img/";
            $file_name = basename($_FILES["fileToUpload"]["name"][$i]);
            $target_file = $target_dir . $file_name;

            if ($file_name) { // Eğer bir dosya yüklenmişse
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file);
                $image_column = "image" . ($i + 1);
                $query = "UPDATE home2 SET $image_column = '$file_name' WHERE id = $id";
                $conn->query($query);
            }
        }

        // Başlık ve içerik güncelleme
        $query = "UPDATE home2 SET title = '$title', content = '$content' WHERE id = $id";
        $conn->query($query);
    } else {
        // Yeni içerik ekleme işlemi
        $title = $_POST['title'];
        $content = $_POST['content'];
        $images = [];

        // Dosya yükleme işlemi
        for ($i = 0; $i < 3; $i++) {
            $target_dir = "../img/";
            $file_name = basename($_FILES["fileToUpload"]["name"][$i]);
            $target_file = $target_dir . $file_name;
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file);
            $images[] = $file_name;
        }

        $query = "INSERT INTO home2 (image1, image2, image3, title, content) VALUES ('$images[0]', '$images[1]', '$images[2]', '$title', '$content')";
        $conn->query($query);
    }
}

// İçerik silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM home2 WHERE id = $id";
    $conn->query($query);
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home2 İçerik Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Home Sayfa 2 Düzenle</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="col-md-4">
                        <label for="fileToUpload<?php echo $i; ?>" class="form-label">Görsel Seç <?php echo $i + 1; ?></label>
                        <input type="file" class="form-control" name="fileToUpload[]" id="fileToUpload<?php echo $i; ?>">
                    </div>
                <?php endfor; ?>
                <div class="col-md-4">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Başlık Girin" required>
                </div>
                <div class="col-md-4">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" name="content" id="content" rows="3" placeholder="İçerik Girin" required></textarea>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-md-3 text-end">
                    <button type="submit" class="btn btn-primary">Yükle</button>
                </div>
            </div>
        </form>

        <h1 class="mt-5">Home2 İçerik Düzenle/Sil</h1>
        <?php
        // İçerikleri listele ve düzenleme/silme formunu göster
        $query = "SELECT id, image1, image2, image3, title, content FROM home2";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="row">
                            <?php for ($i = 0; $i < 3; $i++): ?>
                                <div class="col-md-4">
                                    <img src="../img/<?php echo htmlspecialchars($row['image' . ($i + 1)], ENT_QUOTES, 'UTF-8'); ?>" alt="Görsel <?php echo $i + 1; ?>" style="max-width: 100px;">
                                </div>
                            <?php endfor; ?>
                        </div>
                        <div class="row justify-content-end mt-3">
                            <div class="col-md-3 text-end">
                                <!-- Düzenle Butonu -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">
                                    Düzenle
                                </button>

                                <!-- Silme Linki -->
                                <a href="?delete=<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger">Sil</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Düzenleme Modalı -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">İçeriği Düzenle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <div class="row mb-3">
                                        <?php for ($i = 0; $i < 3; $i++): ?>
                                            <div class="col-md-4">
                                                <label for="fileToUpload<?php echo $i; ?>" class="form-label">Görsel <?php echo $i + 1; ?></label>
                                                <input type="file" class="form-control" name="fileToUpload[]" id="fileToUpload<?php echo $i; ?>">
                                                <div class="mt-2">
                                                    <img src="../img/<?php echo htmlspecialchars($row['image' . ($i + 1)], ENT_QUOTES, 'UTF-8'); ?>" alt="Görsel <?php echo $i + 1; ?>" style="max-width: 100px;">
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                        <div class="col-md-4">
                                            <label for="title" class="form-label">Başlık</label>
                                            <input type="text" class="form-control" name="title" id="title" value="<?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="content" class="form-label">İçerik</label>
                                            <textarea class="form-control" name="content" id="content" rows="3" required><?php echo htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-md-3 text-end">
                                            <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
