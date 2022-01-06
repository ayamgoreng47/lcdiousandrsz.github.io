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

    if ( isset($_GET['ID']) && isset($_GET['DB'])) {
        $ID = $_GET['ID'];
        $DB = $_GET['DB'];

        if ( Hapus($DB,$ID) > 0) { 
            echo    "<script>
                        alert('Data berhasil dihapus !');
                        document.location.href = 'show.php';
                    </script>";
        }
    }
?>