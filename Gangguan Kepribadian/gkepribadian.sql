-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 05:46 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gkepribadian`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ID` int(11) NOT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Gambar` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `Email`, `Username`, `Password`, `Gambar`) VALUES
(1, 'luffy@mugiwara.com', 'Luffy', '$2y$10$ielUvy/0r9M1VOhlZPjZLeXsvaELnoLwrCGKaT8BM1.36zpENb6ne', 'Luffy37.jpg'),
(2, 'budi@gmail.com', 'Budi', '$2y$10$0TA6Pq1iecWjJZIDQP.P/.BfYV4SK9AbJQ34Fxbf1aqQe3OdbG7Sy', 'Budi35.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `dgangguan`
--

CREATE TABLE `dgangguan` (
  `ID` int(11) NOT NULL,
  `Kode_Gangguan` varchar(10) DEFAULT NULL,
  `Nama_Gangguan` varchar(50) DEFAULT NULL,
  `Daftar_Gejala` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dgangguan`
--

INSERT INTO `dgangguan` (`ID`, `Kode_Gangguan`, `Nama_Gangguan`, `Daftar_Gejala`) VALUES
(1, 'PrnPD', 'Paranoid Personality Disorder', 'PrnPD1-PrnPD2-PrnPD3-PrnPD5'),
(2, 'ShzPD', 'Schizoid Personality Disorder', 'ShzPD1-ShzPD2-ShzPD4-ShzPD5'),
(3, 'SczPD', 'Schizotypal Personality Disorder', 'SczPD1-SczPD2-SczPD4-SczPD6'),
(4, 'AslPD', 'Antisosial Personality Disorder', 'AslPD4-AslPD5-AslPD6-AslPD7'),
(5, 'BrdPD', 'Borderline Personality Disorder', 'BrdPD5-BrdPD6-BrdPD7-BrdPD8'),
(6, 'HstPD', 'Histrionik Personality Disorder', 'HstPD1-HstPD2-HstPD7-HstPD8'),
(7, 'NcsPD', 'Narcisstic Personality Disorder', 'NcsPD1-NcsPD3-NcsPD6-NcsPD7'),
(8, 'AvdPD', 'Avoidant Personality Disorder', 'AvdPD4-AvdPD5-AvdPD6-AvdPD7'),
(9, 'DptPD', 'Dependant Personality Disorder', 'DptPD1-DptPD6-DptPD7-DptPD8'),
(10, 'ObcPD', 'Obsessive Compulsive Disorder', 'ObcPD2-ObcPD4-ObcPD6-ObcPD8');

-- --------------------------------------------------------

--
-- Table structure for table `dpertanyaan`
--

