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

    
    if ( isset($_POST['submitgangguan']) || isset($_POST['submitpertanyaan']) || isset($_POST['submitsolusi'])) {
        $temp = '';
        if ( isset($_POST['submitgangguan']) ) {
            $KodeGangguan = $_POST['KodeGangguan'];
            $NamaGangguan = $_POST['NamaGangguan'];
            $DaftarGejala = $_POST['DaftarGejala'];
            
            $data = "'','$KodeGangguan','$NamaGangguan','$DaftarGejala'";
            $result = Tambah('dgangguan',$data);
            $temp = 'Gangguan';

        } if ( isset($_POST['submitpertanyaan']) ) {
            $KodeGangguann = $_POST['KodeGangguann'];
            $KodePertanyaan = $_POST['KodePertanyaan'];
            $Pertanyaan = $_POST['Pertanyaan'];
    
            $data = "'','$KodeGangguann','$KodePertanyaan','$Pertanyaan'";
            $result = Tambah('dpertanyaan',$data);
            $temp = 'Pertanyaan';
        } if ( isset($_POST['submitsolusi']) ) {
            $KodeGangguan = $_POST['KodeGangguan'];
            $NamaGangguan = $_POST['NamaGangguan'];
            $Penyebab = $_POST['Penyebab'];
            $Solusi = $_POST['Solusi'];

            $data2 = "'','$KodeGangguan','$NamaGangguan','$Penyebab','$Solusi'";
            $result2 = Tambah('penyebab',$data2);
            $temp = 'Solusi & Penyebab';
        }

        if ( $result>0 ) {
            echo    "<script>
                        alert('$temp berhasil ditambahkan!');
                    </script>";
        } else {
            echo    "<script>
                        alert('$temp GAGAL ditambahkan!');
                    </script>";
        }
    }
?>

<DOCTYPE html>
<html>
    <head>
        <title>title</title>
        <link rel="stylesheet" href="../../CSS/modify.css">
    </head>

    <body>
        <div class="form">
            
            <form action="" method="POST">              
                <table>
                    <h1>Tambahkan Gangguan Baru</h1>
                    <tr>
                        <th> <label for="KodeGangguan">KodeGangguan</label> </th>
                        <td> <input type="text" name="KodeGangguan" id="KodeGangguan" required autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <th> <label for="NamaGangguan">Nama Gangguan</label> </th>
                        <td> <input type="text" name="NamaGangguan" id="NamaGangguan"  autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <th> <label for="DaftarGejala">Daftar Gejala</label> </th>
                        <td> <input type="text" name="DaftarGejala" id="DaftarGejala" required autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <th> <label for="Penyebab">Penyebab</label> </th>
                        <td> <textarea name="Penyebab" id="Penyebab" rows="5" colus="50" required autocomplete="off"></textarea> </td>
                    </tr>
                    <tr>
                        <th> <label for="Solusi">Solusi</label> </th>
                        <td> <textarea name="Solusi" id="Solusi" rows="5" colus="50" required autocomplete="off"></textarea> </td>
                    </tr>
                    <tr>
                        <th>  </th>
                        <td> <button type="submit" name="submitgangguan">Tambahkan Gangguan!</button> </td>
                    </tr>
                </table>
            </form>
        </div>

        <br><br><br>

        <div class="form">
            <form action="" method="POST">
                <h1>Tambahkan Pertanyaan Baru</h1>

                <table>
                    <tr>
                        <th> <label for="KodeGangguann">Kode Gangguan</label> </th>
                        <td> <input type="text" name="KodeGangguann" id="KodeGangguann" required autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <th> <label for="KodePertanyaan">KodePertanyaan</label> </th>
                        <td> <input type="text" name="KodePertanyaan" id="KodePertanyaan" required autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <th> <label for="Pertanyaan">Pertanyaan</label> </th>
                        <td> <textarea name="Pertanyaan" id="Pertanyaan" rows="5" colus="50" required autocomplete="off"></textarea> </td>
                    </tr>
                    <tr>
                        <th>  </th>
                        <td> <button type="submit" name="submitpertanyaan">Tambahkan Pertanyaan!</button> </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="form">
            <form action="" method="POST">
                <h1>Tambahkan Pertanyaan Baru</h1>

                <table>
                    <tr>
                        <th> <label for="KodeGangguann">Kode Gangguan</label> </th>
                        <td> <input type="text" name="KodeGangguann" id="KodeGangguann" required autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <th> <label for="NamaGangguan">Nama Gangguan</label> </th>
                        <td> <input type="text" name="NamaGangguan" id="NamaGangguan" required autocomplete="off"> </td>
                    </tr>
                    <tr>
                        <th> <label for="Penyebab">Penyebab</label> </th>
                        <td> <textarea name="Penyebab" id="Penyebab" rows="5" colus="50" required autocomplete="off"></textarea> </td>
                    </tr>
                    <tr>
                        <th> <label for="Solusi">Solusi</label> </th>
                        <td> <textarea name="Solusi" id="Solusi" rows="5" colus="50" required autocomplete="off"></textarea> </td>
                    </tr>
                    <tr>
                        <th>  </th>
                        <td> <button type="submit" name="submitsolusi">Tambahkan Solusi!</button> </td>
                    </tr>
                </table>
            </form>
        </div>
        <br></br>
    </body>
</html>