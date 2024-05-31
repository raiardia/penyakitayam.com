<?php 
date_default_timezone_set("Asia/Jakarta");
include "config.php";

if(isset($_POST['proses'])){

    // mengambil data dari form
    $nm_pasien = $conn->real_escape_string($_POST['nm_pasien']);
    $tgl = date("Y/m/d");

    // prose simpan konsultasi 
    $sql = "INSERT INTO tbl_konsultasi (tanggal, nama) VALUES ('$tgl', '$nm_pasien')";
    if (!mysqli_query($conn, $sql)) {
        die('Error: ' . mysqli_error($conn));
    }

    // mengambil idgejala
    $id_gejala = $_POST['id_gejala'];

    // proses mengambil data konsultasi 
    $sql = "SELECT id_konsultasi FROM tbl_konsultasi ORDER BY id_konsultasi DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_konsultasi = $row['id_konsultasi'];
    } else {
        die('Error: Unable to retrieve consultation ID');
    }

    // proses simpan detail konsultasi 
    foreach ($id_gejala as $gejala) {
        $gejala = $conn->real_escape_string($gejala);
        $sql = "INSERT INTO tbl_detail_konsultasi (id_konsultasi, id_gejala) VALUES ('$id_konsultasi', '$gejala')";
        if (!mysqli_query($conn, $sql)) {
            die('Error: ' . mysqli_error($conn));
        }
    }

    //mengambil data dari tabel penyakit untuk dicek di basis aturan 
    $sql = "SELECT * FROM tbl_data_penyakit";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $id_penyakit = $row['id_penyakit'];
        $jyes = 0;

        // mencari jumlah gejala di basis aturan berdasarkan penyakit
        $sql2 = "SELECT COUNT(id_gejala) AS jml_gejala 
                 FROM tbl_basis_aturan INNER JOIN tbl_detail_basis_aturan
                 ON tbl_basis_aturan.id_aturan = tbl_detail_basis_aturan.id_aturan
                 WHERE id_penyakit = '$id_penyakit'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();
        $jml_gejala = $row2['jml_gejala'];

        // mencari gejala pada basis aturan
        $sql3 = "SELECT id_gejala
                 FROM tbl_basis_aturan INNER JOIN tbl_detail_basis_aturan
                 ON tbl_basis_aturan.id_aturan = tbl_detail_basis_aturan.id_aturan
                 WHERE id_penyakit = '$id_penyakit'";
        $result3 = $conn->query($sql3);
        while ($row3 = $result3->fetch_assoc()) {
            $id_gejalane = $row3['id_gejala'];

            // membandingkan apakah yang dipilih pada konsultasi sesuai 
            $sql4 = "SELECT id_gejala FROM tbl_detail_konsultasi
                     WHERE id_konsultasi = '$id_konsultasi' AND id_gejala = '$id_gejalane'";
            $result4 = $conn->query($sql4);
            if ($result4->num_rows > 0) {
                $jyes++;
            }
        }

        // mencari persentase 
        if ($jml_gejala > 0) {
            $peluang = round(($jyes / $jml_gejala) * 100);
        } else {
            $peluang = 0;
        }

        // simpan data detail penyakit
        if ($peluang > 0) {
            $sql = "INSERT INTO tbl_detail_penyakit (id_konsultasi, id_penyakit) VALUES ('$id_konsultasi', '$id_penyakit')";
            if (!mysqli_query($conn, $sql)) {
                die('Error: ' . mysqli_error($conn));
            }
        }
    }

    // Redirect to results page
    //header("Location:?page=konsultasi&action=hasil&id_konsultasi=$id_konsultasi");
    //exit;
}

?>



<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST" name="Form" onsubmit="return validasiForm()">
            <div class="card border-dark">
                <div class="card">
                    <div class="card-header bg-primary text-white border-dark"><strong>Konsultasi Penyakit</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nm_penyakit">Nama Pasien</label>
                            <input type="text" class="form-control" name="nm_pasien" maxlength="255" required>
                        </div>

                        <!-- Gejala Data Table -->
                        <div class="form-group">
                            <label for="">Pilih gejala-gejala berikut :</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30px"></th>
                                        <th width="30px">No.</th>
                                        <th width="700px">Nama Gejala</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "config.php";
                                    $no = 1;
                                    $sql = "SELECT * FROM tbl_data_gejala ORDER BY nm_gejala ASC";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>
                                                <td align="center"><input type="checkbox" class="check-item" name="id_gejala[]" value="' . $row['id_gejala'] . '"></td>
                                                <td>' . $no++ . '</td>
                                                <td>' . $row['nm_gejala'] . '</td>
                                              </tr>';
                                    }
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <input class="btn btn-primary" type="submit" name="proses" value="Proses">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function validasiForm() {
    

        // Validasi gejala yang belum dipilih 
        var checkbox = document.getElementsByName('id_gejala[]');

        var isChecked = false;

        for (var i = 0; i < checkbox.length; i++) {
            if (checkbox[i].checked) {
                isChecked = true;
                break;
            }
        }

        // Jika belum ada yang dicheck
        if (!isChecked) {
            alert('Pilih setidaknya satu gejala');
            return false;
        }

        return true;
    }
</script>