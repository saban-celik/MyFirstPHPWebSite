<?php
require './db_connect.php';

// Ekleme ve Güncelleme işlemleri
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $image = '';

        if (!empty($_FILES['image']['name'])) {
            $target_dir = "./img/";
            $image = basename($_FILES['image']['name']);
            $target_file = $target_dir . $image;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                echo "Resim yükleme başarılı.";
            } else {
                echo "Resim yükleme hatası.";
            }
        } else {
            $image = $_POST['existing_image'];
        }

        if ($_POST['action'] == 'add') {
            $query = "INSERT INTO blog (title, content, date, image) VALUES ('$title', '$content', '$date', '$image')";
        } elseif ($_POST['action'] == 'update') {
            $id = intval($_POST['id']);
            $query = "UPDATE blog SET title = '$title', content = '$content', date = '$date', image = '$image' WHERE id = $id";
        } elseif ($_POST['action'] == 'delete') {
            $id = intval($_POST['id']);
            $query = "DELETE FROM blog WHERE id = $id";
        }

        if (!$conn->query($query)) {
            echo "Hata: " . $conn->error;
        }
        header("Location: ?page=home6");
        exit;
    }
}

// Verileri çekme
$query = "SELECT * FROM blog";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Blog Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Blog Yönetimi</h1>

    <!-- Ekleme Formu -->
    <form action="?page=home6" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="title" class="form-label">Başlık</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="content" class="form-label">İçerik</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">Tarih</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="image" class="form-label">Resim</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>

    <div class="mt-5">
        <h2>Mevcut Veriler</h2>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <?php if (!empty($row['image'])): ?>
                            <img src="./img/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="Blog Resmi">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                            <p class="card-date"><?php echo htmlspecialchars($row['date']); ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <form action="?page=home6" method="post">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button type="submit" class="btn btn-secondary">Sil</button>
                            </form>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal"
                                    data-id="<?php echo htmlspecialchars($row['id']); ?>"
                                    data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                    data-content="<?php echo htmlspecialchars($row['content']); ?>"
                                    data-date="<?php echo htmlspecialchars($row['date']); ?>"
                                    data-image="<?php echo htmlspecialchars($row['image']); ?>">Güncelle
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<!-- Güncelle Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Blog Güncelle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateForm" action="?page=home6" method="post" enctype="multipart/form-data">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="id" id="updateId">
          <div class="mb-3">
            <label for="updateTitle" class="form-label">Başlık</label>
            <input type="text" class="form-control" id="updateTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="updateContent" class="form-label">İçerik</label>
            <textarea class="form-control" id="updateContent" name="content" required></textarea>
          </div>
          <div class="mb-3">
            <label for="updateDate" class="form-label">Tarih</label>
            <input type="date" class="form-control" id="updateDate" name="date" required>
          </div>
          <div class="mb-3">
            <label for="updateImage" class="form-label">Resim</label>
            <input type="file" class="form-control" id="updateImage" name="image" accept="image/*">
            <input type="hidden" id="existingImage" name="existing_image">
            <div id="currentImageContainer" class="mt-2">
              <label>Mevcut Resim:</label>
              <img id="currentImage" src="" alt="Mevcut Resim" style="max-width: 100%;">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
  const updateModal = document.getElementById('updateModal');
  updateModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const title = button.getAttribute('data-title');
    const content = button.getAttribute('data-content');
    const date = button.getAttribute('data-date');
    const image = button.getAttribute('data-image');

    const modalTitle = updateModal.querySelector('.modal-title');
    const updateId = updateModal.querySelector('#updateId');
    const updateTitle = updateModal.querySelector('#updateTitle');
    const updateContent = updateModal.querySelector('#updateContent');
    const updateDate = updateModal.querySelector('#updateDate');
    const existingImage = updateModal.querySelector('#existingImage');
    const currentImage = updateModal.querySelector('#currentImage');
    const currentImageContainer = updateModal.querySelector('#currentImageContainer');

    modalTitle.textContent = `Güncelle: ${title}`;
    updateId.value = id;
    updateTitle.value = title;
    updateContent.value = content;
    updateDate.value = date;
    existingImage.value = image;
    if (image) {
      currentImage.src = './img/' + image;
      currentImageContainer.style.display = 'block';
    } else {
      currentImageContainer.style.display = 'none';
    }
  });
</script>
</body>
</html>