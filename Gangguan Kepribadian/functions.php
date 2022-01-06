<?php 
    $conn = mysqli_connect('localhost','root','','gkepribadian');

    function query($command){ //Query untuk INSERT, UPDATE, DELETE
        global $conn;
        $result = mysqli_query($conn,$command);

        if ( mysqli_affected_rows($conn) <= 0 ) {
            echo mysqli_error($conn);
        }  

        return mysqli_affected_rows($conn);  
    }

    function raw_query($query) { // Query untuk array dalam array, misalnya Select ... Where...
        global $conn;

        $result = mysqli_query($conn,$query);
        return $result; //yang dikembalikan adalah array yang masih perlu di fetch lagi
    }

    function assoc_query($query) { // Query untuk ambil data lsg. Lgkp dgn key = value || Data==1
        global $conn;

        $result = mysqli_query($conn,$query);
        $results = mysqli_fetch_assoc($result);

        return $results; // yang dikembalikan adalah satu data doang
    }

    function rquery($query){ // Sama seperti assoc_query namun disimpan dalam array || Data>1
        global $conn;

        $result = mysqli_query($conn,$query);
        $rows = [];

        while ( $row = mysqli_fetch_assoc($result) ) {
            $rows[] = $row;
        }  
        
        return $rows;  // yang dikembalikan adalah data asosiatif yang dipisahkan oleh masing-masing array
    }

    function Tambah($tablename, $data) {
        global $conn;

        $sql = "INSERT INTO $tablename VALUES($data)";
        $result = query($sql);

        $temp = ""; // Deteksi nama tabelnya
        if ( $tablename == 'dgangguan' ) {
            $temp = 'Gangguan';
        } else if ( $tablename == 'dpertanyaan' ) {
            $temp = 'Pertanyaan';
        } 

        return mysqli_affected_rows($conn);
    }
    
    function Hapus($tablename, $ID) {
        global $conn;

        $sql = "DELETE FROM $tablename WHERE ID=$ID";
        $result = query($sql);

        return mysqli_affected_rows($conn);
    }

    function Show($tablename, $value) {
        global $conn;

        if ( $tablename=='dgangguan' ) {
            $sql = "SELECT * FROM dgangguan 
            WHERE 
            Kode_Gangguan LIKE '%$value%' OR
            Nama_Gangguan LIKE '%$value%' OR
            Daftar_Gejala LIKE '%$value%';";
            $result = raw_query($sql);
        } else {
            $sql = "SELECT * FROM dpertanyaan
            WHERE 
            Kode_Gangguan LIKE '%$value%' OR
            Kode_Pertanyaan LIKE '%$value%' OR
            Pertanyaan LIKE '%$value%';";
            $result = raw_query($sql);
        }
        return $result;
    }

    function ShowAll($tableName) {
        global $conn;

        $sql = "SELECT * FROM $tableName";   
        $result = raw_query($sql);
        
        return $result;
    }

    function Cari($tablename,$target, $value) {
        global $conn;

        $sql = "SELECT * FROM $tablename 
                    WHERE 
                    $target LIKE '%$value%';";
        $result = assoc_query($sql);

        return $result;
    }

    function Ubah($tablename, $data) {
        global $conn;
        
        if ( $tablename == 'dgangguan' ) {
            $sql = "UPDATE $tablename SET 
                        Kode_Gangguan= '$data[Kode_Gangguan]',
                        Nama_Gangguan= '$data[Nama_Gangguan]',
                        Daftar_Gejala= '$data[Daftar_Gejala]'
                    WHERE ID=$data[ID]";
        } else { 
            $sql = "UPDATE $tablename SET 
                        Kode_Gangguan= '$data[Kode_Gangguan]',
                        Kode_Pertanyaan= '$data[Kode_Pertanyaan]',
                        Pertanyaan= '$data[Pertanyaan]'
                    WHERE ID=$data[ID]";
        }

        echo "satusdasffew";
        query($sql);

        return mysqli_affected_rows($conn);
    }

    function Register($tableName,$userData,$userPicture) {
        global $conn;

        $Email = $userData['Email'];
        $Username = $userData['Username'];
        $Password = $userData['Password'];

        $Password = password_hash($userData['Password'], PASSWORD_DEFAULT);

        $Gambar = Upload($tableName,$userPicture);
        if ( !$Gambar ) {
            return false;
        }

        $sql = "INSERT INTO $tableName VALUES('','$Email', '$Username','$Password', '$Gambar')";
        $result = query($sql);



        return mysqli_affected_rows($conn);         
    }

    function Upload($tableName,$userPicture) {
        global $conn;

        $namaFile = $userPicture['namaFile'];
        $tmpDir = $userPicture['tmpDir'];
        $Size = $userPicture['Size'];

        $Error = $userPicture['Error'];
        if ( $Error == 4 ) {
            echo    "<script>
                        alert('Harap Masukkan Gambar Terlebih Dahulu!');
                    </script>";
            return false;
        }

        $ekstensiGambarValid = ['jpg','jpeg','png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar)); 

        if ( !in_array($ekstensiGambar,$ekstensiGambarValid) ) {
            echo    "<script>
                        alert('Harap pake format gambar yang valid ya');
                    </script>";
        }

        if ( $Size>1000000 ) {
            echo    "<script>
                        alert('Gambarnya kebesaran! Kompress dulu bro');
                    </script>";
        }
        
        $pictName = $userPicture['Username'].rand(0,100);
        if ( $tableName==='users' ) {
            $excDirectory = "../User/img/".$pictName.'.'.$ekstensiGambar;
        } else {
            $excDirectory = "../Admin/img/".$pictName.'.'.$ekstensiGambar;
        }
        move_uploaded_file($tmpDir, $excDirectory);

        $dbPictName = $pictName.'.'.$ekstensiGambar;
        
        return $dbPictName;
    }

    function Login($tableName,$data) {
        global $conn;

        $Email = $data['Email'];
        $Password = $data['Password'];

        $sql = "SELECT * FROM $tableName WHERE Email = '$Email';";
        $numrows = mysqli_query($conn, $sql);
        $result =  raw_query($sql); //Ambil data dari DB
        $results = mysqli_fetch_assoc($result);

        if ( mysqli_num_rows($numrows) === 1) {
            
            
            if ( password_verify($Password,$results['Password']) ) {
                
                return true;
            } else {
                
                return false;
            }
            
        } else {
            echo    "<script>
                        alert('Apakah Anda sudah register? Silahkan periksa kembali email Anda!');                       
                    </script>";
            return false;
        }
 
    }
 
    function cariS($keyword,$awalData,$jumlahDataperHalaman, $SelecteDB) {
        if ( !empty($keyword)) {
            if ( $SelecteDB == 'dgangguan' ) {
                $query = "SELECT * FROM $SelecteDB
                WHERE 
                Kode_Gangguan LIKE '%$keyword%' OR
                Nama_Gangguan LIKE '%$keyword%' OR
                Daftar_Gejala LIKE '%$keyword%' LIMIT $awalData,$jumlahDataperHalaman";
            } else {
                $query = "SELECT * FROM $SelecteDB
                WHERE 
                Kode_Gangguan LIKE '%$keyword%' OR
                Kode_Pertanyaan LIKE '%$keyword%' OR
                Pertanyaan LIKE '%$keyword%' LIMIT $awalData,$jumlahDataperHalaman";
            }

        } else {
            $query = "SELECT * FROM $SelecteDB
                    LIMIT $awalData,$jumlahDataperHalaman";
        }
        
        
        return raw_query($query);
    }  

    function cookieLogin($Status, $Bullet, $LoginStatus, $Identifier) {       
        $sql = "SELECT * FROM sessionss WHERE Email = '$Bullet' AND Identifier='$Identifier'";
        $result = assoc_query($sql);
        
        $cookieUsername = hash('sha256', $result['Username']);
        $cookieEmail = hash('sha256', $Bullet);
        $combination = $cookieUsername.$cookieEmail;
        
        if ( $result['Session'] === $combination && $result['Identifier'] == $Identifier && $result['Status'] == $Status ) {       // Buatlah keamanan berlapis
            if ( $result['Login_Status'] === $LoginStatus && $result['Identifier'] === $Identifier) {
                if ( !isset($_SESSION['Login']) ) {
                    echo    "<script>
                                alert('Sesi Log In Habis');
                                document.location.href = 'logout.php';
                            </script>";
                } //else {
                //     echo    "<script>
                //                 alert('Log In Cookie Berhasil');
                //             </script>";
                // }
            } else {
                echo    "<script>
                            alert('Log Innya jangan curang ya');
                            document.location.href = 'logout.php';
                        </script>";
            }                        
        } else {
            echo    "<script>
                        alert('Eitss, nggak boleh nakal ya');
                        document.location.href = 'logout.php';
                    </script>";
        } 
    }

    function sessionLogin($Status, $Bullet, $LoginStatus, $Identifier) {       
        $sql = "SELECT * FROM sessionss WHERE Email = '$Bullet' AND Identifier='$Identifier'";
        $result = assoc_query($sql);
    
        $sessionUsername = hash('sha256', $result['Username']);
        $sessionEmail = hash('sha256', $Bullet);
        $combination = $sessionUsername.$sessionEmail;
        
        if ( $result['Session'] == $combination && $result['Identifier'] == $Identifier && $result['Status'] == $Status) {       // Buatlah keamanan berlapis
            if ( $result['Login_Status'] === $LoginStatus ) {
                if ( !isset($_SESSION['Login']) ) {
                    echo    "<script>
                                alert('Sesi Log In Habis');
                                document.location.href = 'login.php';
                            </script>";
                } //else {
                //     echo    "<script>
                //                 alert('Log In Session Berhasil');
                //             </script>";
                // }
            } else {
                echo    "<script>
                            alert('Log Innya jangan curang ya');
                            document.location.href = 'logout.php';
                        </script>";
            } 
        } else {
            echo    "<script>
                        alert('Eitss, nggak boleh nakal ya');
                        document.location.href = 'logout.php';
                    </script>";
        } 
    }

    function numberChecker($target) {
        $sql = "SELECT Identifier FROM sessionss";
        $result = raw_query($sql);
        
        $temps = [];
        foreach ( $result as $hasil ) {
            foreach ( $hasil as $hsl ) {
                $temps[] = $hsl;
            }
        }
           
        if ( in_array($target, $temps) ) {   
            $temp = rand(0,177);       
            return numberChecker($temp);
        } else {
            return $target;
        }      
    }

    function jawabanChecker($jawabanUser) {
        global $conn;

        $sql = "SELECT * FROM dgangguan WHERE Daftar_Gejala LIKE '%$jawabanUser%'";
        $result = raw_query($sql);

        $results = [];
        while ( $row = mysqli_fetch_all($result)) {
            $results[] = $row;
        } 
        
    }

    // Array jangan diimplode, biarin mentah aja -> ['x','xx','xxy']
    function analysis($jawabanMentah) {     //Bentuk array acak yg perlu diurutkan 
        // Ada jawaban User baru mis. ["SchPDx,SczPDx,PrnPDx"] ->
        
        sort($jawabanMentah);       //Urutkan jawaban User
        $sortedArray = [];            //Tempat penyimpanan jawaban terurut
        foreach ($jawabanMentah as $jM) {
            $sortedArray[] = $jM;
        }

        // Array untuk simpan jawaban user yg dipisah berdasarkan 3 huruf pertama
        $Prn = [];
        $Shz = [];
        $Szl = [];
        $Asl = [];
        $Brd = [];
        $Hst = [];
        $Ncs = [];
        $Avd = [];
        $Dpt = [];
        $Obc = [];

        foreach ($sortedArray as $string) {   // Untuk setiap jawaban yang sudah diurutkan
            // foreach ($string as $char) {
                $initial = $string[0].$string[1].$string[2];  // Identifikasi berdasarkan 3 huruf pertama

                switch ($initial) {
                    case "Prn":     // Paranoid     1
                        $Prn[] = $string;
                        break;
        
                    case "Shz":     // Schizoid     2
                        $Shz[] = $string;
                        break;
        
                    case "Szl":     // Schizotypal  3
                        $Szl[] = $string;
                        break;
        
                    case "Asl":     // Antisosial   4
                        $Asl[] = $string;
                        break;
        
                    case "Brd":     // Borderline   5
                        $Brd[] = $string;
                        break;
        
                    case "Hst":     // Histrionik   6
                        $Hst[] = $string;
                        break;
        
                    case "Ncs":     // Narcistic    7
                        $Ncs[] = $string;
                        break;
        
                    case "Avd":     // Avoidant     8
                        $Avd[] = $string;
                        break;
        
                    case "Dpt":     // Dependant    9
                        $Dpt[] = $string;
                        break;
        
                    case "Obc":     // OCD          10
                        $Obc[] = $string;
                        break;   
                }
            // }
        }

        // Analisis tingkat kemiripan lalu simpan dalam array dgn KodeGangguan sebagai "key" dan Persentase sebagai "value"
        $hasilAkhir = [];
        if ( !empty($Prn) ) {
            $hslPrn = similarityChecker($Prn);
            $hasilAkhir[] = ["PrnPD" => $hslPrn];

        } if ( !empty($Shz) ) {
            $hslShz = similarityChecker($Shz);
            $hasilAkhir[] = ["ShzPD" => $hslShz];

        } if ( !empty($Szl) ) {
            $hslSzl = similarityChecker($Szl);
            $hasilAkhir[] = ["SzlPD" => $hslSzl];

        } if ( !empty($Asl) ) {
            $hslAsl = similarityChecker($Asl);
            $hasilAkhir[] = ["AslPD" => $hslAsl];
                            
        } if ( !empty($Brd) ) {
            $hslBrd = similarityChecker($Brd);
            $hasilAkhir[] = ["BrdPD" => $hslBrd];

        } if ( !empty($Hst) ) {
            $hslHst = similarityChecker($Hst);
            $hasilAkhir[] = ["HstPD" => $hslHst];
            
        } if ( !empty($Ncs) ) {
            $hslNcs = similarityChecker($Ncs);
            $hasilAkhir[] = ["NcsPD" => $hslNcs];

        } if ( !empty($Avd) ) {
            $hslAvd = similarityChecker($Avd);
            $hasilAkhir[] = ["AvdPD" => $hslAvd];
            
        } if ( !empty($Dpt) ) {
            $hslDpt = similarityChecker($Dpt);
            $hasilAkhir[] = ["DptPD" => $hslDpt];

        } if ( !empty($Obc) ) {
            $hslObc = similarityChecker($Obc);  // Array jadi masukan
            $hasilAkhir[] = ["ObcPD" => $hslObc];

        }

        // $hasilAkhir merupakan array dalam array -> Ambil data didalamnya dulu
        $hasilAkhir2 = [];
        if ( !empty($hasilAkhir) ) {          
            foreach ($hasilAkhir as $hslAkh) {             
                foreach ($hslAkh as $hsl) {
                    $key = array_search($hsl, $hslAkh);
                    $hasilAkhir2["$key"] = $hsl;
                }               
            }       
        }
        
        // Ketika sudah berhasil didapatkan persentase similaritasnya
        // Cari persentase terbesar dari array
        // Cari persentase terbesar -> Bandingkan hslAkhir dgn persentase terbesar
        // if ( !empty($hasilAkhir2) ) {
        //     $final = maxPerc($hasilAkhir2);
        // }
        
        return $hasilAkhir2;
    }

    function similarityChecker($targetArray) {
        sort($targetArray);     // Urutkann dulu

        $temp = [];             // Siapkan tempat untuk penyimpanan targetArray terurut
        foreach ($targetArray as $tA) {
            $temp[] = $tA;
        }

        $jawabanUser = implode('-', $targetArray);      // Join array dengan '-'

        $dgangguanResult = rquery("SELECT * FROM dgangguan");   // Ambil Daftar_Gejala dari DB

        $temps = [];
        $percentage = [];
        foreach ( $dgangguanResult as $gangguan ) {           
            similar_text($gangguan['Daftar_Gejala'],$jawabanUser,$perc);    // Bandingkan jawaban user dengan data di DB
            $temps[] = round($perc,2);      
            $percentage[] = ["$gangguan[Kode_Gangguan]" => $perc];            
        }
        
        $_COOKIE['Percentage'] = $percentage;
        // return similaritas terbesar
        $hasilBanding = max($temps);
        return $hasilBanding;
    }

    function cariPenyebab($data) {       // untuk cari penyebab 
        $keys = array_keys($data);   // Buat nyimpan key yg dipisahkan dari value
        
        $temps = [];        // Buat nyimpan Key => Penyebab
        foreach ($keys as $k) {            
            $result = assoc_query("SELECT * FROM penyebab WHERE Kode_Gangguan='$k'");          
            $temps[] = ["$result[Nama_Gangguan]" => $result['Penyebab']];           
        }
        
        $tempz = [];    // Buat ambil data dari array dalam array
        foreach ($temps as $element) {
            foreach ($element as $elmt) {
                $key = key($element);
                $tempz[$key] = $elmt;
            }
        }
        return $tempz;
    }

    function cariSolusi($data) {       // untuk cari penyebab 
        $keys = array_keys($data);   // Buat nyimpan key yg dipisahkan dari value

        $temps = [];        // Buat nyimpan Key => Penyebab
        foreach ($keys as $k) {
            $result = assoc_query("SELECT * FROM penyebab WHERE Kode_Gangguan='$k'");
            $temps[] = ["$result[Nama_Gangguan]" => $result['Solusi']];
        }
    
        $tempz = [];    // Buat ambil data dari array dalam array
        foreach ($temps as $element) {
            foreach ($element as $elmt) {
                $key = key($element);
                $tempz[$key] = $elmt;
            }
        }
        return $tempz;
    }

    // function maxPerc($percArray) {
    //     // Cari persentase terbesar -> 
    //     $max = 40;

    //     // Jika terdapat persentase >= 70
    //     $temp = [];
    //     foreach($percArray as $prcArr) {
    //         if ($prcArr >= $max) {
    //             $key = array_search($prcArr, $percArray);
    //             $temp[] = ["$key" => $prcArr];
    //             var_dump($temp);
                
    //         }
    //     }
    //     var_dump($percArray);
    //     exit;
    //     return $temp;
    // }
?>

