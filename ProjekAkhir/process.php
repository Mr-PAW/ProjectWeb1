<?php 
include "connection.php";

session_start(); 

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gunakan prepared statements untuk mencegah SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User ditemukan
        $user = $result->fetch_assoc();

        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['Uid'] = $user['Uid']; // Simpan Uid untuk referensi review

            header("Location: index.php");

    } else {
        // Jika login gagal
        header("Location: login.php?login=false");
    }
}

// Pastikan session dimulai di awal

if (isset($_POST['submitReview'])) {
    include 'connection.php';

    $Cid = $_POST['Cid']; // ID konten
    $description = $_POST['description']; // Review dari user
    $Uid = $_SESSION['Uid']; // Ambil Uid dari session (pengguna yang login)

    // Pastikan Uid ada
    if (empty($Uid)) {
        echo "User tidak terdeteksi. Harap login terlebih dahulu.";
        exit;
    }

    // Query untuk menyimpan review baru
    $stmt = $conn->prepare("INSERT INTO review (Cid, Uid, rev) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $Cid, $Uid, $description);

    if ($stmt->execute()) {
        echo "Review berhasil ditambahkan!";
        header("Location:index.php?writed");
        exit;
    } else {
        echo "Gagal menambahkan review: " . $conn->error;
    }
}

    if(isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        

        $f = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
        
        if (mysqli_num_rows($f) > 0) {
            header("Location:register.php?register=false");
            return;
        } 
        else {
            // Jika username belum ada, lakukan insert
            $query = mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password')");
            header("Location:login.php?registered");
        }
        
    }

    if(isset($_GET['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php?logout=true");
    }

    if (isset($_POST["submitInsert"])) {
        // Pastikan koneksi ke database sudah dibuat
        include 'connection.php'; // File koneksi ke database
    
        $name = $_POST['name'];
        $description = $_POST['description'];
    
        // Mendapatkan informasi file yang diunggah
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
    
        // Membuat nama file baru yang unik
        $newName = uniqid() . '_' . $image;
    
        // Menyusun lokasi penyimpanan file
        $location = 'images/' . $newName;
    
        // Memindahkan file ke folder tujuan
        if (move_uploaded_file($tmp, $location)) {
            // Query untuk menyimpan data ke database
            $query = "INSERT INTO content (Cid, name, description, image) VALUES ('', '$name', '$description', '$newName')";
    
            // Menjalankan query
            if (mysqli_query($conn, $query)) {
                header("Location:index.php?added");
            } else {
                echo "Gagal menyimpan data: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal mengunggah file.";
        }
    }

    if (isset($_GET['delete_review'])) {
        session_start();
        $review_id = $_GET['delete_review'];
        $name = urldecode($_GET['name']);
        $username = $_SESSION['username'] ?? '';
    
        // Cek apakah yang login adalah admin atau pemilik review
        if ($username == 'Admin') {
            // Jika admin, hapus review tanpa memeriksa username pemiliknya
            $stmt = $conn->prepare("DELETE FROM review WHERE Rid = ?");
            $stmt->bind_param("i", $review_id);
        } else {
            // Jika bukan admin, hanya hapus review jika username cocok dengan pemiliknya
            $stmt = $conn->prepare("
                DELETE FROM review 
                WHERE Rid = ? 
                AND Uid = (SELECT Uid FROM user WHERE username = ?)
            ");
            $stmt->bind_param("is", $review_id, $username);
        }
    
        // Eksekusi query
        if ($stmt->execute()) {
            header("Location: review.php?name=" . urlencode($name));
            exit;
        } else {
            echo "Failed to delete review.";
        }
    }
    
    
    
    
    if(isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    
        // Check if username already exists
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if(mysqli_num_rows($query) > 0) {
            header("Location: register.php?error=username_taken");
        } else {
            // Insert new user into the database
            $query = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
            if($query) {
                header("Location: login.php?register=success");
            } else {
                header("Location: register.php?error=registration_failed");
            }
        }
    }

    if(isset($_GET['Cid'])){
        $Cid = $_GET['Cid'];
        $query = mysqli_query($conn, "DELETE FROM content WHERE Cid='$Cid'");
        if($query){
            header("Location: manage.php?delete=true");
        }
    }

    ?>