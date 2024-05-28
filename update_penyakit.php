<?php 

// mengambil id dari parameter
$id_penyakit=$_GET['id'];

if(isset($_POST['update'])){
    $nm_penyakit=$_POST['nm_penyakit'];
    $nm_latin=$_POST['nm_latin'];
    $definsi=$_POST['definsi'];
    $solusi=$_POST['solusi'];

    // proses update
    $sql = "UPDATE tbl_data_penyakit SET nm_penyakit='$nm_penyakit',nm_latin='$nm_latin',definsi='$definsi',solusi='$solusi' WHERE id_penyakit='$id_penyakit'";
    if ($conn->query($sql) === TRUE) {
        header("Location:?page=penyakit");
    }
}


$sql = "SELECT * FROM tbl_data_penyakit WHERE id_penyakit='$id_penyakit'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card">
                <div class="card-header bg-primary text-white border-dark"><strong>Update Data Penyakit</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Nama Penyakit</label>
                        <input type="text" class="form-control" name="nm_penyakit" value="<?php echo $row['nm_penyakit'] ?> "maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="">Nama Latin</label>
                        <input type="text" class="form-control" name="nm_latin" value="<?php echo $row['nm_latin'] ?> "maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="">Definsi</label>
                        <input type="text" class="form-control" name="definsi" value="<?php echo $row['definsi'] ?> "maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="">Solusi</label>
                        <input type="text" class="form-control" name="solusi" value="<?php echo $row['solusi'] ?> "maxlength="255" required>
                    </div>

                    <input class="btn btn-primary" type="submit" name="update" value="Update">
                    <a class="btn btn-danger" href="?page=penyakit">Batal</a>

                </div>
            </div>
        </form>
    </div>
</div> 
