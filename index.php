<?php
include 'config.php';

// Get statistics
$guru_count = $conn->query("SELECT COUNT(*) as total FROM guru")->fetch_assoc()['total'];
$siswa_count = $conn->query("SELECT COUNT(*) as total FROM siswa")->fetch_assoc()['total'];
$mapel_count = $conn->query("SELECT COUNT(*) as total FROM mapel")->fetch_assoc()['total'];
$nilai_count = $conn->query("SELECT COUNT(*) as total FROM nilai")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Nilai Sekolah</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Sistem Manajemen Nilai Sekolah</h1>
            <p>Kelola data guru, siswa, dan nilai dengan mudah</p>
        </div>

        <div class="nav">
            <a href="index.php" class="active">Dashboard</a>
            <a href="?page=siswa">Kelola Siswa</a>
            <a href="?page=guru">Kelola Guru</a>
            <a href="?page=nilai">Input Nilai</a>
            <a href="?page=laporan">Laporan</a>
        </div>

        <div class="content">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
            
            if ($page == 'siswa') {
                include 'pages/siswa.php';
            } elseif ($page == 'guru') {
                include 'pages/guru.php';
            } elseif ($page == 'nilai') {
                include 'pages/nilai.php';
            } elseif ($page == 'laporan') {
                include 'pages/laporan.php';
            } else {
                // Dashboard
                echo '<h2>Dashboard Utama</h2>';
                echo '<div class="stats">';
                echo '<div class="stat-card"><h3>' . $siswa_count . '</h3><p>Total Siswa</p></div>';
                echo '<div class="stat-card"><h3>' . $guru_count . '</h3><p>Total Guru</p></div>';
                echo '<div class="stat-card"><h3>' . $mapel_count . '</h3><p>Total Mapel</p></div>';
                echo '<div class="stat-card"><h3>' . $nilai_count . '</h3><p>Data Nilai</p></div>';
                echo '</div>';
                echo '<div class="alert alert-info">Selamat datang di Sistem Manajemen Nilai Sekolah. Gunakan menu navigasi untuk mengelola data.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
