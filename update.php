<?php
require 'config/config.php';
$page_title = 'Edit Produk';
require 'includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id || !ctype_digit($id)) {
    echo '<div class="message error">ID tidak valid. <a href="read.php">Kembali</a></div>';
    require 'includes/footer.php';
    exit;
}

$sql = 'SELECT * FROM produk WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute([':id'=>$id]);
$row = $stmt->fetch();
if (!$row) {
    echo '<div class="message error">Produk tidak ditemukan. <a href="read.php">Kembali</a></div>';
    require 'includes/footer.php';
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_produk'] ?? '');
    $merek = trim($_POST['merek'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $stok = trim($_POST['stok'] ?? '');

    if ($nama === '') $errors[] = 'Nama produk wajib diisi.';
    if ($merek === '') $errors[] = 'Merek wajib diisi.';
    if ($harga === '' || !ctype_digit($harga)) $errors[] = 'Harga wajib diisi dengan angka.';
    if ($stok === '' || !ctype_digit($stok)) $errors[] = 'Stok wajib diisi dengan angka.';

    if (empty($errors)) {
        $updateSql = 'UPDATE produk SET nama_produk=:nama, merek=:merek, harga=:harga, stok=:stok WHERE id=:id';
        $uStmt = $pdo->prepare($updateSql);
        try {
            $uStmt->execute([
                ':nama'=>$nama,
                ':merek'=>$merek,
                ':harga'=>(int)$harga,
                ':stok'=>(int)$stok,
                ':id'=>$id
            ]);
            echo '<div class="message">Produk berhasil diperbarui. 
                  <a href="detail.php?id='.urlencode($id).'">Lihat detail</a></div>';
            // refresh data
            $stmt = $pdo->prepare('SELECT * FROM produk WHERE id = :id');
            $stmt->execute([':id'=>$id]);
            $row = $stmt->fetch();
        } catch (Exception $e) {
            echo '<div class="message error">Gagal memperbarui data. Silakan coba lagi.</div>';
        }
    } else {
        echo '<div class="message error"><ul><li>' . implode('</li><li>', array_map('htmlspecialchars',$errors)) . '</li></ul></div>';
    }
}
?>

<form method="post" action="update.php?id=<?php echo $row['id']; ?>">
    <div style="display:flex;flex-direction:column;gap:8px;max-width:600px">
        <label>Nama Produk
            <input type="text" name="nama_produk" value="<?php echo htmlspecialchars($row['nama_produk']); ?>" required>
        </label>
        <label>Merek
            <input type="text" name="merek" value="<?php echo htmlspecialchars($row['merek']); ?>" required>
        </label>
        <label>Harga (angka)
            <input type="number" name="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" required>
        </label>
        <label>Stok (angka)
            <input type="number" name="stok" value="<?php echo htmlspecialchars($row['stok']); ?>" required>
        </label>
        <div>
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
            <a class="btn" href="detail.php?id=<?php echo $row['id']; ?>">Batal</a>
        </div>
    </div>
</form>

<?php require 'includes/footer.php'; ?>
