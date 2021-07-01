<?php
    require "config.php";
    require "function.php";

    // ambil data reservasi
    $queryAmbilDataReservasi = "SELECT * FROM data_reservasi";
    $objectAmbilDataReservasi = mysqli_query($conn, $queryAmbilDataReservasi);
    $reservasis = [];
    while( $reservasi = mysqli_fetch_assoc($objectAmbilDataReservasi) ) {
        $reservasis[] = $reservasi;
    }

    // ambil tanggal distinct
    $queryAmbilTanggalDistinct = "SELECT DISTINCT tanggal_daftar FROM data_reservasi";
    $objekAmbilTanggalDistinct = mysqli_query($conn, $queryAmbilTanggalDistinct);
    $tanggalDists = [];
    while( $tanggalDist = mysqli_fetch_assoc($objekAmbilTanggalDistinct) ) {
        $tanggalDists[] = $tanggalDist;
    }

    if( isset($_POST["submit"]) ) {
        $namaPemesan = $_POST["nama"];
        $kodeReservasiBaru = kodeReservasiBaru();
    
        // insert ke database
        mysqli_query($conn, "INSERT INTO data_reservasi(kode_reservasi, nama) VALUES ('$kodeReservasiBaru', '$namaPemesan')");
        // header("Location: dataAnggota.php");
        echo    "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'index.php';
            </script>";
    
    }

    if( isset($_POST["cari"]) ) {
        // ambil data reservasi
        $tanggalDaftar = $_POST["cariTanggal"];

        if( $tanggalDaftar != "semua" ) {
            $queryAmbilDataReservasi = "SELECT * FROM data_reservasi WHERE tanggal_daftar = '$tanggalDaftar'";
            $objectAmbilDataReservasi = mysqli_query($conn, $queryAmbilDataReservasi);
            $reservasis = [];
            while( $reservasi = mysqli_fetch_assoc($objectAmbilDataReservasi) ) {
                $reservasis[] = $reservasi;
            }
        }
        
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>GoResto</title>
</head>
<body>
<header id="header">
        <div class="container">
            <center><br><br>
            <h2 class="brand"><a href="index.php">GoResto</a></h2>
                <br><br>
            </center>
        </div>
    </header><br><br><br><br>
    
    <section id="content">
        <div >
            <center>
                <a href="tambahMenu.php"><b>Tambah Menu</b></a>
                <br><br>
                <!-- <a href="cetak.php" target="_blank"><b>Cetak</b></a> -->
                <button type="button" name="cetak" onclick="return window.print();">Cetak</button>
                <br><br>
                <form action="" method="post">
                    <label for="nama">Input Nama : </label>
                    <input type="text" name="nama" id="nama" required autocomplete="off">
                    <button type="submit" name="submit">Pesan Sekarang!</button>
                </form>
                <br><br>
                <h2>Riwayat Pemesan</h2>
                <form action="" method="post">
                    <label for="cariTanggal">Filter Berdasarkan Tanggal : </label>
                    <select name="cariTanggal" id="cariTanggal" required>
                        <option value="semua" selected>Semua</option>
                        <?php foreach( $tanggalDists as $tanggalDS ) : ?>
                            <option value="<?= $tanggalDS['tanggal_daftar']; ?>"><?= $tanggalDS['tanggal_daftar']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="cari">Cari!</button>
                </form>
                <br>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Kode Reservasi</th>
                        <th>Nama Pemesan</th>
                        <th>Tanggal Daftar</th>
                        <th>Total Harga</th>
                        <th class="aksi">Aksi</th>
                    </tr>
                
                    <?php $i=1; ?>
                    <?php foreach( $reservasis as $reservasi ) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $reservasi["kode_reservasi"]; ?></td>
                            <td><?= $reservasi["nama"]; ?></td>
                            <td><?= $reservasi["tanggal_daftar"]; ?></td>
                            <td>Rp. <?= $reservasi["total_harga"]; ?></td>
                            <td class="aksi"><a href="transaksi.php?kode_reservasi=<?= $reservasi["kode_reservasi"]; ?>">Transaksi</a> | <a href="editReservasi.php?kode_reservasi=<?= $reservasi["kode_reservasi"]; ?>">Edit</a> | <a href="hapus.php?kode_reservasi=<?= $reservasi["kode_reservasi"]; ?>" onclick="return confirm('Yakin Kawan?')">Hapus</a></td>
                        </tr>
                    <?php endforeach; ?>
                    
                </table>
            </center>
        </div>
    </section>
</body>
</html>