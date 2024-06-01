<?php 
date_default_timezone_set("Asia/Jakarta");
include "config.php";

// Mengambil id dari parameter
$id_konsultasi = $_GET['id'];

// Query untuk mendapatkan informasi konsultasi
$sql = "SELECT * FROM tbl_konsultasi WHERE id_konsultasi='$id_konsultasi'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
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
                    <div class="card-header bg-primary text-white border-dark"><strong>Hasil Konsultasi</strong></div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="">Nama Pasien</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['nama']); ?>" name="nama" readonly>
                        </div>

                        <!-- Tabel gejala-gejala -->
                        <label for="">Gejala-Gejala Penyakit Yang Dipilih:</label>
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
                                $sql = "SELECT tbl_detail_konsultasi.id_konsultasi, tbl_detail_konsultasi.id_gejala, tbl_data_gejala.nm_gejala
                                        FROM tbl_detail_konsultasi
                                        INNER JOIN tbl_data_gejala 
                                        ON tbl_detail_konsultasi.id_gejala = tbl_data_gejala.id_gejala 
                                        WHERE id_konsultasi = '$id_konsultasi'";
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
                                ?>    
                            </tbody>
                        </table>

                        <!-- Hasil konsultasi penyakitnya -->
                        <label for="">Hasil Konsultasi Penyakit:</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="40px">No.</th>
                                    <th width="200px">Nama Penyakit</th>
                                    <th width="100px">Peluang</th>
                                    <th width="700px">Solusi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = "SELECT tbl_detail_penyakit.id_konsultasi, tbl_detail_penyakit.id_penyakit, tbl_data_penyakit.nm_penyakit, tbl_data_penyakit.solusi, tbl_detail_penyakit.peluang
                                        FROM tbl_detail_penyakit
                                        INNER JOIN tbl_data_penyakit
                                        ON tbl_detail_penyakit.id_penyakit = tbl_data_penyakit.id_penyakit
                                        WHERE tbl_detail_penyakit.id_konsultasi = '$id_konsultasi'
                                        ORDER BY peluang DESC";
                                $result = $conn->query($sql);
                                if ($result) {
                                    while($row = $result->fetch_assoc()) { 
                                ?>    
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nm_penyakit']); ?></td>
                                    <td><?php echo htmlspecialchars($row['peluang']); ?>%</td>
                                    <td><?php echo htmlspecialchars($row['solusi']); ?></td>
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
                        <a class="btn btn-danger" href="?page=konsultasiadmin">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
