<?php
// mengambil id dari parameter 
$id_aturan=$_GET['id'];

// hapus basis aturan 
$sql = "DELETE FROM tbl_basis_aturan WHERE id_aturanan='$id_aturanan'";
$conn->query($sql);

// hapus detail basis aturan 
$sql = "DELETE FROM tbl_detail_basis_aturan WHERE id_aturanan='$id_aturanan'";
$conn->query($sql);

    header("Location:?page=aturan");
$conn->close();
?>