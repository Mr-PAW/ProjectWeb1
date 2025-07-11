<?php
session_start();
include 'connection.php';

// Cek apakah parameter 'name' ada
if (isset($_GET['name'])) {
    $name = urldecode($_GET['name']); // Decode nama dari URL
    $stmt = $conn->prepare("SELECT * FROM content WHERE name = ?");
    $stmt->bind_param("s", $name); // Bind parameter untuk query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Konten tidak ditemukan.";
        exit;
    }
} else {
    echo "Parameter tidak valid.";
    exit;
}

$stmt = $conn->prepare("
    SELECT review.Rid, user.username, review.rev 
    FROM review
    JOIN user ON review.Uid = user.Uid
    JOIN content ON review.Cid = content.Cid
    WHERE content.name = ?
");
$stmt->bind_param("s", $name); // Parameter lokasi
$stmt->execute();
$reviews = $stmt->get_result();
$current_user = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review - <?= htmlspecialchars($data['name']); ?></title>
    <link href="./CSS/review.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lobster&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-color: #fbe9d0;
        }
        .navbar {
            font-family: 'Playfair Display', serif;
        }

        .navbar-brand {
            font-family: 'Lobster', cursive;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-item {
            font-size: 1.2rem;
            font-family: 'Playfair Display', serif;
        }

        button {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
        }
        .text-justify {
            text-align: justify;
        }


    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow fixed-top">
  <div class="container">
  <a class="navbar-brand" href="#">
  <img src="./images/logo.png" alt="" height="42px" width="42px"> </a>
    <a class="navbar-brand" href="index.php">Hello <?= $current_user ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
        <li class="nav-item active">
        <?php if (isset($_GET['added'])) : ?>
            <p class="text-warning text-center mt-3">
                Succesfully added new destination!
            </p>
        <?php endif; ?>
        <?php if (isset($_GET['writed'])) : ?>
            <p class="text-success text-center mt-3">
                Succesfully reviewed!
            </p>
        <?php endif; ?>
        </li>
        <?php if ($current_user === "Admin") : ?>
        <li class="nav-item active">
        <a href="add.php">
        <button type="button" class="m-2 btn btn-outline-primary">Add</button>
        </a>
        </li>
        <li class="nav-item active">
        <a href="manage.php">
        <button type="button" class="m-2 btn btn-outline-primary">Manage Data</button>
        </a>
        </li>
        <?php endif; ?>
        <li>
        <a href="process.php?logout=true">
        <button type="button" class="m-2 btn btn-outline-danger">Logout</button>
        </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

        <div class="container py-5 mt-5">
            <div class="masthead" style="background-image: url('images/<?= htmlspecialchars($data['image']); ?>');">
                <div class="card-body text-center">
                    <h5 class="card-title text-white"><?= htmlspecialchars($data['name']); ?></h5>
                </div>
            </div>
        </div>


    </div>
    <div class="container py-4">
    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title text-light-gray text-center">Description of This Place</h5>
            <p class="card-text lead text-muted text-justify"><?= htmlspecialchars($data['description']); ?></p>
        </div>
    </div>
</div>


    <div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h2 class="mb-4">User Reviews </h2>
            <?php if ($reviews->num_rows > 0): ?>
                <?php while ($review = $reviews->fetch_assoc()): ?>
                    <div class="card mb-3 shadow">
                        <div class="card-header bg-dark text-white">
                            <?= htmlspecialchars($review['username']); ?>
                        </div>
                        <div class="card-body">
                            <p class="mb-0"><?= nl2br(htmlspecialchars($review['rev'])); ?></p>
                        </div>
                        <?php if ($review['username'] === $current_user): ?>
                            <a href="process.php?delete_review=<?= $review['Rid']; ?>&name=<?= urlencode($data['name']); ?>" 
                            class="btn btn-sm btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                        <?php elseif ("Admin" === $current_user): ?>
                            <a href="process.php?delete_review=<?= $review['Rid']; ?>&name=<?= urlencode($data['name']); ?>" 
                            class="btn btn-sm btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No reviews yet. Be the first to write a review!</p>
            <?php endif; ?>
            <a href="write.php?name=<?= urlencode($data['name']); ?>">
            <button type="button" class="m-2 btn btn-outline-dark">Add review</button>
            </a>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
    ©2024 by 123230067 & 123230216
    </footer>
</body>
</html>
