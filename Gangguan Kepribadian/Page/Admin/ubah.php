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

    // Dapatkan ID yang dipass
    $ID = $_GET['ID'];
    $SelecteDB = $_GET['DB'];

    // Get data to show
    if ( isset($_GET['ID']) ) {
        $sql = "SELECT * FROM $SelecteDB WHERE ID=$ID";
        $result = assoc_query($sql);
    }

    // Get changed data
    if ( isset($_POST['update']) ) {
        //Dapatkan data yang diubah
        $ID = $_POST['ID'];
        $KodeGangguan = $_POST['KodeGangguan'];

        if ( $SelecteDB == "dgangguan" ) {  
            $NamaGangguan = $_POST['NamaGangguan'];
            $DaftarGejala = $_POST['DaftarGejala'];
            $data = [   
                        "ID" => $ID,
                        "Kode_Gangguan" => "$KodeGangguan",
                        "Nama_Gangguan" => "$NamaGangguan",
                        "Daftar_Gejala" => "$DaftarGejala"   
            ];
        } else {
            $KodePertanyaan = $_POST['KodePertanyaan'];
            $Pertanyaan = $_POST['Pertanyaan'];
            $data = [   
                        "ID" => $ID,
                        "Kode_Gangguan" => "$KodeGangguan",
                        "Kode_Pertanyaan" => "$KodePertanyaan",
                        "Pertanyaan" => "$Pertanyaan"   
            ];
        }

        if ( Ubah($SelecteDB,$data) > 0) {
            
            echo "<script>
                    alert('Data berhasil diubah !');
                    document.location.href = 'show.php';
                  </script>";
        }
    } 

    if ( isset($_POST['cancel']) ) {
        header('Location: show.php');
        exit;
    }
?>
<DOCTYPE html>
<html>
    <head>
        <title>Page Ubah</title>
        <link rel="stylesheet" href="../../CSS/modify.css">
    </head>

    <body>
        <div class="form">
            <form action="" method="POST">
                <?php if ( $SelecteDB == "dgangguan" ): ?>
                    <input type="hidden" name="ID" id="ID" value="<?= $result['ID'] ?>">
                    <table>
                        <tr>
                            <th> <label for="KodeGangguan">Kode Gangguan</label> </th>
                            <td> <input type="text" name="KodeGangguan" id="KodeGangguan" value="<?= $result['Kode_Gangguan'] ?>" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <th> <label for="NamaGangguan">NamaGangguan</label> </th>
                            <td> <input type="text" name="NamaGangguan" id="NamaGangguan" size="27" value="<?= $result['Nama_Gangguan'] ?>" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <th> <label for="DaftarGejala">DaftarGejala</label> </th>
                            <td> <input type="text" name="DaftarGejala" id="DaftarGejala" size="27" value="<?= $result['Daftar_Gejala'] ?>" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <th>  </th>
                            <td> 
                                <button type="submit" name="update">Update</button> 
                                <button type="submit" name="cancel">Cancel</button>
                            </td>
                        </tr>
                    </table>
                <?php else: ?>             
                    <input type="hidden" name="ID" id="ID" value="<?= $result['ID'] ?>">
                    <table>
                        <tr>
                            <th> <label for="KodeGangguan">Kode Gangguan</label> </th>
                            <td> <input type="text" name="KodeGangguan" id="KodeGangguan" value="<?= $result['Kode_Gangguan'] ?>" required> </td>
                        </tr>
                        <tr>
                            <th> <label for="KodePertanyaan">KodePertanyaan</label> </th>
                            <td> <input type="text" name="KodePertanyaan" id="KodePertanyaan" value="<?= $result['Kode_Pertanyaan'] ?>" required> </td>
                        </tr>       
                        <tr>
                            <th> <label for="Pertanyaan">Pertanyaan</label> </th>
                            <td> <textarea type="text" name="Pertanyaan" id="Pertanyaan" required><?= $result['Pertanyaan'] ?></textarea> </td>
                        </tr> 
                        <tr>
                            <th> </th>
                            <td> 
                                <button type="submit" name="update" onclick="return confirm('Data akan diupdate. \t Apakah Anda nyakin ingin melanjutkannya?')">Update</button>  
                                <button type="submit" name="cancel">Cancel</button>
                            </td>
                        </tr>               
                    </table>
                <?php endif; ?>
            </form>
        </div>
    </body>
</html>

