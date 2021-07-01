<?php
    require "config.php";

    $queryAmbilDataMenu = "SELECT * FROM data_menu";

    $objectAmbilDataMenu = mysqli_query($conn, $queryAmbilDataMenu);
    
    $menus = [];
    while( $menu = mysqli_fetch_assoc($objectAmbilDataMenu) ) {
        $menus[] = $menu;
    }

    if( isset($_POST["submit"]) ) {
        $menuBaru = $_POST["menuBaru"];
        $hargaBaru = $_POST["hargaBaru"];
        $queryInsertMenu = "INSERT INTO data_menu(nama_menu, harga) VALUES ('$menuBaru', '$hargaBaru')";
        
        // insert ke database
        mysqli_query($conn, $queryInsertMenu);
        
        // header("Location: dataPeminjaman.php");
        echo    "<script>
                alert('Data Berhasil Ditambahkan');
                document.location.href = 'tambahMenu.php';
            </script>";
            
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Menu</title>
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
                    <label for="menuBaru">Input Nama Menu Baru : </label>
                    <input type="text" name="menuBaru" id="menuBaru" required autocomplete="off">
                    &emsp;
                    <label for="hargaBaru">Harga : </label>
                    <input type="number" id="hargaBaru" min="1000" max="100000" name="hargaBaru" placeholder="Rp." required>
                    <button type="submit" name="submit">Submit</button>
                </form>
                <br><br>
                <h2>List Menu</h2>
                <table border="1" cellpadding="10" cellspacing="0">
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th class="aksi">Aksi</th>
                    </tr>
                
                    <?php $i=1; ?>
                    <?php foreach( $menus as $menu ) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $menu["nama_menu"]; ?></td>
                            <td>Rp. <?= $menu["harga"]; ?></td>
                            <td class="aksi"><a href="editMenu.php?id_menu=<?= $menu["id_menu"]; ?>">Edit</a> | <a href="hapusMenu.php?id_menu=<?= $menu["id_menu"]; ?>" onclick="return confirm('Yakin Kawan?')">Hapus</a></td>
                        </tr>
                    <?php endforeach; ?>
                    
                </table>
            </center>
        </div>
    </section>
</body>
</html>