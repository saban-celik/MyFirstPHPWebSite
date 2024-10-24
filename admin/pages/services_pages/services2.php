<?php
require '../admin/db_connect.php';

// Verileri ekle
if (isset($_POST['add_card'])) {
    $title = $_POST['card_title'];
    $description = $_POST['card_description'];
    $image = $_FILES['card_image']['name'];
    $target = "../img/" . basename($image);

    $insert_query = "INSERT INTO home3_cards (card1_title, card1_text, card1_image) VALUES ('$title', '$description', '$image')";
    if ($conn->query($insert_query) === TRUE) {
        move_uploaded_file($_FILES['card_image']['tmp_name'], $target);
        echo "Yeni kart başarıyla eklendi!";
    } else {
        echo "Hata: " . $insert_query . "<br>" . $conn->error;
    }
}

// Verileri güncelle
if (isset($_POST['update_card'])) {
    $id = $_POST['card_id'];
    $title = $_POST['card_title'];
    $description = $_POST['card_description'];
    $image = $_FILES['card_image']['name'];
    $target = "../img/" . basename($image);

    if (!empty($image)) {
        $update_query = "UPDATE home3_cards SET card1_title='$title', card1_text='$description', card1_image='$image' WHERE id=$id";
        move_uploaded_file($_FILES['card_image']['tmp_name'], $target);
    } else {
        $update_query = "UPDATE home3_cards SET card1_title='$title', card1_text='$description' WHERE id=$id";
    }

    if ($conn->query($update_query) === TRUE) {
        echo "Kart başarıyla güncellendi!";
    } else {
        echo "Hata: " . $update_query . "<br>" . $conn->error;
    }
}

// Verileri sil
if (isset($_POST['delete_card'])) {
    $id = $_POST['card_id'];

    $delete_query = "DELETE FROM home3_cards WHERE id=$id";
    if ($conn->query($delete_query) === TRUE) {
        echo "Kart başarıyla silindi!";
    } else {
        echo "Hata: " . $delete_query . "<br>" . $conn->error;
    }
}

// Kartları çek
$cards_query = "SELECT * FROM home3_cards";
$cards_result = $conn->query($cards_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/home.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Home3 Cards</h2>

    <!-- Yeni Kart Ekleme Formu -->
    <h3>Yeni Kart Ekle</h3>
    <form method="post" enctype="multipart/form-data" action="index.php?page=services2">
        <div class="mb-3">
            <label for="card_title" class="form-label">Başlık</label>
            <input type="text" class="form-control" name="card_title" required>
        </div>
        <div class="mb-3">
            <label for="card_description" class="form-label">Açıklama</label>
            <textarea class="form-control" name="card_description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="card_image" class="form-label">Resim</label>
            <input type="file" class="form-control" name="card_image" required>
        </div>
        <button type="submit" name="add_card" class="btn btn-primary">Ekle</button>
    </form>

    <div class="row mt-5">
        <?php while ($card = $cards_result->fetch_assoc()) { ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <?php if (!empty($card['card1_image'])) { ?>
                        <img src="../img/<?php echo $card['card1_image']; ?>" class="card-img-top" alt="<?php echo $card['card1_title']; ?>">
                    <?php } ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $card['card1_title']; ?></h5>
                        <p class="card-text"><?php echo $card['card1_text']; ?></p>
                        <form method="post" class="d-inline" action="index.php?page=services2">
                            <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                            <button type="submit" name="delete_card" class="btn btn-danger">Sil</button>
                        </form>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $card['id']; ?>">Güncelle</button>
                    </div>
                </div>
            </div>

            <!-- Güncelleme Modal -->
            <div class="modal fade" id="updateModal<?php echo $card['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel">Kartı Güncelle</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="index.php?page=services2">
                                <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                <div class="mb-3">
                                    <label for="card_title" class="form-label">Başlık</label>
                                    <input type="text" class="form-control" name="card_title" value="<?php echo $card['card1_title']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="card_description" class="form-label">Açıklama</label>
                                    <textarea class="form-control" name="card_description" required><?php echo $card['card1_text']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="card_image" class="form-label">Resim</label>
                                    <input type="file" class="form-control" name="card_image">
                                </div>
                                <button type="submit" name="update_card" class="btn btn-primary">Güncelle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
