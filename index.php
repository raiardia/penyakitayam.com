<?php
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
    <li class="nav-item active">
      <a class="nav-link" href="index.php">Home</a>
    </li>
	<li class="nav-item active">
      <a class="nav-link" href="?page=user">User</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="?page=gejala">Gejala</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="?page=penyakit">Penyakit</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="?page=aturan">Basis Aturan</a>
    </li>
	<li class="nav-item active">
      <a class="nav-link" href="?page=konsultasi">Konsultasi</a>
    </li>
	<li class="nav-item active">
      <a class="nav-link disabled" href="#">Logout</a>
    </li>
  </ul>
</nav>

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
	}elseif ($page=="user"){
		if ($action==""){
			include "tampil_user.php";
		}elseif ($action=="tambah"){
			include "tambah_penyakit.php";
		}elseif ($action=="update"){
			include "update_penyakit.php";
		}else{
			include "hapus_penyakit.php";
		}
	}else{
		include "NAMA_HALAMAN";
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