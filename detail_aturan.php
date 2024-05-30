<!-- proses menampilkan data basis aturan -->
<?php 

// mengambil id dari parameter
$id_aturan = $_GET['id'];

// Query for getting the disease information
$sql = "SELECT tbl_basis_aturan.id_aturan, 
               tbl_basis_aturan.id_penyakit, 
               tbl_data_penyakit.nm_penyakit, 
               tbl_data_penyakit.definsi 
        FROM tbl_basis_aturan 
        INNER JOIN tbl_data_penyakit 
            ON tbl_basis_aturan.id_penyakit = tbl_data_penyakit.id_penyakit 
        WHERE tbl_basis_aturan.id_aturan = '$id_aturan'";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
} else {
    echo "Error: " . $conn->error;
    exit;
}
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card">
                    <div class="card-header bg-primary text-white border-dark"><strong>Detail Halaman Basis Aturan</strong></div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="">Nama Penyakit</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['nm_penyakit']); ?>" name="nama" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Definisi</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['definsi']); ?>" name="definsi" readonly>
                        </div>

                        <!-- tabel gejala-gejala -->
                        <label for="">Gejala-Gejala Penyakit :</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="40px">No.</th>
                                    <th width="700px">Nama Gejala</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = "SELECT tbl_detail_basis_aturan.id_aturan, 
                                               tbl_detail_basis_aturan.id_gejala, 
                                               tbl_data_gejala.nm_gejala 
                                        FROM tbl_detail_basis_aturan
                                        INNER JOIN tbl_data_gejala 
                                        ON tbl_detail_basis_aturan.id_gejala = tbl_data_gejala.id_gejala 
                                        WHERE tbl_detail_basis_aturan.id_aturan = '$id_aturan'";
                                $result = $conn->query($sql);
                                if ($result) {
                                    while($row = $result->fetch_assoc()) { 
                                ?>    
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nm_gejala']); ?></td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo "Error: " . $conn->error;
                                }
                                $conn->close();
                                ?>    
                            </tbody>
                        </table>

                        <a class="btn btn-danger" href="?page=aturan">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
