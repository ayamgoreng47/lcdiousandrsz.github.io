<?php
    session_start();
    require 'admnavbar.php';

    if ( isset($_COOKIE['Mode']) ) {
        $Q = $_COOKIE['Mode'];
        if ( $Q !== 'Admin' ) {
            echo    "<script>
                        alert('Eitss, mw kemana?');
                        document.location.href = 'logout.php';
                    </script>";
        }
    }

    // Cookie or Session Checker
    if ( isset($_COOKIE['Metal']) && isset($_COOKIE['Bullet']) && isset($_COOKIE['Attribute'])) {
        $Metal = $_COOKIE['Metal'];      // Username
        $Bullet = $_COOKIE['Bullet'];    // Email
        $Attribute = $_COOKIE['Attribute']; // Cookie Pengecoh
        $Identifier = $_COOKIE['Identifier'];

        cookieLogin("Admin",$Bullet,'Cookie',$Identifier);              
    } else if (isset($_SESSION['Metal']) && isset($_SESSION['Bullet']) && isset($_SESSION['Attribute'])) {
        $Metal = $_SESSION['Metal'];      // Username
        $Bullet = $_SESSION['Bullet'];    // Email
        $Attribute = $_SESSION['Attribute'];    // Cookie Pengecoh
        $Identifier = $_SESSION['Identifier'];

        sessionLogin("Admin",$Bullet,'Session',$Identifier);
    } else {
        echo    "<script>
                    alert('Log In Ulang Bro...');
                    document.location.href = 'logout.php';
                </script>";
    } 

    // Ambil data dari radio-btn yg dipilih
    $affected_rows = 0;
    
    // Ketika user menekan tombol cari...
    $results = [];      // Array untuk menyimpan hasil

    if ( isset($_POST['cari']) ) {

        if ( !isset($_POST['database']) ) {
            echo    "<script>
                        alert('Centang dulu apa yang mau dicari...');
                        document.location.href = 'show.php';
                    </script>";
        } else {
            $SearchBar = htmlspecialchars($_POST['SearchBar']);  
            $keyword = $_POST["SearchBar"];

            if ( !empty($SearchBar) ) {            
                $SelecteDB = htmlspecialchars($_POST['database']);
                $results = Show($SelecteDB,$SearchBar);
                $affected_rows = mysqli_affected_rows($conn); 
            } else if ( empty($SearchBar )) {
                $SelecteDB = htmlspecialchars($_POST['database']);
                $results = ShowAll($SelecteDB);
                $affected_rows = mysqli_affected_rows($conn);
            }
        }       

        // Navigation Logic & Variable
        $totalData = count(rquery("SELECT * FROM $SelecteDB"));
        $jumlahDataperHalaman = 5;
        $jumlahHalaman = ceil($totalData/$jumlahDataperHalaman); 
        $halamanAktif = ( isset($_GET['halaman']) ? $_GET['halaman'] : 1);
        $awalData = ( $jumlahDataperHalaman*$halamanAktif ) - $jumlahDataperHalaman; 
        
        // Simpan data dalam cookie agar dapat digunakan ulang
        setcookie('totalData', $totalData, time()+1800);
        setcookie('keyword', $keyword, time()+1800);
        setcookie('awalData', $awalData, time()+1800);
        setcookie('jumlahDataperHalaman', $jumlahDataperHalaman, time()+1800);
        setcookie('SelecteDB', $SelecteDB, time()+1800);

        $results = cariS($keyword,$awalData,$jumlahDataperHalaman,$SelecteDB);
    } else {
        if ( !empty($keyword)) {
            // Ambil data yang udah disimpan di cookie
            $keyword = $_COOKIE['keyword'];
            $awalData = $_COOKIE['awalData'];
            $jumlahDataperHalaman = $_COOKIE['jumlahDataperHalaman'];
            $SelecteDB = $_COOKIE['SelecteDB'];

            // Lakukann perhitungan lagi
            $jumlahDataperHalaman = 5;
            $jumlahHalaman = ceil($totalData/$jumlahDataperHalaman); 
            $halamanAktif = ( isset($_GET['halaman']) ? $_GET['halaman'] : 1);
            $awalData = ( $jumlahDataperHalaman*$halamanAktif ) - $jumlahDataperHalaman; 
            
            // Set ulang cookie dengan nilai terbaru
            setcookie('awalData', $awalData, time()+1800);
            setcookie('jumlahDataperHalaman', $jumlahDataperHalaman, time()+1800);
            setcookie('SelecteDB', $SelecteDB, time()+1800);

            // Lakukan query
            $results = cariS($keyword,$awalData,$jumlahDataperHalaman,$SelecteDB);
        } else if ( empty($keyword) && isset($_COOKIE['SelecteDB'])) {
            // Ambil data yang udah disimpan di cookie
            $awalData = $_COOKIE['awalData'];
            $jumlahDataperHalaman = $_COOKIE['jumlahDataperHalaman'];
            $SelecteDB = $_COOKIE['SelecteDB'];
            $totalData = $_COOKIE['totalData'];

            // Lakukan perhitungan lagi
            $jumlahDataperHalaman = 5;
            $jumlahHalaman = ceil($totalData/$jumlahDataperHalaman); 
            $halamanAktif = ( isset($_GET['halaman']) ? $_GET['halaman'] : 1);
            $awalData = ( $jumlahDataperHalaman*$halamanAktif ) - $jumlahDataperHalaman; 
            
            // Set ulang cookie dengan nilai terbaru
            setcookie('awalData', $awalData, time()+1800);
            setcookie('jumlahDataperHalaman', $jumlahDataperHalaman, time()+1800);
            setcookie('SelecteDB', $SelecteDB, time()+1800);
            
            // Lakukan query
            $results = cariS('',$awalData,$jumlahDataperHalaman,$SelecteDB);
        } 
    } 
