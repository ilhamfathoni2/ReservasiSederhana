<?php
require "config.php";

$id = $_GET["id_transaksi"];
$kodeReservasi = $_GET["kode_reservasi"];
$query = "DELETE FROM transaksi WHERE id_transaksi = '$id'";
mysqli_query($conn, $query);

echo    "<script>
	        alert('Data Berhasil Dihapus');
	        document.location.href = 'transaksi.php?kode_reservasi=$kodeReservasi';
        </script>";

// header("Location: index.php");

?>