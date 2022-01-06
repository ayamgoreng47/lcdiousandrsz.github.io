<?php 
    require 'admnavbar.php';

    // Cookie Checker
    if ( isset($_COOKIE['Metal']) && isset($_COOKIE['Bullet']) ) {
        $Metal = $_COOKIE['Metal'];      // Username
        $Bullet = $_COOKIE['Bullet'];    // Email
        
        $sql = "SELECT * FROM sessionss WHERE Email = '$Bullet'";
        $result = assoc_query($sql);
    
        $cookieUsername = hash('sha256', $result['Username']);
        $cookieEmail = hash('sha256', $Bullet);
        $combination = $cookieUsername.$cookieEmail;
        
        if ( $result['Session'] === $combination ) {       // Buatlah keamanan berlapis
            if ( !isset($_SESSION['Login']) ) {
                echo    "<script>
                            alert('Log In-nya yang Benar ya..');
                            document.location.href = 'login.php';
                        </script>";
            } else {
                echo "Program berhasil";
            }
            
        } else {
            echo    "<script>
                        alert('Eitss, nggak boleh nakal ya');
                        document.location.href = 'logout.php';
                    </script>";
        }
    } else {
        echo    "<script>
                    alert('Sesi udah Habis\nLog In Ulang Bro...');
                    document.location.href = 'logout.php';
                </script>";
    }   

    if ( isset($_POST['register']) ) {
        // Data $POST
        $Username = htmlspecialchars(stripslashes($_POST['Username']));
        $Email = htmlspecialchars($_POST['Email']);
        $Password = mysqli_real_escape_string($conn,$_POST['Password']);
        $Password2 = mysqli_real_escape_string($conn,$_POST['Password2']);
        $userData = [
                "Username" => $Username,
                "Email" => $Email,
                "Password" => $Password
        ];

        //Satu email hanya untuk satu akun
        $daftarEmailChecker = mysqli_query($conn,"SELECT Email FROM admins");
        $daftarEmail = assoc_query("SELECT Email FROM admins");

        // Mengantisipasi DB yang kosong/baru
        if ( mysqli_num_rows($daftarEmailChecker)>1 ) {
            if ( in_array($Email, $daftarEmail) ) {           
                echo    "<script>
                            alert('Email sudah terdaftar!');
                            document.location.href = 'login.php';
                        </script>"; 
                exit;
            }
        }


        $userPicture = [];
        if ( isset($_FILES['Gambar']) ) {
            $namaFile = $_FILES['Gambar']['name'];
            $tmpDir = $_FILES['Gambar']['tmp_name'];
            $Size = $_FILES['Gambar']['size'];
            $Error = $_FILES['Gambar']['error'];

            $userPicture = [
                'namaFile' => $namaFile,
                'tmpDir' => $tmpDir,
                'Size' => $Size,
                'Error' => $Error,

                'Username' => $Username,
                'Email' => $Email
            ];
        }

        if ( $Password != $Password2 ) {
            echo    "<script>
                        alert('Password Does Not Match!');
                    </script>";
        }

        if ( Register('admins',$userData,$userPicture) > 0 ) {
            echo    "<script>
                        alert('Congratulations! Data has been registered');
                        document.location.href = 'login.php';
                    </script>";
        }
    }
?>

<DOCTYPE html>
<html>
    <head>
        <title>Register Page</title>
        <link rel="stylesheet" href="../../CSS/page.css">
    </head>

    <body>
        <div class="form">
            <form action="" method="POST" enctype="multipart/form-data">        
                <table>
                    <tr>
                        <th> <label for="Username">Nama Lengkap</label> </th>
                        <td> <input type="text" name="Username" id="Username" autocomplete="off" placeholder="Ex. Jotaro Jojo"> </td>
                    </tr>
                    <tr>
                        <th> <label for="Email">Email</label> </th>
                        <td> <input type="text" name="Email" id="Email" autocomplete="off" placeholder="Ex. jotaro@pijar.com"> </td>
                    </tr>
                    <tr>                             
                        <th> <label for="Password">Password</label> </th>
                        <td> <input type="password" name="Password" id="Password" autocomplete="off"> </td>
                    </tr>
                    <tr>                         
                        <th> <label for="Password2">Password2</label> </th>
                        <td> <input type="password" name="Password2" id="Password2" autocomplete="off"> </td>
                    </tr>
                    <tr>                        
                        <th> <label for="Gambar">Profile Picture</label> </th>
                        <td> <input type="file" name="Gambar" id="Gambar"> </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td> <button type="submit" name="register" onclick="return confirm('Data yang sudah diregistrasi tidak dapat diubah. \nApakah Anda nyakin ingin melanjutkan?')">Register</button>   </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>Already have an account? <a href="login.php">Log In</a></td>
                    </tr>
                </table>
            </form>
        </div>

    </body>
</html>