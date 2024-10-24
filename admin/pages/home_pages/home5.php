<?php
require './db_connect.php';

// Ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'add') {
            if (isset($_POST['type']) && $_POST['type'] == 'brand') {
                $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
                $brand_description = mysqli_real_escape_string($conn, $_POST['brand_description']);

                $query = "INSERT INTO home5_brands (brand_name, brand_description) VALUES ('$brand_name', '$brand_description')";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            } else {
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $image = '';

                if (!empty($_FILES['image']['name'])) {
                    $target_dir = "./img/";
                    $image = basename($_FILES['image']['name']);
                    $target_file = $target_dir . $image;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                        // Başarı mesajı
                    } else {
                        echo "Resim yükleme hatası.";
                    }
                }

                $query = "INSERT INTO home5 (title, description, image) VALUES ('$title', '$description', '$image')";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            }
        } elseif ($_POST['action'] == 'update') {
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']);
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $image = '';

                if (!empty($_FILES['image']['name'])) {
                    $target_dir = "./img/";
                    $image = basename($_FILES['image']['name']);
                    $target_file = $target_dir . $image;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                        // Başarı mesajı
                    } else {
                        echo "Resim güncelleme hatası.";
                    }
                } else {
                    // Mevcut resim saklanacak
                    $existing_image_query = "SELECT image FROM home5 WHERE id = $id";
                    $existing_image_result = $conn->query($existing_image_query);
                    if ($existing_image_result && $existing_image_row = $existing_image_result->fetch_assoc()) {
                        $image = $existing_image_row['image'];
                    }
                }

                $query = "UPDATE home5 SET title = '$title', description = '$description', image = '$image' WHERE id = $id";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            } elseif (isset($_POST['brand_id'])) {
                $brand_id = intval($_POST['brand_id']);
                $brand_name = mysqli_real_escape_string($conn, $_POST['brand_name']);
                $brand_description = mysqli_real_escape_string($conn, $_POST['brand_description']);

                $query = "UPDATE home5_brands SET brand_name = '$brand_name', brand_description = '$brand_description' WHERE id = $brand_id";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            }
        } elseif ($_POST['action'] == 'delete') {
            if (isset($_POST['id'])) {
                $id = intval($_POST['id']);
                $query = "DELETE FROM home5 WHERE id = $id";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            } elseif (isset($_POST['brand_id'])) {
                $brand_id = intval($_POST['brand_id']);
                $query = "DELETE FROM home5_brands WHERE id = $brand_id";
                if (!$conn->query($query)) {
                    echo "Hata: " . $conn->error;
                }
            }
        }
        // Sayfayı yenilemek veya yönlendirme yapmak
        header("Location: ?page=home5");
        exit;
    }
}

// Verileri çekme
$query_home5 = "SELECT * FROM home5";
$result_home5 = $conn->query($query_home5);

$query_brands = "SELECT * FROM home5_brands";
$result_brands = $conn->query($query_brands);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Ekipman Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Ekipman Yönetimi</h1>
    
    <!-- Ekipman Ekleme Formu -->
    <form action="?page=home5" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="title" class="form-label">Başlık</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="col-md-4">
                <label for="description" class="form-label">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="col-md-4">
                <label for="image" class="form-label">Resim</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>

    <!-- Marka Ekleme Formu -->
    <form action="?page=home5" method="post">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="type" value="brand">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="brand_name" class="form-label">Marka Adı</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" required>
            </div>
            <div class="col-md-6">
                <label for="brand_description" class="form-label">Marka Açıklaması</label>
                <input type="text" class="form-control" id="brand_description" name="brand_description" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Marka Ekle</button>
    </form>

    <div class="mt-5">
        <h2>Mevcut Veriler</h2>
        <div class="row">
            <?php while ($row = $result_home5->fetch_assoc()): ?>
                <div class="col-md-12 mb-4">
                    <div class="d-flex align-items-start">
                        <?php if (!empty($row['image'])): ?>
                            <img src="./img/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="img-fluid me-4 img-thumbnail home5-image">
                        <?php endif; ?>
                        <div>
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <div class="mt-3">
                                <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $row['id']; ?>">Güncelle</button>
                                <form action="?page=home5" method="post" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-secondary btn-lg">Sil</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel<?php echo $row['id']; ?>">Güncelle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="?page=home5" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="title<?php echo $row['id']; ?>" class="form-label">Başlık</label>
                                            <input type="text" class="form-control" id="title<?php echo $row['id']; ?>" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description<?php echo $row['id']; ?>" class="form-label">Açıklama</label>
                                            <textarea class="form-control" id="description<?php echo $row['id']; ?>" name="description" rows="3" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image<?php echo $row['id']; ?>" class="form-label">Resim</label>
                                            <input type="file" class="form-control" id="image<?php echo $row['id']; ?>" name="image" accept="image/*">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Güncelle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="mt-5">
    <h2>Markalar</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Marka Adı</th>
                <th>Marka Açıklaması</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_brands->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['brand_description']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateBrandModal<?php echo $row['id']; ?>">Güncelle</button>
                        <form action="?page=home5" method="post" class="d-inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="brand_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-secondary btn-sm">Sil</button>
                        </form>
                    </td>
                </tr>
                <!-- Update Brand Modal -->
                <div class="modal fade" id="updateBrandModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="updateBrandModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateBrandModalLabel<?php echo $row['id']; ?>">Marka Güncelle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="?page=home5" method="post">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="brand_id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="brand_name<?php echo $row['id']; ?>" class="form-label">Marka Adı</label>
                                        <input type="text" class="form-control" id="brand_name<?php echo $row['id']; ?>" name="brand_name" value="<?php echo htmlspecialchars($row['brand_name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="brand_description<?php echo $row['id']; ?>" class="form-label">Marka Açıklaması</label>
                                        <input type="text" class="form-control" id="brand_description<?php echo $row['id']; ?>" name="brand_description" value="<?php echo htmlspecialchars($row['brand_description']); ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
