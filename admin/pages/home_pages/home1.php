<?php
require './db_connect.php';

// Görsel yükleme ve içerik ekleme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update']) && !isset($_POST['delete'])) {
    $target_dir = "../img/";
    $image_name = uniqid() . '_' . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $image_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_FILES["fileToUpload"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars($image_name) . " has been uploaded.";

                $title = $conn->real_escape_string($_POST['title']);
                $content = $conn->real_escape_string($_POST['content']);

                $sql = "INSERT INTO home1 (image, title, content) VALUES ('$image_name', '$title', '$content')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded or there was an error uploading the file.";
    }
}

// İçerik silme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    
    $query = "SELECT image FROM home1 WHERE id = $id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = "../img/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    $query = "DELETE FROM home1 WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        echo "Record deleted successfully";
        echo "<script>window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// İçerik güncelleme
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $update_image = "";

    if (!empty($_FILES["fileToUpload"]["name"])) {
        $target_dir = "../img/";
        $image_name = uniqid() . '_' . basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $image_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false && $_FILES["fileToUpload"]["size"] <= 500000 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $query = "SELECT image FROM home1 WHERE id = $id";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $old_image_path = "../img/" . $row['image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
                $update_image = ", image = '$image_name'";
            }
        }
    }

    $query = "UPDATE home1 SET title = '$title', content = '$content' $update_image WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        echo "Record updated successfully";
        echo "<script>window.location.href='" . $_SERVER['HTTP_REFERER'] . "';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home1 İçerik Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php
        $query = "SELECT COUNT(*) as count FROM home1";
        $result = $conn->query($query);
        $contentExists = ($result->fetch_assoc()['count'] > 0);
        ?>
        
        <?php if (!$contentExists): ?>
            <h2>Home1 İçerik Ekle</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fileToUpload" class="form-label">Görsel Seç</label>
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
                    </div>
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
        <?php endif; ?>

        <h1 class="mt-5">Home1 İçerik Düzenle/Sil</h1>
        <?php
        $query = "SELECT * FROM home1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()): ?>
                <div class="card mb-4 p-4">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="../img/<?php echo $row['image']; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['title']); ?>" style="max-width: 200px;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                                <form method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-secondary delete-btn">Sil</button>
                                </form>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $row['id']; ?>">Güncelle</button>
                            </div>
                        </div>
                    </div>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel<?php echo $row['id']; ?>">İçerik Güncelle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="?page=home1" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Başlık</label>
                                            <input type="text" class="form-control" name="title" id="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="content" class="form-label">İçerik</label>
                                            <textarea class="form-control" name="content" id="content" rows="3" required><?php echo htmlspecialchars($row['content']); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fileToUpload" class="form-label">Yeni Görsel Seç</label>
                                            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                            <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        } else {
            echo "<p>Henüz içerik eklenmemiş.</p>";
        }
        $conn->close();
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
