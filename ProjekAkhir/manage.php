<?php
    session_start();
    include 'connection.php';
    $qry = $conn->query("SELECT * FROM content");

    $current_user = $_SESSION['username'];


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
    <title>Manage Data Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lobster&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body{
            background-color: #fbe9d0;
        }
        .img-thumbnail {
        width: 100px;
        height: 50px;  /* Or any other height */
        object-fit: cover;  /* This ensures the image covers the space without stretching */
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
    <h1 class="mb-4">Manage Content</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $query = mysqli_query($conn, "SELECT * FROM content");
            while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Cid']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td>
                        <img src="images/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" class="img-thumbnail";>
                    </td>
                    <td>
                        <a href="edit.php?Cid=<?= $row['Cid']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="process.php?Cid=<?= $row['Cid']; ?>" class="btn btn-sm btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this content?')">Delete</a>
                        <a href="review.php?name=<?= urlencode($row['name']); ?>" class="btn btn-success btn-sm">Review</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>



<footer class="bg-dark text-white text-center py-3 mt-5">
    ©2024 by 123230067 & 123230216
</footer>

    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
</body>
</html>