?>

<DOCTYPE html>
<html>
    <head>
        <title>Show Data</title>
        <link rel="stylesheet" href="../../CSS/show.css">
    </head>

    <body>
        


        <!-- SEARCH BAR -->

        <div class="form">
            <h1>Pencarian Daftar Pertanyaan</h1>
            <br>
            <?php if ( isset($_POST['cari']) && $affected_rows <= 0 ): ?>
                <h1>Data tidak ditemukan!</h1>
            <?php endif; ?>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td> 
                            <input type="radio" name="database" value="dgangguan" id="databaseG">                        
                            <label for="databaseG">Gangguan</label> 
                        </td>
                        
                    </tr>
                    <tr>
                        <td> 
                            <input type="radio" name="database" value="dpertanyaan" id="databaseP">
                            <label for="databaseP">Pertanyaan</label>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            <input type="text" name="SearchBar" id="SearchBar" autocomplete="off"> 
                            <button type="submit" name="cari">Cari !</button>
                        </td>
                        
                    </tr>
                </table>
            </form>
        </div>
 
        <!-- SHOW DATA  -->
        <div class="form">
            <?php if ( isset($_COOKIE['totalData'])): ?>
                <!-- Navigasi -->
                <?php if ( $halamanAktif > 1 ): ?>
                    <a href="show.php?halaman=<?= $halamanAktif-1; ?>" style="font-weight:bold; text-decoration:none; color:rgb(255, 210, 10); margin-left: 1.5%;">&laquo</a>
                <?php endif; ?>

                <?php if ( $jumlahHalaman>1 ): ?>
                    <?php for ($i = 1; $i <= $jumlahHalaman ; $i++) : ?>
                        <?php if ($i == $halamanAktif): ?>
                            <a href="?halaman=<?= $i ?>" style="font-weight:bold; text-decoration:none; color:rgb(0, 255, 34); margin-left: 1.5%;"><?= $i ?></a>
                        <?php else: ?>
                            <a href="?halaman=<?= $i ?>" style="font-weight:bold; text-decoration:none; color:rgb(255, 210, 10); margin-left: 1.5%;"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?> 
                <?php endif; ?>

                <?php if ( $halamanAktif<$jumlahHalaman ): ?>
                    <a href="show.php?halaman=<?= $halamanAktif+1; ?>" style="font-weight:bold; text-decoration:none; color:rgb(255, 210, 10); margin-left: 1.5%;">&raquo</a>
                <?php endif; ?>
                    
                <!-- Table to show Gangguan -->
                <?php if ($SelecteDB == "dpertanyaan"): ?>
                    <table border="3" cellspacing="3">
                        <tr>
                            <td><h1>No.</h1></td>
                            <td><h1>Aksi</h1></td>
                            <td><h1>Kode Gangguan</h1></td>
                            <td><h1>Kode Pertanyaan</h1></td>
                            <td><h1>Pertanyaan</h1></td>
                        </tr>
                        <?php $i=1; while ( $row = mysqli_fetch_assoc($results) ): ?>
                            <tr>
                                <?php $urlUbah = "ubah.php?ID=$row[ID] & DB=$SelecteDB"?>
                                <?php $urlHapus = "hapus.php?ID=$row[ID] & DB=$SelecteDB"?>
                                <td><?= $i;?></td>
                                <td>
                                    <a href="<?= $urlUbah ?>" style="color: rgba(0, 255, 255, 0.781)">Ubah </a>
                                    <a href="<?= $urlHapus ?>" style="color: rgba(255, 7, 7, 0.822)" onclick="return confirm('Data akan dihapus. Anda nyakin?')">Hapus</a>
                                </td>
                                <td><?= $row['Kode_Gangguan'] ?></td>
                                <td><?= $row['Kode_Pertanyaan'] ?></td>
                                <td><?= $row['Pertanyaan'] ?></td>
                            </tr>  
                            <?php $i++; ?>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <table border="3" cellspacing="3">
                        <tr>
                            <td><h1>No.</h1></td>
                            <td><h1>Aksi</h1></td>
                            <td><h1>Kode Gangguan</h1></td>
                            <td><h1>Nama Gangguan</h1></td>
                            <td><h1>Daftar Gejala</h1></td>
                        </tr>

                        <?php $i=1; while ( $row = mysqli_fetch_assoc($results) ): ?>
                            <tr>
                                <?php $urlUbah = "ubah.php?ID=$row[ID] & DB=$SelecteDB"?>
                                <?php $urlHapus = "hapus.php?ID=$row[ID] & DB=$SelecteDB"?>
                                <td><?= $i;?></td>
                                <td>
                                    <a href="<?= $urlUbah ?>" style="color: rgba(0, 255, 255, 0.781)">Ubah</a>
                                    <a href="<?= $urlHapus ?>" style="color: rgba(255, 7, 7, 0.822)" onclick="return confirm('Data akan dihapus. Anda nyakin?')">Hapus</a>
                                </td>
                                <td><?= $row['Kode_Gangguan'] ?></td>
                                <td><?= $row['Nama_Gangguan'] ?></td>
                                <td><?= $row['Daftar_Gejala'] ?></td>
                            </tr>  
                            <?php $i++; ?>
                        <?php endwhile; ?>
                    </table>
                <?php endif; ?>                       
            <?php endif; ?>
        </div>
    </body>
</html>