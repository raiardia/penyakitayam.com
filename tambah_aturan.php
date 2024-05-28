<?php
if (isset($_POST['simpan'])) {
    // Include database connection
    include "config.php";
    
    // Get data from form
    $nm_penyakit = $_POST['nm_penyakit'];
    $id_gejala = $_POST['id_gejala'];

    // Validate disease name
    $stmt = $conn->prepare("SELECT tbl_basis_aturan.id_aturan, tbl_basis_aturan.id_penyakit, tbl_data_penyakit.nm_penyakit 
                            FROM tbl_basis_aturan 
                            INNER JOIN tbl_data_penyakit 
                            ON tbl_basis_aturan.id_penyakit = tbl_data_penyakit.id_penyakit 
                            WHERE tbl_data_penyakit.nm_penyakit = ?");
    $stmt->bind_param("s", $nm_penyakit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Data penyakit aturan tersebut sudah ada</strong>
              </div>';
    } else {
        // Retrieve disease data
        $stmt = $conn->prepare("SELECT * FROM tbl_data_penyakit WHERE nm_penyakit = ?");
        $stmt->bind_param("s", $nm_penyakit);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id_penyakit = $row['id_penyakit'];

        // Save basis rule
        $stmt = $conn->prepare("INSERT INTO tbl_basis_aturan (id_aturan, id_penyakit) VALUES (NULL, ?)");
        $stmt->bind_param("i", $id_penyakit);
        $stmt->execute();

        // Retrieve the last inserted id_aturan
        $id_aturan = $conn->insert_id;

        // Save rule details
        $stmt = $conn->prepare("INSERT INTO tbl_detail_basis_aturan (id_aturan, id_gejala) VALUES (?, ?)");
        foreach ($id_gejala as $gejala) {
            $stmt->bind_param("ii", $id_aturan, $gejala);
            $stmt->execute();
        }

        header("Location:?page=aturan");
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST" name="Form" onsubmit="return validasiForm()">
            <div class="card border-dark">
                <div class="card">
                    <div class="card-header bg-primary text-white border-dark"><strong>Tambah Data Basis Aturan</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nm_penyakit">Nama Penyakit</label>
                            <select class="form-control chosen" data-placeholder="Pilih Nama Penyakit" name="nm_penyakit">
                                <option value=""></option>
                                <?php
                                include "config.php";
                                $sql = "SELECT * FROM tbl_data_penyakit ORDER BY nm_penyakit ASC";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['nm_penyakit'] . '">' . $row['nm_penyakit'] . '</option>';
                                }
                                $conn->close();
                                ?>
                            </select>
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

                        <input class="btn btn-primary" type="submit" name="simpan" value="Simpan">
                        <a class="btn btn-danger" href="?page=aturan">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function validasiForm() {
        // Validasi nama penyakit 
        var nm_penyakit = document.forms["Form"]["nm_penyakit"].value;

        if (nm_penyakit == "") {
            alert("Pilih nama penyakit");
            return false;
        }

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