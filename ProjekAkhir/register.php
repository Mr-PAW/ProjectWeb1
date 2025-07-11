
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./CSS/loginreg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<style>
        .gradient-custom {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('./images/manguna.jpeg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-1 text-center">
                    <img src="./images/logo.png" alt="Logo" class="logo mb-4">
                        <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                        <p class="text-white-50 mb-4">Enter new username and password</p>
                        
                        <?php if (isset($_GET['register']) && $_GET['register'] == "false") : ?>
                            <p class="text-danger">Username already taken</p>
                        <?php endif; ?>
                        
                        <form action="process.php" method="post">
                            <div class="form-outline form-white mb-3">
                                <input type="text" id="username" name="username" class="form-control form-control-lg" required />
                                <label class="form-label" for="username">Username</label>
                            </div>
                            <div class="form-outline form-white mb-3">
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <button class="btn btn-outline-light btn-lg px-5" type="submit" name="register">Register</button>
                        </form>
                        
                        <p>Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
                    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
</body>
</html>