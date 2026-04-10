<?php
// Handle delete guru
if (isset($_GET['delete_guru'])) {
    $id = intval($_GET['delete_guru']);
    $conn->query("DELETE FROM nilai WHERE guru_id = $id");
    $conn->query("DELETE FROM guru_kelas WHERE guru_id = $id");
    $conn->query("DELETE FROM guru_mapel WHERE guru_id = $id");
    if ($conn->query("DELETE FROM guru WHERE id = $id")) {
        echo '<div class="alert alert-success">Guru berhasil dihapus!</div>';
    }
}

// Handle add/edit guru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_guru'])) {
    $nip = $conn->real_escape_string($_POST['nip']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $jk = $conn->real_escape_string($_POST['jk']);
    $tempat_lahir = $conn->real_escape_string($_POST['tempat_lahir']);
    $tanggal_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
    $telepon = $conn->real_escape_string($_POST['telepon']);
    
    if (isset($_POST['guru_id']) && $_POST['guru_id'] != '') {
        $id = intval($_POST['guru_id']);
        $sql = "UPDATE guru SET nip='$nip', nama='$nama', jk='$jk', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', telepon='$telepon' WHERE id=$id";
        echo '<div class="alert alert-success">Guru berhasil diupdate!</div>';
    } else {
        $sql = "INSERT INTO guru (nip, nama, jk, tempat_lahir, tanggal_lahir, telepon) VALUES ('$nip', '$nama', '$jk', '$tempat_lahir', '$tanggal_lahir', '$telepon')";
        echo '<div class="alert alert-success">Guru berhasil ditambahkan!</div>';
    }
    $conn->query($sql);
}

// Get guru data
$edit_guru = null;
if (isset($_GET['edit_guru'])) {
    $id = intval($_GET['edit_guru']);
    $edit_guru = $conn->query("SELECT * FROM guru WHERE id = $id")->fetch_assoc();
}
?>

<h2>Kelola Guru</h2>

<form method="POST">
    <input type="hidden" name="add_guru" value="1">
    <input type="hidden" name="guru_id" value="<?php echo $edit_guru ? $edit_guru['id'] : ''; ?>">
    
    <div class="form-row">
        <div class="form-group">
            <label>Nomor Induk Pegawai (NIP)</label>
            <input type="text" name="nip" value="<?php echo $edit_guru ? $edit_guru['nip'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Nama Guru</label>
            <input type="text" name="nama" required value="<?php echo $edit_guru ? $edit_guru['nama'] : ''; ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" required>
                <option value="">-- Pilih --</option>
                <option value="L" <?php echo ($edit_guru && $edit_guru['jk'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="P" <?php echo ($edit_guru && $edit_guru['jk'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="<?php echo $edit_guru ? $edit_guru['tempat_lahir'] : ''; ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="<?php echo $edit_guru ? $edit_guru['tanggal_lahir'] : ''; ?>">
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" name="telepon" value="<?php echo $edit_guru ? $edit_guru['telepon'] : ''; ?>">
        </div>
    </div>

    <button type="submit" class="btn btn-success">
        <?php echo $edit_guru ? '✏️ Update Guru' : '➕ Tambah Guru'; ?>
    </button>
    <?php if ($edit_guru): ?>
        <a href="?page=guru" class="btn">❌ Batal Edit</a>
    <?php endif; ?>
</form>

<h3>Daftar Guru</h3>
<?php
$guru_result = $conn->query("SELECT * FROM guru ORDER BY nama ASC");
if ($guru_result->num_rows > 0):
?>
    <table class="table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($guru = $guru_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $guru['nip']; ?></td>
                    <td><?php echo $guru['nama']; ?></td>
                    <td><?php echo $guru['jk'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                    <td><?php echo $guru['tempat_lahir']; ?></td>
                    <td><?php echo $guru['tanggal_lahir']; ?></td>
                    <td><?php echo $guru['telepon']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="?page=guru&edit_guru=<?php echo $guru['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?page=guru&delete_guru=<?php echo $guru['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="center">Belum ada data guru</div>
<?php endif; ?>
