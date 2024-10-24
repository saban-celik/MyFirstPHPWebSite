<?php
require './db_connect.php';

// Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            if (isset($_POST['name'])) {
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $image = '';

                if (!empty($_FILES['image']['name'])) {
                    $target_dir = "./img/"; // Burada dizin yolunu kontrol edin
                    $image = basename($_FILES['image']['name']);
                    $target_file = $target_dir . $image;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                        // Başarı mesajı
                    } else {
                        echo "Resim yükleme hatası.";
                    }
                }

                $query = "INSERT INTO home4 (name, image) VALUES ('$name', '$image')";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            }
        } elseif ($_POST['action'] == 'update') {
            if (isset($_POST['id']) && isset($_POST['name'])) {
                $id = intval($_POST['id']);
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $image = '';

                if (!empty($_FILES['image']['name'])) {
                    $target_dir = "./img/"; // Burada dizin yolunu kontrol edin
                    $image = basename($_FILES['image']['name']);
                    $target_file = $target_dir . $image;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                        // Başarı mesajı
                    } else {
                        echo "Resim güncelleme hatası.";
                    }
                }

                $query = "UPDATE home4 SET name = '$name', image = '$image' WHERE id = $id";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            }
        } elseif ($_POST['action'] == 'delete') {
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']);
                $query = "DELETE FROM home4 WHERE id = $id";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            }
        }
        // Sayfayı yenilemek veya yönlendirme yapmak
        header("Location: ?page=home4");
        exit;
    }
}

// Verileri çekme
$query = "SELECT * FROM home4";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Ekibimiz Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Ekibimiz Yönetimi</h1>

    <!-- Ekleme Formu -->
    <form action="?page=home4" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">İsim</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="image" class="form-label">Resim</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>

    <!-- Veri Listeleme ve Düzenleme -->
    <div class="mt-5">
        <h2>Mevcut Veriler</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <?php if (!empty($row['image'])): ?>
                            <img src="./img/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top small-img" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <form action="?page=home4" method="post" class="d-inline">
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
                                            <form action="?page=home4" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="update_name" class="form-label">İsim</label>
                                                    <input type="text" class="form-control" id="update_name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="update_image" class="form-label">Resim</label>
                                                    <input type="file" class="form-control" id="update_image" name="image" accept="image/*">
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
            <?php endwhile; ?>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
