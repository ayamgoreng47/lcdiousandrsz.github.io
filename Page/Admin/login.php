<?php 
    session_start();
    require 'admnavbar.php';


    // Cek apakah SESSION Login=true dan SESSION Stat=User 
    if ( isset($_SESSION['Login']) && isset($_SESSION['Stat'])) {
        if ( $_SESSION['Login'] == true && $_SESSION['Stat'] == 'User') {
            header('Location: index.php');
            exit;
        } else {
            echo    "<script>
                        alert('Log In nya pake cara yang benar ya');                       
                    </script>";
        }
    }

    // Ketika tombol login ditekan...
    if ( isset($_POST['login']) ) {
        //Ambil data untuk Login()
        $Email = $_POST['Email'];
        $Password = mysqli_real_escape_string($conn,$_POST['Password']);
        $data = [
                    "Email" => $Email,
                    "Password" => $Password
        ];

        if ( Login('admins',$data) == true ) {   //Jika login() berhasil
            $_SESSION['Login'] = true;
            $_SESSION['Stat'] = 'User';

            $result = Cari('admins','Email',$Email);

            if ( isset($_POST['Remember']) ) {      //Jika 'Remember Me' dicentang
                $Username = $result['Username'];
                
                // Buat cookie               
                $cookieUsername = hash('sha256', $result['Username']);
                $cookieEmail = hash('sha256', $Email);
                $combination = $cookieUsername.$cookieEmail;
                $cookieStatus = hash('sha512','Admin');  // Cookie Pengecoh

                // Identify jamnya
                date_default_timezone_set('Asia/Pontianak');
                $date = date("Y/m/d H:i", time());

                // Set cookienya
                setcookie('Metal', hash('sha256',$result['Username']), time()+ 1800);
                setcookie('Bullet', $Email, time()+1800);
                setcookie('Attribute', $cookieStatus, time()+1800);   // Cookie Pengecoh

                // Generate random number untuk mencocokkan Cookie di DB
                $number = numberChecker(rand(0,177));    
                setcookie('Identifier', $number, time()+1800);
                setcookie('Mode', 'Admin', time()+1800);
                
                // Simpan ke DB                
                query("INSERT INTO sessionss VALUES ('','Admin','$Username','$Email','$combination','Cookie','$date',$number)");
            } else {    //Jika 'Remember Me' nggak dicentang
                $Username = $result['Username'];

                // Buat session               
                $sessUsername = hash('sha256', $result['Username']);
                $sessEmail = hash('sha256', $Email);
                $combination = $sessUsername.$sessEmail;
                
                // Identify waktunya
                date_default_timezone_set('Asia/Pontianak');
                $date = date("Y/m/d H:i", time());

                // Set sessionnya
                $_SESSION['Metal'] = hash('sha256',$result['Username']);
                $_SESSION['Bullet'] = $Email;
                $_SESSION['Attribute'] = hash('sha512','Admin'); // Session Pengecoh

                // Generate random number untuk mencocokkan Session di DB
                $number = numberChecker(rand(0,177));
                $_SESSION['Identifier'] = $number;

                // Simpan ke DB
                query("INSERT INTO sessionss VALUES ('','Admin','$Username','$Email','$combination','Session','$date',$number)");
            }            
            header('Location: index.php');
            exit;
        } else {
            echo    "<script>
                        alert('Password Salah!');                       
                    </script>";
        }                     
    }
?>
       
<DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" href="../../CSS/page.css">
    </head>

    <body>
        <div class="form">
            <form action="" method="POST">
                <table>
                    <tr>
                        <th> <label for="Email">Email</label> </th>
                        <td> <input type="text" name="Email" id="Email" autocomplete="off" placeholder="Ex. jotaro@pijar.com"> </td>
                    </tr>
                    <tr>
                        <th> <label for="Password">Password</label> </th>
                        <td> <input type="password" name="Password" id="Password"> </td>
                    </tr>
                    <tr>
                        <th> <input type="checkbox" name="Remember" id="Remember"> </th>
                        <td> <label for="Remember">Remember Me</label> </td>
                    </tr>
                    <tr>
                        <th> </th>
                        <td> <button type="submit" name="login">Login</button> </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>Belum punya akun? <a href="register.php">Register</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>