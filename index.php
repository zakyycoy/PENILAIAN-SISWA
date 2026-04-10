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
            <a href="?page=siswa">👥 Siswa</a>
            <a href="?page=guru">👨‍🏫 Guru</a>
            <a href="?page=kelas">🏫 Kelas</a>
            <a href="?page=mapel">📖 Mapel</a>
            <a href="?page=nilai">📊 Nilai</a>
            <a href="?page=guru_kelas">🔗 Guru-Kelas</a>
            <a href="?page=guru_mapel">🔗 Guru-Mapel</a>
            <a href="?page=laporan">📈 Laporan</a>
        </div>

        <div class="content">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
            
            switch($page) {
                case 'siswa':
                    include 'pages/siswa.php';
                    break;
                case 'guru':
                    include 'pages/guru.php';
                    break;
                case 'kelas':
                    include 'pages/kelas.php';
                    break;
                case 'mapel':
                    include 'pages/mapel.php';
                    break;
                case 'nilai':
                    include 'pages/nilai.php';
                    break;
                case 'guru_kelas':
                    include 'pages/guru_kelas.php';
                    break;
                case 'guru_mapel':
                    include 'pages/guru_mapel.php';
                    break;
                case 'laporan':
                    include 'pages/laporan.php';
                    break;
                default:
                    // Dashboard
                    $kelas_count = $conn->query("SELECT COUNT(*) as total FROM kelas")->fetch_assoc()['total'];
                    echo '<h2>📊 Dashboard Utama</h2>';
                    echo '<div class="stats">';
                    echo '<div class="stat-card"><h3>' . $siswa_count . '</h3><p>Total Siswa</p></div>';
                    echo '<div class="stat-card"><h3>' . $guru_count . '</h3><p>Total Guru</p></div>';
                    echo '<div class="stat-card"><h3>' . $kelas_count . '</h3><p>Total Kelas</p></div>';
                    echo '<div class="stat-card"><h3>' . $mapel_count . '</h3><p>Total Mapel</p></div>';
                    echo '<div class="stat-card"><h3>' . $nilai_count . '</h3><p>Data Nilai</p></div>';
                    echo '</div>';
                    echo '<div class="alert alert-info">✓ Sistem Manajemen Nilai Sekolah siap digunakan. Gunakan menu navigasi untuk mengelola data.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
