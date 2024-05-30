<?php
// Including the database configuration file
include "config.php";

// Getting id from the URL parameter
$id_aturan = $_GET['id'];

// Query to fetch disease data based on the selected rule
$sql = "SELECT tbl_basis_aturan.id_aturan, tbl_basis_aturan.id_penyakit, tbl_data_penyakit.nm_penyakit
        FROM tbl_basis_aturan
        INNER JOIN tbl_data_penyakit
        ON tbl_basis_aturan.id_penyakit = tbl_data_penyakit.id_penyakit
        WHERE tbl_basis_aturan.id_aturan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_aturan);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Process update
if (isset($_POST['update'])) {
    $id_gejala = $_POST['id_gejala'] ?? []; // Default to empty array if not set

    // First, delete all gejala related to this id_aturan
    $stmt_delete = $conn->prepare("DELETE FROM tbl_detail_basis_aturan WHERE id_aturan = ?");
    $stmt_delete->bind_param("i", $id_aturan);
    $stmt_delete->execute();

    // Then, insert the new gejala if there are any
    if (!empty($id_gejala)) {
        $stmt_insert = $conn->prepare("INSERT INTO tbl_detail_basis_aturan (id_aturan, id_gejala) VALUES (?, ?)");
        foreach ($id_gejala as $gejala) {
            $stmt_insert->bind_param("ii", $id_aturan, $gejala);
            $stmt_insert->execute();
        }
    }

    // Redirect to the aturan page
    header("Location:?page=aturan");
    exit;
}
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card">
                    <div class="card-header bg-primary text-white border-dark"><strong>Update Data Basis Aturan</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nm_penyakit">Nama Penyakit</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['nm_penyakit']); ?>" name="nm_penyakit" readonly>
                        </div>

                        <!-- Tabel data gejala-gejala -->
                        <div class="form-group">
                            <label for="">Pilih gejala-gejala berikut :</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30px"></th>
                                        <th width="30px">No.</th>
                                        <th width="700px">Nama Gejala</th>
                                        <th width="30px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $sql = "SELECT * FROM tbl_data_gejala ORDER BY nm_gejala ASC";
                                    $result = $conn->query($sql);
                                    while ($row_gejala = $result->fetch_assoc()) {
                                        $id_gejala = $row_gejala['id_gejala'];

                                        // Check the detail rule table
                                        $sql_check = "SELECT * FROM tbl_detail_basis_aturan WHERE id_aturan = ? AND id_gejala = ?";
                                        $stmt_check = $conn->prepare($sql_check);
                                        $stmt_check->bind_param("ii", $id_aturan, $id_gejala);
                                        $stmt_check->execute();
                                        $result_check = $stmt_check->get_result();
                                        $checked = $result_check->num_rows > 0 ? "checked" : "";
                                    ?>
                                    <tr>
                                        <td align="center"><input type="checkbox" class="check-item" name="id_gejala[]" value="<?php echo $id_gejala; ?>" <?php echo $checked; ?>></td>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($row_gejala['nm_gejala']); ?></td>
                                        <td>
                                            <?php if ($checked): ?>
                                                <a onclick="return confirm('Yakin menghapus data ini ?')" class="btn btn-danger" href="?page=aturan&action=hapus_gejala&id_aturan=<?php echo $id_aturan ?>&id_gejala=<?php echo $id_gejala ?>">
                                                    <i class="fas fa-window-close"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <input class="btn btn-primary" type="submit" name="update" value="Update">
                        <a class="btn btn-danger" href="?page=aturan">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
