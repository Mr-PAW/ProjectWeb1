<?php
include 'connection.php';
session_start();
$current_user = $_SESSION['username'];
// Ensure the user is logged in
if ($current_user !== "Admin") {
    header("Location:index.php");
    exit;
}

// Check if `Cid` is provided
if (isset($_GET['Cid'])) {
    $Cid = intval($_GET['Cid']);

    // Fetch the content
    $stmt = $conn->prepare("SELECT * FROM content WHERE Cid = ?");
    $stmt->bind_param("i", $Cid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $content = $result->fetch_assoc();
    } else {
        die("Content not found.");
    }
} else {
    die("Invalid request.");
}


// Update content
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Update name
    $stmt = $conn->prepare("UPDATE content SET name = ? WHERE Cid = ?");
    $stmt->bind_param("si", $name, $Cid);
    $stmt->execute();

    // Update description
    $stmt = $conn->prepare("UPDATE content SET description = ? WHERE Cid = ?");
    $stmt->bind_param("si", $description, $Cid);
    $stmt->execute();

    // Update image if uploaded
    if ($image['name'] !== '') {
        $newImageName = time() . "_" . basename($image['name']);
        $targetPath = "images/" . $newImageName;

        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            // Delete the old image
            $oldImagePath = "images/" . $content['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Update the database
            $stmt = $conn->prepare("UPDATE content SET image = ? WHERE Cid = ?");
            $stmt->bind_param("si", $newImageName, $Cid);
            $stmt->execute();
        }
    }

    header("Location:index.php?updated=true");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lobster&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <h1 class="mb-4">Edit Content</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($content['name']); ?>" required>
        </div>
            <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4" required><?= htmlspecialchars($content['description']); ?></textarea>
            </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <div>
                <img src="images/<?= htmlspecialchars($content['image']); ?>" alt="<?= htmlspecialchars($content['name']); ?>" class="img-thumbnail mb-3" width="150">
            </div>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    ©2024 by 123230067 & 123230216
</footer>
</body>
</html>
