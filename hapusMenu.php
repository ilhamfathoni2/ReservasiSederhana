<?php
require "config.php";

$id = $_GET["id_menu"];
$query = "DELETE FROM data_menu WHERE id_menu = '$id'";
mysqli_query($conn, $query);

echo    "<script>
	        alert('Data Berhasil Dihapus');
	        document.location.href = 'tambahMenu.php';
        </script>";

// header("Location: index.php");

?>