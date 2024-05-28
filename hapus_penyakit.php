<?php

$id_gejala=$_GET['id'];

$sql = "DELETE FROM tbl_data_penyakit WHERE id_penyakit='$id_penyakit'";
if ($conn->query($sql) === TRUE) {
    header("Location:?page=penyakit");
}
$conn->close();
?>