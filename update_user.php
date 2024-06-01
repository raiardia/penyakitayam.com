<?php 
// Assuming $conn is your MySQLi connection object
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize and validate the id_user parameter
$id_user = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_user > 0) {
    if (isset($_POST['update'])) {
        $role = $_POST['role'];

        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE tbl_user SET role=? WHERE id_user=?");
        $stmt->bind_param("si", $role, $id_user);
        
        if ($stmt->execute()) {
            header("Location: ?page=user");
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $stmt->close();
    }

    // Fetch user data using a prepared statement
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE id_user=?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No user found with id: " . htmlspecialchars($id_user);
        exit;
    }

    $stmt->close();
} else {
    echo "Invalid user ID.";
    exit;
}
?>

<div class="row">
    <div class="col-sm-12">
        <form action="" method="POST">
            <div class="card border-dark">
                <div class="card">
                    <div class="card-header bg-primary text-white border-dark"><strong>Update Data User</strong></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" value="" readonly>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control chosen" data-placeholder="Pilih Role" name="role" required>
                                <?php
                                $available_roles = ['Admin', 'Pasien']; // Roles yang tersedia
                                foreach ($available_roles as $role) {
                                    $selected = ($role == $row['role']) ? 'selected' : ''; // Memeriksa apakah role saat ini terpilih
                                    echo "<option value=\"$role\" $selected>$role</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <input class="btn btn-primary" type="submit" name="update" value="Update">
                        <a class="btn btn-danger" href="?page=user">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> 
