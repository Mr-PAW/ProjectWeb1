<?php
include 'connection.php';
session_start();
$current_user = $_SESSION['username'];
// Ensure the user is logged in
if ($current_user !== "Admin") {
    header("Location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
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

<center>
<h6 class="mt-5">s</h6>
    <h1 class="mt-5">Add menu </h1>
        <form action="process.php" method="post" class="mt-5 w-50" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Location Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Location description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">image</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png" required>
            </div>
            <button type="submit" class="btn btn-success" name="submitInsert">
                Submit
            </button>
        </form>

    </center> 

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>