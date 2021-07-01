<?php
    require "config.php";

    $id = $_GET["kode_reservasi"];

    // ambil data reservasi
    $queryAmbilDataReservasi = "SELECT * FROM data_reservasi WHERE kode_reservasi = '$id'";

    $objectAmbilDataReservasi = mysqli_query($conn, $queryAmbilDataReservasi);
    $reservasi = mysqli_fetch_assoc($objectAmbilDataReservasi);
       
    // ambil data transaksi
    $queryAmbilDataTransaksi = "SELECT id_transaksi, kode_reservasi, data_menu.id_menu, jumlah_pesanan, nama_menu_saat_ini, nama_menu, harga_saat_ini, harga FROM transaksi
    JOIN data_menu ON(transaksi.id_menu = data_menu.id_menu) WHERE kode_reservasi = '$id'
    GROUP BY nama_menu_saat_ini";
    
    
    $objectAmbilDataTransaksi = mysqli_query($conn, $queryAmbilDataTransaksi);
    
    $transaksis = [];
    while( $transaksi = mysqli_fetch_assoc($objectAmbilDataTransaksi) ) {
        $transaksis[] = $transaksi;
    }

    // ambil data menu
    $queryAmbilDataMenu = "SELECT * FROM data_Menu";
    $objectAmbilDataMenu = mysqli_query($conn, $queryAmbilDataMenu);
    $menus = [];
    while( $menu = mysqli_fetch_assoc($objectAmbilDataMenu) ) {
        $menus[] = $menu;
    }

    if( isset($_POST["submit"]) ) {
        $id_menu = $_POST["menu"];
        $jumlahPesanan = $_POST["jumlah-pesanan"];

        // ambil data harga menu yang dipilih
        $queryAmbilHargaMenu = "SELECT nama_menu, harga FROM data_menu WHERE id_menu = '$id_menu'";
        $objekAmbilHargaMenu = mysqli_query($conn, $queryAmbilHargaMenu);
        $dataMenu = mysqli_fetch_assoc($objekAmbilHargaMenu);
        $hargaMenu = $dataMenu["harga"];
        $namaMenu = $dataMenu["nama_menu"] ;
    

        $queryInsertTransaksi = "INSERT INTO transaksi(kode_reservasi, id_menu, nama_menu_saat_ini, jumlah_pesanan, harga_saat_ini) VALUES ('$id', '$id_menu', '$namaMenu', '$jumlahPesanan', '$hargaMenu')";
        
        // insert ke database
        mysqli_query($conn, $queryInsertTransaksi);
        
        // header("Location: dataPeminjaman.php");
        echo    "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'transaksi.php?kode_reservasi=$id';
            </script>";
            
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi</title>
    <link rel="stylesheet" href="style.css">
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
        <div class="container">
            <center>
            <button type="button" name="cetak" onclick="return window.print();">Cetak</button>
                <br><br>
                <form action="" method="post">
                    <label for="menu">Input Menu : </label>
                    <select name="menu" id="menu" required>
                        <option value="" selected disabled>Pilih menu</option>
                        <?php foreach( $menus as $menu ) : ?>
                            <option value="<?= $menu["id_menu"] ?>"><?= $menu["nama_menu"] ?> ( Rp. <?= $menu["harga"]; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" min="1" max="10" name="jumlah-pesanan" placeholder="Jumlah Pesanan" required>
                    <button type="submit" name="submit">Tambah Pesanan!</button>
                </form>
                <br><br>
                <h3>Nama Pemesan : <?= $reservasi["nama"]; ?></h3>
                <h3>Kode Reservasi : <?= $id; ?></h3>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Nama Menu Saat Ini</th>
                        <th>Jumlah Pesanan</th>
                        <th>Harga Saat Ini</th>
                        <th>Total Harga</th>
                        <th class="aksi">Aksi</th>
                    </tr>
                
                    <?php if ( mysqli_num_rows($objectAmbilDataTransaksi) > 0 ) : ?>
                        <?php $i=1; ?>
                        <?php foreach( $transaksis as $transaksi ) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                
                                <td><?= $transaksi["nama_menu_saat_ini"]; ?></td>
                                
                                <td><?= $transaksi["jumlah_pesanan"]; ?></td>

                                <td>Rp. <?= $transaksi["harga_saat_ini"]; ?></td>
                                <td>Rp. <?= $totalHarga = $transaksi["harga_saat_ini"] * $transaksi["jumlah_pesanan"]; ?></td>
                                <td class="aksi"><a href="editTransaksi.php?id_transaksi=<?= $transaksi["id_transaksi"]; ?>&kode_reservasi=<?= $id; ?>">Edit</a> | <a href="hapusTransaksi.php?id_transaksi=<?= $transaksi["id_transaksi"]; ?>&kode_reservasi=<?= $id; ?>" onclick="return confirm('Yakin Kawan?')">Hapus</a></td>
                            </tr>
                            <?php $totalHargaSeluruhnya[] = $totalHarga; ?>
                        
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="4" align="center">Total Harga Keseluruhan</th>
                            <th colspan="2" align="center">Rp. <?= $sumTotalHargaSeluruhnya = array_sum($totalHargaSeluruhnya); ?></th>
                        </tr>
                    <?php endif; ?>

                    <?php if( isset($sumTotalHargaSeluruhnya) ) {
                        // update total harga
                        $queryUpdateTotalHarga = "UPDATE data_reservasi SET total_harga = '$sumTotalHargaSeluruhnya'
                            WHERE kode_reservasi = '$id'
                        ";
                        mysqli_query($conn, $queryUpdateTotalHarga);
                    } else {
                        $queryUpdateTotalHarga = "UPDATE data_reservasi SET total_harga = 0
                            WHERE kode_reservasi = '$id'
                        ";
                        mysqli_query($conn, $queryUpdateTotalHarga);
                    }
                    
                    ?>
                    
                </table>
            </center>
        </div>
    </section>
</body>
</html>