<?php
require "config.php";

$id = $_GET["kode_reservasi"];
$query = "DELETE FROM data_reservasi WHERE kode_reservasi = '$id'";
mysqli_query($conn, $query);

echo    "<script>
	        alert('Data Berhasil Dihapus');
	        document.location.href = 'index.php';
        </script>";

// header("Location: index.php");

?>