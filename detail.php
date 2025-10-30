<?php
require 'config/config.php';
$page_title = 'Detail Produk';
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
?>

<h2><?php echo htmlspecialchars($row['nama_produk']); ?></h2>
<p><strong>Merek:</strong> <?php echo htmlspecialchars($row['merek']); ?></p>
<p><strong>Harga:</strong> <?php echo number_format($row['harga'],0,',','.'); ?></p>
<p><strong>Stok:</strong> <?php echo $row['stok']; ?></p>
<p><strong>Dibuat pada:</strong> <?php echo $row['created_at']; ?></p>

<p>
    <a class="btn" href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
    <a class="btn" href="read.php">Kembali</a>
</p>

<?php require 'includes/footer.php'; ?>
