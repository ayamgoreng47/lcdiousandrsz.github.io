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

    // Analyze disorder based on user's answers
    $jawabanUser = [];
    if ( isset($_POST['submit']) ) {
        foreach ($_POST['jawabanUser'] as $t) {
            $jawabanUser[] = $t;
        }
    }
    
    $result = analysis($jawabanUser); 
    $penyebab = cariPenyebab($result);
    $solusi = cariSolusi($result);

    $arrSolusi = [];
    foreach($solusi as $s) {
        $arrSolusi[] = $s;
    }

    if ( isset($_SESSION['Bullet']) ) {
        $var = $_SESSION['Bullet'];
        $laporan = assoc_query("SELECT * FROM users WHERE Email = '$var'");
        
        $Username = $laporan['Username'];
        $Email = $laporan['Email'];
    }
    
    if ( isset($_COOKIE['Bullet']) ) {
        $var = $_COOKIE['Bullet'];
        $laporan = assoc_query("SELECT * FROM users WHERE Email = '$var'");

        $Username = $laporan['Username'];
        $Email = $laporan['Email'];
    }

    // Key Penyebab
    $keys = array_keys($penyebab);
    
    // Value Penyebab
    $pnyb = [];
    foreach ($penyebab as $q) {
        $pnyb[] = $q;  
    }

    $prctg = [];
    $persentase = $_COOKIE['Percentage'];
    foreach ($persentase as $prc) {
        foreach ($prc as $pr) {
            $prctg[] = round($pr,2);
        }       
    }
?>
<DOCTYPE html>
<html>
    <head>
        <title>Reporting</title>
        <link rel="stylesheet" href="../../CSS/show.css">

        <script>
            function printDiv(Laporan) {
                var restorepage = document.body.innerHTML;
                var docID = document.getElementById(Laporan).innerHTML;

                document.body.innerHTML = docID;
                window.print();
                document.body.innerHTML = restorepage;
            }
        </script>
    </head>

    <body>
        <div id="laporan">
            <div class="form">
                <table border="3" cellpadding="3" cellspacing="3">
                <h1 style="width: fit-content; color: snow; background-color: rgba(0, 0, 0, 0.377); padding: 1% 1%">Data Diri</h1>
                    <tr>
                        <th> Nama Lengkap </th>
                        <td> <?= $Username;?> </td>
                    </tr>
                    <tr>
                        <th> Electronic Mail </th>
                        <td> <?= $Email;?> </td>
                    </tr>
                    <tr>
                        <th> Tanggal Tes </th>                    
                        <?php   date_default_timezone_set('Asia/Pontianak');
                                $date = date("d/m/Y H:i", time());              ?> 
                        <th> <?= $date;?> </th>
                    </tr>
                </table>
                <br>
                <table border="3">
                    <h1 style="width: fit-content; color: snow; background-color: rgba(0, 0, 0, 0.377); padding: 1% 1%">Daftar Gejala</h1>
                    <tr>
                        <td><h1>Nama Gangguan Kepribadian</h1></td>
                        <td><h1>Persentase</h1></td>
                        <td><h1>Penyebab</h1></td>
                        <td><h1>Solusi</h1></td>           
                    </tr>
                
                    <?php for ( $i=0; $i<count($keys); $i++ ): ?>                                                                      
                        <tr>
                            <td> <?= $keys[$i];?>  </th>
                            <td> <?php echo "$prctg[$i]%";?>  </th>
                            <td> <?= $pnyb[$i];?> </td>
                            <td> <?= $arrSolusi[$i];?> </td>
                        </tr>                                                                           
                    <?php endfor; ?>                                  
                </table>
            </div>
            
            <div class="form">
                <table>
                    <tr>
                        <th> <p>Powered by PhyjarPsychology™</p> </th>          
                        <td> <img src="../../Image/Logo.png" alt="Logo.png" height="100" width="100">  </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="form">
            <table>
                <tr>
                    <th></th>
                    <td> <td> <button type="" name="" onclick="printDiv('laporan')">Cetak Laporan!</button> </td> </td>
                </tr>
            </table>
        </div>
    </body>
</html>
