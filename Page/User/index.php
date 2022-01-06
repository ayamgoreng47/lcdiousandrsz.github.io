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

    if ( isset($_SESSION['Metal'])) {
        $Metal = $_SESSION['Metal'];
    } if( isset($_COOKIE['Metal'])) {
        $Metal = $_COOKIE['Metal'];
    }

    $result = assoc_query("SELECT * FROM users WHERE Email = '$Bullet'")
?>

<DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="../../CSS/index.css"> 
    </head>

    <body>
        <div class="margin center" style="margin-top: 15%">
            <h1>Welcome <?= $result['Username'] ?>!</h1> 
            <h1>Nice to meet you!</h1>
        </div>  
    </body>
</html>