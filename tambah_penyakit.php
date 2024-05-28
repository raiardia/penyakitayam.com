<?php

if(isset($_POST['simpan'])){

    // mengambil data dari form
    $nm_penyakit=$_POST['nm_penyakit'];
    $nm_latin=$_POST['nm_latin'];
    $definsi=$_POST['definsi'];
    $solusi=$_POST['solusi'];
	
	//proses simpan
        $sql = "INSERT INTO tbl_data_penyakit VALUES ('Null','$nm_penyakit','$nm_latin','$definsi','$solusi')";
        if ($conn->query($sql) === TRUE) {
            header("Location:?page=penyakit");
        }    
}
?>


<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card">
                <div class="card-header bg-primary text-white border-dark"><strong>Tambah Data Penyakit</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Nama Penyakit</label>
                        <input type="text" class="form-control" name="nm_penyakit" maxlength="100" required>
                    </div>
                     <div class="form-group">
                        <label for="">Nama Latin</label>
                        <input type="text" class="form-control" name="nm_latin" maxlength="255" required>
                    </div>
                     <div class="form-group">
                        <label for="">Definsi</label>
                        <input type="text" class="form-control" name="definsi" maxlength="255" required>
                    </div>
                     <div class="form-group">
                        <label for="">Solusi</label>
                        <input type="text" class="form-control" name="solusi" maxlength="255" required>
                    </div>

                <input class="btn btn-primary" type="submit" name="simpan" value="Simpan">
                <a class="btn btn-danger" href="?page=penyakit">Batal</a>

                </div>
            </div>
        </form>
    </div>
</div>