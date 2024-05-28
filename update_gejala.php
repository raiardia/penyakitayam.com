<?php 

// mengambil id dari parameter
$id_gejala=$_GET['id'];

if(isset($_POST['update'])){
    $nm_gejala=$_POST['nm_gejala'];

    // proses update
    $sql = "UPDATE tbl_data_gejala SET nm_gejala='$nm_gejala' WHERE id_gejala='$id_gejala'";
    if ($conn->query($sql) === TRUE) {
        header("Location:?page=gejala");
    }
}


$sql = "SELECT * FROM tbl_data_gejala WHERE id_gejala='$id_gejala'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card">
                <div class="card-header bg-primary text-white border-dark"><strong>Update Data Gejala</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Nama Gejala</label>
                        <input type="text" class="form-control" name="nm_gejala" value="<?php echo $row['nm_gejala'] ?> "maxlength="255" required>
                    </div>

                <input class="btn btn-primary" type="submit" name="update" value="Update">
                <a class="btn btn-danger" href="?page=gejala">Batal</a>

                </div>
            </div>
        </form>
    </div>
</div>