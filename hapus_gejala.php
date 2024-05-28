<?php

$id_gejala=$_GET['id'];

$sql = "DELETE FROM tbl_data_gejala WHERE id_gejala='$id_gejala'";
if ($conn->query($sql) === TRUE) {
    header("Location:?page=gejala");
}
$conn->close();
?>