CREATE TABLE `dpertanyaan` (
  `ID` int(11) NOT NULL,
  `Kode_Gangguan` varchar(10) DEFAULT NULL,
  `Kode_Pertanyaan` varchar(10) DEFAULT NULL,
  `Pertanyaan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dpertanyaan`
--

INSERT INTO `dpertanyaan` (`ID`, `Kode_Gangguan`, `Kode_Pertanyaan`, `Pertanyaan`) VALUES
(1, 'Prnpd', 'Prnpd1', 'Curiga bahwa orang lain akan menyakiti Anda tanpa memiliki alasan yang jelas'),
(2, 'Prnpd', 'Prnpd2', 'Sibuk dengan keraguan yang tidak berdasar mengenai orang lain atau bahkan orang terdekat Anda'),
(3, 'Prnpd', 'Prnpd3', 'Enggan untuk bercerita dengan yang lainnya karena takut bahwa informasi Anda akan disalahgunakan'),
(4, 'Prnpd', 'Prnpd5', 'Kecurigaan Anda tersebut terjadi secara berulang tanpa dasar yang jelas'),
(5, 'ShzPD', 'ShzPD1', 'Tidak tertarik untuk memiliki hubungan yang dekat, termasuk menjadi bagian dari sebuah keluarga'),
(6, 'ShzPD', 'ShzPD2', 'Hampir selalu memilih aktivitas yang menyendiri atau tidak melibatkan orang lain'),
(7, 'ShzPD', 'ShzPD4', 'Anda cuek terhadap pujian maupun kritikan dari orang lain'),
(8, 'ShzPD', 'ShzPD5', 'Menunjukkan emosi yang dingin, afeksi yang datar, atau tidak peduli'),
(9, 'SzlPD', 'SzlPD1', 'Lebih mempercayai pemikiran atau kepercayaan mistis yang bertentangan dengan kebudayaan asli Anda seperti peramal'),
(10, 'SzlPD', 'SzlPD2', 'Memiliki pengalaman perseptual yang tidak biasanya, termasuk ilusi jasmani'),
(11, 'SzlPD', 'SzlPD4', 'Memiliki perilaku atau penampilan yang eksentrik atau aneh'),
(12, 'SzlPD', 'SzlPD6', 'Memiliki kecemasan sosial berlebih yang tidak berkurang '),
(13, 'AslPD', 'AslPD4', 'Mudah marah dan agresif, yang diindikasikan oleh perkelahian atau serangan fisik yang berulang'),
(14, 'AslPD', 'AslPD5', 'Sembrono mengabaikan keamanan dirinya sendiri ataupun orang lain'),
(15, 'AslPD', 'AslPD6', 'Sering mengabaikan tanggung jawab Anda'),
(16, 'AslPD', 'AslPD7', 'Kurangnya penyesalan'),
(17, 'BrdPD', 'BrdPD5', 'Perilaku, gestur, atau ancaman bunuh diri yang berulang; atau perilaku self-mutilation'),
(18, 'BrdPD', 'BrdPD6', 'Memiliki mood yang tidak stabil'),
(19, 'BrdPD', 'BrdPD7', 'Perasaan kekosongan yang kronis'),
(20, 'BrdPD', 'BrdPD8', 'Kesulitan untuk mengendalikan amarah'),
(21, 'HstPD', 'HstPD1', 'Tidak nyaman ketika berada disituasi dimana dirinya tidak menjadi pusat perhatian'),
(22, 'HstPD', 'HstPD2', 'Interaksi dengan yang lain lebih sering dikarakterisasi oleh perilaku menggoda atau perilaku seksual lainnya yang tidak pantas'),
(23, 'HstPD', 'HstPD7', 'Sangat mudah terpengaruh oleh keadaan sekitar'),
(24, 'HstPD', 'HstPD8', 'Memikirkan hubungan yang lebih dekat dengan orang lain dibanding dengan kondisi sesungguhnya'),
(25, 'NcsPD', 'NcsPD1', 'Diri sendiri lebih penting dibanding orang lain'),
(26, 'NcsPD', 'NcsPD3', 'Percaya bahwa dirinya adalah \'spesial\' dan unik'),
(27, 'NcsPD', 'NcsPD6', 'Sering iri terhadap yang lainnya atau percaya bahwa yang lain iri kepada dirinya'),
(28, 'NcsPD', 'NcsPD7', 'Menunjukkan sifat arogan, perilaku atau sifat yang angkuh'),
(29, 'AvdPD', 'AvdPD4', 'Sibuk memikirkan bahwa akan dikritik atau ditolak dalam situasi sosial'),
(30, 'AvdPD', 'AvdPD5', 'Mencegah situasi interpersonal yang baru karena perasaan akan kekurangan'),
(31, 'AvdPD', 'AvdPD6', 'Memandang dirinya tidak kompeten secara sosial,pribadi yang tidak menarik, atau lebih rendah dari yang lainnya.'),
(32, 'AvdPD', 'AvdPD7', 'Enggan untuk mengambil risiko atau untuk mengikuti aktivitas yang baru karena takut bahwa mereka mungkin akan memalukan'),
(33, 'DptPD', 'DptPD1', 'Sulit dalam membuat keputusan setiap harinya tanpa saran/bantuan dari yang lain'),
(34, 'DptPD', 'DptPD6', 'Merasa tidak nyaman atau tak berdaya ketika sendiri '),
(35, 'DptPD', 'DptPD7', 'Berusaha mencari hubungan yang lain sebagai pengganti kasih sayang dan dukungan ketika hubungan dengan orang terdekat berakhir'),
(36, 'DptPD', 'DptPD8', 'Memiliki ketakutan yang tidak realistis bahwa akan ditinggal untuk merawat dirinya sendiri'),
(37, 'ObcPD', 'ObcPD2', 'Menunjukkan perfeksionitas yang menganggu penyelesaian tugas'),
(38, 'ObcPD', 'ObcPD4', 'Terlalu teliti, teliti, dan tidak fleksibel mengenai permasalahan moral atau etika'),
(39, 'ObcPD', 'ObcPD6', 'Enggan untuk melimpahkan tugas atau pekerjaan dengan yang lainnya kecuali mereka mengumpulkannya sesuai dengan cara dia bekerja'),
(40, 'ObcPD', 'ObcPD8', 'Menunjukkan kekakuan dan keras kepala');

-- --------------------------------------------------------

--
-- Table structure for table `penyebab`
--

CREATE TABLE `penyebab` (
  `ID` int(11) NOT NULL,
  `Kode_Gangguan` varchar(10) DEFAULT NULL,
  `Nama_Gangguan` varchar(50) DEFAULT NULL,
  `Penyebab` text DEFAULT NULL,
  `Solusi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyebab`
--

INSERT INTO `penyebab` (`ID`, `Kode_Gangguan`, `Nama_Gangguan`, `Penyebab`, `Solusi`) VALUES
(1, 'ObcPD', ' Obsessive Compulsive Disorder', 'Memiliki kerabat yang menderita OCD, Sebagai akibat dari gangguan mental lain seperti gangguan kecemasa, bipolar, depresi, Peristiwa traumatis, Kepribadian yang terlewat disiplin', 'Psikolog, Psikiater'),
(2, 'PrnPD', 'Paranoid Personality Disorder', 'Trauma psikologis, Stress berat atau tekanan batin, Insomnia berat', 'Psikoterapi, Pemberian obat-obatan, Antipsikosis atipikal, Antipsikosis konvensional'),
(3, 'ShzPD', 'Schizoid Personality Disorder', 'Faktor keturunan, Orang tua yang tidak responsive terhadap kebutuhan emosional anaknya, Kurangnya kasih saying ketika masih kecil', 'Terapi kognitif, Terapi psikodinamik'),
(4, 'SzlPD', 'Schzotypal Personality Disorder', 'Pola asuh masa kecil, Pergaulan social masa kecil, Faktor keturunan', 'Terapi kognitif, Terapi psikodinamik'),
(5, 'AslPD', 'Antisosial Personality Disorder', 'Faktor lingkungan, Memiliki masa kecil yang ditelantarkan, Trauma masa lalu seperti bully, dicuekin', 'Psikolog, Psikiater'),
(6, 'BrdPD', 'Borderline Personality Disorder', 'Lingkungan, Genetic, Kelainan pada otak', 'Terapi kognitif, Terapi psikodinamik, Terapi interpersonal'),
(7, 'HstPD', 'Histrionik Personality Disorder', 'Faktor lingkungan, Faktor keturunan, Gangguan psikologis seperti kurangnya perhatian terhadap anak', 'TFP, SFT'),
(8, 'NcsPD', 'Narcisstic Personality Disorder', 'Pola asuh yang kurang tepat, Lingkungan, Toleransi tekanan mental yang rendah', 'Psikolog, Psikiater'),
(9, 'AvdPD', 'Avoidant Personality Disorder', 'Trauma, Malu atau minder, Takut akan penolakan orang lain terhadap dirinya', 'Psikolog, Psikiater'),
(10, 'DptPD', 'Dependant Personality Disorder', 'Faktor lingkungan social, Pembentukan pola piker yang salah, Trauma, Pola asuh orang tua yang otoriter', 'Psikolog, Psikiater');

-- --------------------------------------------------------

--
-- Table structure for table `sessionss`
--

CREATE TABLE `sessionss` (
  `ID` int(11) NOT NULL,
  `Status` varchar(10) DEFAULT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Session` varchar(255) DEFAULT NULL,
  `Login_Status` varchar(10) DEFAULT NULL,
  `Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Identifier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sessionss`
--

INSERT INTO `sessionss` (`ID`, `Status`, `Username`, `Email`, `Session`, `Login_Status`, `Time`, `Identifier`) VALUES
(1, 'Admin', 'Luffy', 'luffy@mugiwara.com', 'b46e03d8c5e2cd59a947ba4266f611212fbe486cc94a132d120a6fde5ab0dbe6802842bf61cb5c3a4bef22b78f93a904f06591ff2922d6e0e44745892caa31ae', 'Session', '2021-11-29 13:43:00', 33),
(2, 'User', 'Lisa', 'lisa@phyjr.com', '864282b76c39e6748fa8b9accb2953bc89a3ec4f6c5ca1627624d6a58edd56199b48faf10b46edc7251673d3e991f1e60a75ae1191218af0863ada1c4f0ad222', 'Cookie', '2021-11-29 14:52:00', 48),
(3, 'User', 'Lisa', 'lisa@phyjr.com', '864282b76c39e6748fa8b9accb2953bc89a3ec4f6c5ca1627624d6a58edd56199b48faf10b46edc7251673d3e991f1e60a75ae1191218af0863ada1c4f0ad222', 'Cookie', '2021-11-29 15:26:00', 41),
(4, 'Admin', 'Luffy', 'luffy@mugiwara.com', 'b46e03d8c5e2cd59a947ba4266f611212fbe486cc94a132d120a6fde5ab0dbe6802842bf61cb5c3a4bef22b78f93a904f06591ff2922d6e0e44745892caa31ae', 'Cookie', '2021-11-29 16:11:00', 83),
(5, 'User', 'Lisa', 'lisa@phyjr.com', '864282b76c39e6748fa8b9accb2953bc89a3ec4f6c5ca1627624d6a58edd56199b48faf10b46edc7251673d3e991f1e60a75ae1191218af0863ada1c4f0ad222', 'Cookie', '2021-11-29 16:11:00', 146),
(6, 'User', 'Lisa', 'lisa@phyjr.com', '864282b76c39e6748fa8b9accb2953bc89a3ec4f6c5ca1627624d6a58edd56199b48faf10b46edc7251673d3e991f1e60a75ae1191218af0863ada1c4f0ad222', 'Cookie', '2021-11-29 16:35:00', 5),
(7, 'Admin', 'Budi', 'budi@gmail.com', 'c78aa6f52b1f8cac26e4c59f0ffcddfd53884ae8e7fb2522f2176faaa3d3fedd48b02c9e85f934696778e9d1e84e697ca1ea6de02e07fc13173c1f1e98bbc60c', 'Cookie', '2021-11-29 16:39:00', 86);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Gambar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Email`, `Username`, `Password`, `Gambar`) VALUES
(1, 'lisa@phyjr.com', 'Lisa', '$2y$10$rfnClm5Iahje0LT9q2KWw.bz5lExdMEqWEsYpNeFiWx29dk2dVSN6', 'Lisa11.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dgangguan`
--
ALTER TABLE `dgangguan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dpertanyaan`
--
ALTER TABLE `dpertanyaan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `penyebab`
--
ALTER TABLE `penyebab`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sessionss`
--
ALTER TABLE `sessionss`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dgangguan`
--
ALTER TABLE `dgangguan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dpertanyaan`
--
ALTER TABLE `dpertanyaan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `penyebab`
--
ALTER TABLE `penyebab`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sessionss`
--
ALTER TABLE `sessionss`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
