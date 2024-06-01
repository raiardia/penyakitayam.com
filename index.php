<?php
session_start();

// koneksi database
include "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistem Pakar Diagnosa Penyakit Ayam</title>

	<link rel="stylesheet" href="http://localhost/penyakitayam.com/styles.css">

	<!-- bootstrap css -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
	<!-- datatables css -->
	<link rel="stylesheet" href="assets/css/datatables.min.css"> 
	<!-- Font Awesome css -->
	<link rel="stylesheet" href="assets/css/all.css"> 
	<!-- chosen css -->
	<link rel="stylesheet" href="http://localhost/penyakitayam.com/assets/css/bootstrap-chosen.css">

</head>
	
<body>

<!-- navbar -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>

        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "Admin"): ?>
            <!-- Menu untuk Admin -->
            <li class="nav-item">
                <a class="nav-link" href="?page=user">User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=gejala">Gejala</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=penyakit">Penyakit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?page=aturan">Basis Aturan</a>
            </li>
			<li class="nav-item">
                <a class="nav-link" href="?page=konsultasiadmin">Konsultasi</a>
            </li>
        <?php else: ?>
            <!-- Menu untuk Pengguna biasa -->
            <li class="nav-item">
                <a class="nav-link" href="?page=konsultasi">Konsultasi</a>
            </li>
        <?php endif; ?>

        <!-- Menu untuk semua pengguna -->
        <li class="nav-item">
            <a class="nav-link" href="?page=logout">Logout</a>
        </li>
    </ul>
</nav>


<!-- cek status login -->
<?php 
    if($_SESSION['status']!="y"){
        header("Location:login.php");
    }
?>


<!-- container -->
<div class="container">

	<!-- setting menu -->
	<?php

	$page = isset($_GET['page']) ? $_GET['page'] : "";
	$action = isset($_GET['action']) ? $_GET['action'] : "";

	if ($page==""){
		include "greeting.php";
	}elseif ($page=="gejala"){
		if ($action==""){
			include "tampil_gejala.php";
		}elseif ($action=="tambah"){
			include "tambah_gejala.php";
		}elseif ($action=="update"){
			include "update_gejala.php";
		}else{
			include "hapus_gejala.php";
		}
	}elseif ($page=="penyakit"){
		if ($action==""){
			include "tampil_penyakit.php";
		}elseif ($action=="tambah"){
			include "tambah_penyakit.php";
		}elseif ($action=="update"){
			include "update_penyakit.php";
		}else{
			include "hapus_penyakit.php";
		}
	}elseif ($page=="aturan"){
		if ($action==""){
			include "tampil_aturan.php";
		}elseif ($action=="tambah"){
			include "tambah_aturan.php";
		}elseif ($action=="detail"){
			include "detail_aturan.php";
		}elseif ($action=="update"){
			include "update_aturan.php";
		}elseif ($action=="hapus_gejala"){
			include "hapus_detail_aturan.php";
		}else{
			include "hapus_aturan.php";
		}
	}elseif ($page=="konsultasi"){
		if ($action==""){
			include "tampil_konsultasi.php";
		}else{
			include "hasil_konsultasi.php";
		}
	}elseif ($page=="konsultasiadmin"){
		if ($action==""){
			include "tampil_konsultasiadmin.php";
		}else{
			include "hasil_konsultasi.php";
		}
	}elseif ($page=="user"){
		if ($action==""){
			include "tampil_user.php";
		}elseif ($action=="tambah"){
			include "tambah_user.php";
		}elseif ($action=="update"){
			include "update_user.php";
		}else{
			include "hapus_user.php";
		}
	}else{
		include "logout.php";
	}
	?>
</div> 


<script src="http://localhost/penyakitayam.com/assets/js/jquery-3.7.0.min.js"></script>

<script src="http://localhost/penyakitayam.com/assets/js/bootstrap.min.js"></script>

<script src="http://localhost/penyakitayam.com/assets/js/datatables.min.js"></script>
<script>
      $(document).ready(function() {
            $('#myTable').DataTable();
      } );
  </script>

<script src="http://localhost/penyakitayam.com/assets/js/all.js"></script>

<script src="http://localhost/penyakitayam.com/assets/js/chosen.jquery.min.js"></script>
<script>
      $(function() {
        $('.chosen').chosen();
      });
</script>


</body>
</html>