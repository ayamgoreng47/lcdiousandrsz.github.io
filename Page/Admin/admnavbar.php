<?php 
    require '../../functions.php';

    if ( isset($_COOKIE['Bullet']) ) {
        $Email = $_COOKIE['Bullet'];
        $result = assoc_query("SELECT * FROM admins WHERE EMAIL = '$Email'");
    } 
    
    if ( isset($_SESSION['Bullet']) ) {
        $Email = $_SESSION['Bullet'];
        $result = assoc_query("SELECT * FROM admins WHERE EMAIL = '$Email'");
    }  
?>

<DOCTYPE html>
<html id="admin">
    <head>
        <title>Navigation Bar</title>
        <link rel="stylesheet" href="../../CSS/navbar.css">
    </head>

    <body>
        <?php if ( isset($_SESSION['Bullet']) || isset($_COOKIE['Bullet'])): ?>
            <nav>       
                <ul>
                    <li><a href="index.php">Home</a></li>                     
                    <li><a href="show.php">Show Data</a></li>
                    <li><a href="tambah.php">Add Data</a></li>
                    <li><a href="show.php">Modify Data</a></li>
                </ul>                                      
                <ul></ul>   
                <ul>                                     
                    <li> <a href="logout.php">Log Out</a> </li>
                    <li> <img src="img/<?= $result['Gambar']?>" alt="<?= $result['Gambar'];?>" width="33" height="33"> </li>
                    <li> <a href=""> <?= $result['Username'];?> </a> </li>                    
                </ul>                               
            </nav>
        <?php else: ?>
            <nav>       
                <ul>
                    <li><a href="../../index.php">Home</a></li>           
                    <li><a href="../../about.php">About</a></li>                                            
                    <li><a href="../../contact.php">Contact</a></li>
                </ul>                                      
                <ul></ul>                                               
            </nav>
        <?php endif; ?>
    </body>
</html>