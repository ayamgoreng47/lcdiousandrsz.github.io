<?php 
    session_start();
    require 'usrnavbar.php';
    
    if ( isset($_COOKIE['Mode']) ) {
        $Q = $_COOKIE['Mode'];
        if ( $Q !== 'User' ) {
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

        cookieLogin("User",$Bullet,'Cookie',$Identifier);              
    } else if (isset($_SESSION['Metal']) && isset($_SESSION['Bullet']) && isset($_SESSION['Attribute'])) {
        $Metal = $_SESSION['Metal'];      // Username
        $Bullet = $_SESSION['Bullet'];    // Email
        $Attribute = $_SESSION['Attribute'];    // Cookie Pengecoh
        $Identifier = $_SESSION['Identifier'];

        sessionLogin("User",$Bullet,'Session',$Identifier);
    } else {
        echo    "<script>
                    alert('Log In Ulang Bro...');
                    document.location.href = 'logout.php';
                </script>";
    } 

    // Array untuk menampung Daftar Pertanyaan yang dipilih
    $daftarGejala = raw_query("SELECT * FROM dpertanyaan");   
?>

<DOCTYPE html>
<html>
    <head>
        <title>title</title>
        <link rel="stylesheet" href="../../CSS/show.css">
    </head>

    <body> 
        <div class="form">
            <form action="jawaban.php" method="POST">
                <table>
                    <h1 style="width: fit-content; color: snow; background-color: rgba(0, 0, 0, 0.377); padding: 1% 1%">Silahkan Jawab Pertanyaan dengan Jujur!</h1>
                    <?php while ($row = mysqli_fetch_assoc($daftarGejala)) : ?>
                        
                        <tr>
                            <td> <input type="checkbox" name="jawabanUser[]" id="<?= $row['Kode_Pertanyaan'] ?>" value="<?= $row['Kode_Pertanyaan']?>"> </td>
                            <td> <label for="<?= $row['Kode_Pertanyaan'] ?>"><?= $row['Pertanyaan'] ?></label> </td>                                    
                        </tr>
                        
                    <?php endwhile ?>
                    <tr>
                        <th></th>
                        <td><button type="submit" name="submit">Analisis !</button></td>
                    </tr>
                </table>
            </form>  
        </div>
            
    </body>
</html>