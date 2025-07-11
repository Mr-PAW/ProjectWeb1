<?php
    session_start();
    include 'connection.php';
    $qry = $conn->query("SELECT * FROM content");

    if(!isset($_SESSION['username'])) {
        header("Location:login.php");
    }

    $current_user = $_SESSION['username']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Yogyakarta</title>
    <link href="./CSS/background.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lobster&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  
      <style>
        body{
          background-color: #fbe9d0;
        }
      .masthead {
        height: 100vh;
        min-height: 500px;
        background-image: url('bg_awal.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: Copperplate, Papyrus, fantasy;
      }

      .contentxx {

          transition: background-color 2s, transform 0.3s ease;
      }

      .contentxx:hover{
          box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.25), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          background-color: lightblue;
          transform: scale(1.05);
      }
      .card-img-top {
        width: 100%;
        height: 200px;  /* Or any other height */
        object-fit: cover;  /* This ensures the image covers the space without stretching */
    }
    .fancy-title {
        font-size: 1.2rem;
        font-family: 'Playfair Display', serif;
        font-weight: bold;
        color: #333; /* Dark color for readability */
        letter-spacing: 1px; /* Slight letter spacing for a more spacious feel */
        margin-top: 10px;
    }
    .fancy-link {
        text-decoration: none; /* Remove default underline */
        color: #333; /* Keep the color dark */
        position: relative;
        display: inline-block;
        padding-bottom: 5px;
        transition: color 0.3s ease, transform 0.3s ease;
    }
    .navbar {
        font-family: 'Playfair Display', serif; /* Fancy serif font */
    }

    .navbar-brand {
        font-family: 'Lobster', cursive; /* Cursive font for the brand name */
        font-size: 1.5rem; /* Slightly larger for emphasis */
    }

    .navbar-nav .nav-item {
        font-size: 1.2rem; /* Adjust size for better visibility */
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

<!-- Full Page Image Header with Vertically Centered Content -->
<header class="masthead">
    <div class="masthead-content">
        <h1>Visit Yogyakarta</h1>
        <p>a city rich in tourist destinations</p>
    </div>
    <div class="slider-wrapper">
        <div class="slider">
                <img id="slide-1" src="./images/bg_awal.jpg" alt="trees" />
                <img id="slide-2" src="./images/bapake.jpeg" alt="bapak" />
                <img id="slide-3" src="./images/marlong.jpeg" alt="marlong" />
                <img id="slide-4" src="./images/wayang.jpeg" alt="diddy" />
            </div>
            <div class="slider-nav">
                <a href="#slide-1"></a>
                <a href="#slide-2"></a>
                <a href="#slide-3"></a>
                <a href="#slide-4"></a>
        </div>
    </div>
</header>

<!-- Page Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-3"> <!-- Tambahkan row untuk grid -->
            <?php if ($qry->num_rows > 0) :
                while ($data = $qry->fetch_assoc()) : ?>
                
                <div class="col-md-4">
                      <a href="review.php?name=<?= urlencode($data['name']); ?>" style="text-decoration: none;">
                      <div class="card h-100 contentxx">
                          <img src="images/<?= $data['image']; ?>" class="card-img-top" style="width: 100%;" alt="<?= $data['name']; ?>">
                          <div class="card-body text-center">
                              <h5 class="card-title fancy-title">

                                    <p><?= $data['name']; ?></p>
                                  </h5>
                                </div>
                              </div>
                            </a>
                            </div>
                <?php endwhile;
            endif; ?>
        </div>
    </div>
</section>

<footer class="bg-dark text-white text-center py-3 mt-5">
    ©2024 by 123230067 & 123230216
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.slider img');
        let currentIndex = 0;

        function showNextSlide() {
            // Remove active class from all slides
            slides.forEach(slide => slide.style.transform = "translateX(-100%)");

            // Increment the index (loop back to 0 if at the last slide)
            currentIndex = (currentIndex + 1) % slides.length;

            // Move the slider to show the current slide
            const slider = document.querySelector('.slider');
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Schedule the next slide
      setInterval(sown );
    });
 </script>
    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
</body>
</html>