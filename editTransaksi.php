<?php
    require "config.php";

    $id = $_GET["id_transaksi"];
    $kodeReservasi = $_GET["kode_reservasi"];

    $queryAmbilDataTransaksi = "SELECT * FROM transaksi WHERE id_transaksi = '$id'";
    $objectAmbilDataTransaksi = mysqli_query($conn, $queryAmbilDataTransaksi);
    $transaksi = mysqli_fetch_assoc($objectAmbilDataTransaksi);
       

    if( isset($_POST["submit"]) ) {
        $jumlahBaru = $_POST["jumlahBaru"];
        $queryInsertJumlah = "UPDATE transaksi SET jumlah_pesanan = '$jumlahBaru' WHERE id_transaksi = '$id'";
        
        // update data_menu
        mysqli_query($conn, $queryInsertJumlah);
        
        // header("Location: dataPeminjaman.php");
        echo    "<script>
                alert('Data Berhasil DiUbah');
                document.location.href = 'transaksi.php?kode_reservasi=$kodeReservasi';
            </script>";
            
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Halaman Edit Transaksi</title>
</head>
<body>
 
        <header id="header">
        
            <center><br><br>
            <h2 class="brand"><a href="index.php">GoResto</a></h2>
                <br><br>
            </center>
        
    </header><br><br><br><br>
    </header>
    <section id="content">
        <div class="container">
            <center>
            <a href="transaksi.php?kode_reservasi=<?= $kodeReservasi; ?>">Back</a>
                <br><br>
                <form action="" method="post">
                    <label for="jumlahBaru">Ubah Jumlah Pesanan : </label>
                    <input type="number" min="1" max="10" name="jumlahBaru" id="jumlahBaru" required value="<?= $transaksi["jumlah_pesanan"]; ?>">
                    <button type="submit" name="submit">Submit!</button>
                </form>
                
            </center>
        </div>
    </section>
</body>
</html>