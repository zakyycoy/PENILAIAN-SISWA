<?php
// Get statistics
$siswa_count = $conn->query("SELECT COUNT(*) as total FROM siswa")->fetch_assoc()['total'];
$guru_count = $conn->query("SELECT COUNT(*) as total FROM guru")->fetch_assoc()['total'];
$mapel_count = $conn->query("SELECT COUNT(*) as total FROM mapel")->fetch_assoc()['total'];
$nilai_count = $conn->query("SELECT COUNT(*) as total FROM nilai")->fetch_assoc()['total'];

// Get average nilai per siswa
$rata_hasil = $conn->query("
    SELECT 
        s.nama, 
        ROUND(AVG(n.nilai), 2) as rata_rata,
        k.kelas
    FROM siswa s 
    LEFT JOIN nilai n ON s.id = n.siswa_id 
    LEFT JOIN kelas k ON s.kelas_id = k.id
    GROUP BY s.id, s.nama, k.kelas
    ORDER BY s.nama ASC
");

// Get nilai per mata pelajaran
$mapel_hasil = $conn->query("
    SELECT 
        m.mapel,
        COUNT(n.id) as jumlah_nilai,
        ROUND(AVG(n.nilai), 2) as rata_rata
    FROM mapel m
    LEFT JOIN nilai n ON m.id = n.mapel_id
    GROUP BY m.id, m.mapel
    ORDER BY m.mapel ASC
");
?>

<h2>Laporan & Statistik</h2>

<div class="stats">
    <div class="stat-card">
        <h3><?php echo $siswa_count; ?></h3>
        <p>Total Siswa</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $guru_count; ?></h3>
        <p>Total Guru</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $mapel_count; ?></h3>
        <p>Total Mapel</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $nilai_count; ?></h3>
        <p>Data Nilai</p>
    </div>
</div>

<h3>Rata-rata Nilai Per Siswa</h3>
<?php if ($rata_hasil->num_rows > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Rata-rata Nilai</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $rata_hasil->fetch_assoc()): 
                $nilai = $row['rata_rata'];
                if ($nilai >= 85) $grade = 'A';
                elseif ($nilai >= 70) $grade = 'B';
                elseif ($nilai >= 60) $grade = 'C';
                elseif ($nilai >= 50) $grade = 'D';
                else $grade = 'E';
            ?>
                <tr>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['kelas']; ?></td>
                    <td><?php echo $row['rata_rata'] ? $row['rata_rata'] : '-'; ?></td>
                    <td><?php echo $row['rata_rata'] ? $grade : '-'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="center">Belum ada data</div>
<?php endif; ?>

<h3>Statistik Per Mata Pelajaran</h3>
<?php if ($mapel_hasil->num_rows > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Jumlah Nilai</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $mapel_hasil->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['mapel']; ?></td>
                    <td><?php echo $row['jumlah_nilai']; ?></td>
                    <td><?php echo $row['rata_rata'] ? $row['rata_rata'] : '-'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="center">Belum ada data</div>
<?php endif; ?>

<h3>Nilai Tertinggi per Mata Pelajaran</h3>
<?php
$top_nilai = $conn->query("
    SELECT 
        m.mapel,
        s.nama as siswa,
        n.nilai,
        g.nama as guru
    FROM nilai n
    JOIN mapel m ON n.mapel_id = m.id
    JOIN siswa s ON n.siswa_id = s.id
    JOIN guru g ON n.guru_id = g.id
    WHERE n.nilai = (
        SELECT MAX(nilai) FROM nilai WHERE mapel_id = m.id
    )
    ORDER BY m.mapel, n.nilai DESC
");

if ($top_nilai->num_rows > 0):
?>
    <table class="table">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Siswa</th>
                <th>Nilai</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $top_nilai->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['mapel']; ?></td>
                    <td><?php echo $row['siswa']; ?></td>
                    <td><?php echo $row['nilai']; ?></td>
                    <td><?php echo $row['guru']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="center">Belum ada data</div>
<?php endif; ?>
