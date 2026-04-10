<?php
// Handle delete nilai
if (isset($_GET['delete_nilai'])) {
    $id = intval($_GET['delete_nilai']);
    if ($conn->query("DELETE FROM nilai WHERE id = $id")) {
        echo '<div class="alert alert-success">Nilai berhasil dihapus!</div>';
    }
}

// Handle add/edit nilai
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_nilai'])) {
    $siswa_id = intval($_POST['siswa_id']);
    $mapel_id = intval($_POST['mapel_id']);
    $guru_id = intval($_POST['guru_id']);
    $nilai = intval($_POST['nilai']);
    
    if (isset($_POST['nilai_id']) && $_POST['nilai_id'] != '') {
        $id = intval($_POST['nilai_id']);
        $sql = "UPDATE nilai SET siswa_id=$siswa_id, mapel_id=$mapel_id, guru_id=$guru_id, nilai=$nilai WHERE id=$id";
        echo '<div class="alert alert-success">Nilai berhasil diupdate!</div>';
    } else {
        $sql = "INSERT INTO nilai (siswa_id, mapel_id, guru_id, nilai) VALUES ($siswa_id, $mapel_id, $guru_id, $nilai)";
        echo '<div class="alert alert-success">Nilai berhasil ditambahkan!</div>';
    }
    $conn->query($sql);
}

// Get nilai data
$edit_nilai = null;
if (isset($_GET['edit_nilai'])) {
    $id = intval($_GET['edit_nilai']);
    $edit_nilai = $conn->query("SELECT * FROM nilai WHERE id = $id")->fetch_assoc();
}

// Get list siswa, mapel, guru
$siswa_result = $conn->query("SELECT * FROM siswa ORDER BY nama ASC");
$mapel_result = $conn->query("SELECT * FROM mapel ORDER BY mapel ASC");
$guru_result = $conn->query("SELECT * FROM guru ORDER BY nama ASC");
?>

<h2>Input Nilai Siswa</h2>

<form method="POST">
    <input type="hidden" name="add_nilai" value="1">
    <input type="hidden" name="nilai_id" value="<?php echo $edit_nilai ? $edit_nilai['id'] : ''; ?>">
    
    <div class="form-row">
        <div class="form-group">
            <label>Pilih Siswa</label>
            <select name="siswa_id" required>
                <option value="">-- Pilih Siswa --</option>
                <?php 
                $siswa_result = $conn->query("SELECT * FROM siswa ORDER BY nama ASC");
                while ($siswa = $siswa_result->fetch_assoc()): 
                ?>
                    <option value="<?php echo $siswa['id']; ?>" <?php echo ($edit_nilai && $edit_nilai['siswa_id'] == $siswa['id']) ? 'selected' : ''; ?>>
                        <?php echo $siswa['nama']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Pilih Mata Pelajaran</label>
            <select name="mapel_id" required>
                <option value="">-- Pilih Mapel --</option>
                <?php 
                $mapel_result = $conn->query("SELECT * FROM mapel ORDER BY mapel ASC");
                while ($mapel = $mapel_result->fetch_assoc()): 
                ?>
                    <option value="<?php echo $mapel['id']; ?>" <?php echo ($edit_nilai && $edit_nilai['mapel_id'] == $mapel['id']) ? 'selected' : ''; ?>>
                        <?php echo $mapel['mapel']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Pilih Guru Pengajar</label>
            <select name="guru_id" required>
                <option value="">-- Pilih Guru --</option>
                <?php 
                $guru_result = $conn->query("SELECT * FROM guru ORDER BY nama ASC");
                while ($guru = $guru_result->fetch_assoc()): 
                ?>
                    <option value="<?php echo $guru['id']; ?>" <?php echo ($edit_nilai && $edit_nilai['guru_id'] == $guru['id']) ? 'selected' : ''; ?>>
                        <?php echo $guru['nama']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Nilai (0-100)</label>
            <input type="number" name="nilai" min="0" max="100" required value="<?php echo $edit_nilai ? $edit_nilai['nilai'] : ''; ?>">
        </div>
    </div>

    <button type="submit" class="btn btn-success">
        <?php echo $edit_nilai ? '✏️ Update Nilai' : '➕ Tambah Nilai'; ?>
    </button>
    <?php if ($edit_nilai): ?>
        <a href="?page=nilai" class="btn">❌ Batal Edit</a>
    <?php endif; ?>
</form>

<h3>Daftar Nilai</h3>
<?php
$nilai_result = $conn->query("
    SELECT n.*, s.nama as siswa_nama, m.mapel, g.nama as guru_nama 
    FROM nilai n 
    JOIN siswa s ON n.siswa_id = s.id 
    JOIN mapel m ON n.mapel_id = m.id 
    JOIN guru g ON n.guru_id = g.id 
    ORDER BY s.nama, m.mapel
");
if ($nilai_result->num_rows > 0):
?>
    <table class="table">
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($nilai = $nilai_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $nilai['siswa_nama']; ?></td>
                    <td><?php echo $nilai['mapel']; ?></td>
                    <td><?php echo $nilai['guru_nama']; ?></td>
                    <td><?php echo $nilai['nilai']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="?page=nilai&edit_nilai=<?php echo $nilai['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?page=nilai&delete_nilai=<?php echo $nilai['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="center">Belum ada data nilai</div>
<?php endif; ?>
