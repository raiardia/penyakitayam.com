<?php
session_start();
require "config.php"; // pastikan file config.php berisi koneksi database

if(isset($_POST["submit"])){
    // mengambil data dari form
    $username = $_POST["username"];
    $password = $_POST["pass"]; // sesuaikan dengan name dari input password

    // enkripsi password (gunakan password_hash() jika menyimpan password menggunakan PHP >= 5.5)
    $hashed_password = md5($password);

    // cek username dan password dengan prepared statement
    $stmt = $conn->prepare("SELECT username, role FROM tbl_user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // jika login berhasil, membuat session
        $stmt->bind_result($username, $role);
        $stmt->fetch();

        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['status'] = "y";

        header("Location: index.php");
        exit();
    } else {
        // jika login gagal
        header("Location: ?msg=n");
        exit();
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<?php 
if(isset($_GET['msg']) && $_GET['msg'] == "n"){
?>
<div class="alert alert-danger text-center" role="alert">
    <strong>Login Gagal!</strong> Username atau password salah.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php       
}
?>

<div class="container-fluid" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <form method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-primary text-light border-dark text-center">
                        <strong>LOGIN</strong>
                    </div>
                    <div class="card-body border">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="pass" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/jquery-3.7.0.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
