<?php 
    session_start();

    $_SESSION = [];
    session_unset();
    session_destroy();

    setcookie("Bullet", "", time()-3600); //Bullet = Email
    setcookie("Metal", "", time()-3600); //Metal = Username
    setcookie("Attribute", "", time()-3600); //Attribute = 
    setcookie("Identifier", "", time()-3600);
    setcookie("Mode", "", time()-3600);

    setcookie('totalData', "", time()+1800);
    setcookie('keyword', "", time()+1800);
    setcookie('awalData', "", time()+1800);
    setcookie('jumlahDataperHalaman', "", time()+1800);
    setcookie('SelecteDB', "", time()+1800);

    echo    "<script>
                alert('Log Out Berhasil!');
                document.location.href = '../login.php';
            </script>";
?>