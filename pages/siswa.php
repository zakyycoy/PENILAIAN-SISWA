<?php
// Handle delete siswa
if (isset($_GET['delete_siswa'])) {
    $id = intval($_GET['delete_siswa']);
    $conn->query("DELETE FROM nilai WHERE siswa_id = $id");
    if ($conn->query("DELETE FROM siswa WHERE id = $id")) {
        echo '<div class="alert alert-success">Siswa berhasil dihapus!</div>';
    }
}

// Handle add/edit siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_siswa'])) {
    $nis = $conn->real_escape_string($_POST['nis']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $jk = $conn->real_escape_string($_POST['jk']);
    $tempat_lahir = $conn->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
    $kelas_id = intval($_POST['kelas_id']);
    
    if (isset($_POST['siswa_id']) && $_POST['siswa_id'] != '') {
        $id = intval($_POST['siswa_id']);
        $sql = "UPDATE siswa SET nis='$nis', nama='$nama', jk='$jk', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', kelas_id=$kelas_id WHERE id=$id";
        echo '<div class="alert alert-success">Siswa berhasil diupdate!</div>';
    } else {
        $sql = "INSERT INTO siswa (nis, nama, jk, tempat_lahir, tanggal_lahir, kelas_id) VALUES ('$nis', '$nama', '$jk', '$tempat_lahir', '$tanggal_lahir', $kelas_id)";
        echo '<div class="alert alert-success">Siswa berhasil ditambahkan!</div>';
    }
    $conn->query($sql);
}

// Get siswa data
$edit_siswa = null;
if (isset($_GET['edit_siswa'])) {
    $id = intval($_GET['edit_siswa']);
    $edit_siswa = $conn->query("SELECT * FROM siswa WHERE id = $id")->fetch_assoc();
}

// Get list kelas
$kelas_result = $conn->query("SELECT * FROM kelas ORDER BY kelas ASC");
?>

<h2>Kelola Siswa</h2>

<form method="POST">
    <input type="hidden" name="add_siswa" value="1">
    <input type="hidden" name="siswa_id" value="<?php echo $edit_siswa ? $edit_siswa['id'] : ''; ?>">
    
    <div class="form-row">
        <div class="form-group">
            <label>Nomor Induk Siswa (NIS)</label>
            <input type="text" name="nis" required value="<?php echo $edit_siswa ? $edit_siswa['nis'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" name="nama" required value="<?php echo $edit_siswa ? $edit_siswa['nama'] : ''; ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" required>
                <option value="">-- Pilih --</option>
                <option value="L" <?php echo ($edit_siswa && $edit_siswa['jk'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?php echo ($edit_siswa && $edit_siswa['jk'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="<?php echo $edit_siswa ? $edit_siswa['tempat_lahir'] : ''; ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="<?php echo $edit_siswa ? $edit_siswa['tanggal_lahir'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" required>
                <option value="">-- Pilih Kelas --</option>
                <?php while ($kelas = $kelas_result->fetch_assoc()): ?>
                    <option value="<?php echo $kelas['id']; ?>" <?php echo ($edit_siswa && $edit_siswa['kelas_id'] == $kelas['id']) ? 'selected' : ''; ?>>
                        <?php echo $kelas['kelas']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-success">
        <?php echo $edit_siswa ? '✏️ Update Siswa' : '➕ Tambah Siswa'; ?>
    </button>
    <?php if ($edit_siswa): ?>
        <a href="?page=siswa" class="btn">❌ Batal Edit</a>
    <?php endif; ?>
</form>

<h3>Daftar Siswa</h3>
<?php
$siswa_result = $conn->query("SELECT s.*, k.kelas FROM siswa s LEFT JOIN kelas k ON s.kelas_id = k.id ORDER BY s.nama ASC");
if ($siswa_result->num_rows > 0):
?>
    <table class="table">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($siswa = $siswa_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $siswa['nis']; ?></td>
                    <td><?php echo $siswa['nama']; ?></td>
                    <td><?php echo $siswa['jk'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                    <td><?php echo $siswa['tempat_lahir']; ?></td>
                    <td><?php echo $siswa['tanggal_lahir']; ?></td>
                    <td><?php echo $siswa['kelas']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="?page=siswa&edit_siswa=<?php echo $siswa['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?page=siswa&delete_siswa=<?php echo $siswa['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="center">Belum ada data siswa</div>
<?php endif; ?>
