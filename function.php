<?php
    require "config.php";

    function kodeReservasiBaru() {
        global $conn;
        $kodeTanggalInputan = date("Ymd");
        $urutanInputan = 1;
        
        // ambil database
        $query = "SELECT kode_reservasi FROM data_reservasi";
        $result = mysqli_query($conn, $query);
    
        $rows = [];
        while( $row = mysqli_fetch_assoc($result) ) {
            $rows[] = $row; 
        }
    
        foreach( $rows as $row ) {
            // pisah kodeTanggalDB dan urutanDB
            $kodeReservasi = preg_split('//', $row["kode_reservasi"]);
            $kodeTanggalDB = $kodeReservasi[1] . $kodeReservasi[2] . $kodeReservasi[3] . $kodeReservasi[4] . $kodeReservasi[5] . $kodeReservasi[6] . $kodeReservasi[7] . $kodeReservasi[8];
            $urutanDB = $kodeReservasi[9] . $kodeReservasi[10] . $kodeReservasi[11] . $kodeReservasi[12];
    
            // kondisi
            if( $kodeTanggalInputan == $kodeTanggalDB ) {
                $urutanInputan = $urutanDB + 1;
            }
            
        }
    
        // sambung no_anggota
        return $kodeReservasiBaru = $kodeTanggalInputan . sprintf("%04s", $urutanInputan);
    }
?>