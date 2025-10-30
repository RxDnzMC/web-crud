<?php
require 'config/config.php';
$page_title = 'Daftar Produk';
require 'includes/header.php';

// Pagination setup
$perPage = 5;
$page = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Search setup
$keyword = trim($_GET['q'] ?? '');
$where = '';
$params = [];

if ($keyword !== '') {
    $where = "WHERE nama_produk LIKE :kw1 OR merek LIKE :kw2";
    $params[':kw1'] = '%' . $keyword . '%';
    $params[':kw2'] = '%' . $keyword . '%';
}

// Hitung total data
$countSql = "SELECT COUNT(*) FROM produk $where";
$countStmt = $pdo->prepare($countSql);

// Bind parameter untuk pencarian (kalau ada)
if ($keyword !== '') {
    $countStmt->bindValue(':kw1', '%' . $keyword . '%');
    $countStmt->bindValue(':kw2', '%' . $keyword . '%');
}

$countStmt->execute();
$total = (int)$countStmt->fetchColumn();
$pages = max(1, ceil($total / $perPage));

// Ambil data produk
$sql = "SELECT id, nama_produk, merek, harga, stok, created_at 
        FROM produk $where 
        ORDER BY created_at DESC 
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);

// Bind parameter pencarian
if ($keyword !== '') {
    $stmt->bindValue(':kw1', '%' . $keyword . '%');
    $stmt->bindValue(':kw2', '%' . $keyword . '%');
}

// Bind limit dan offset
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$rows = $stmt->fetchAll();
?><!-- Form pencarian --><form method="get" action="read.php" class="form-row" style="margin-bottom:15px;">
    <input type="text" name="q" placeholder="Cari nama atau merek..." 
           value="<?php echo htmlspecialchars($keyword); ?>">
    <button class="btn" type="submit">Cari</button>
    <?php if ($keyword !== ''): ?>
        <a class="btn" href="read.php">Reset</a>
    <?php endif; ?>
</form><!-- Tabel data --><table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Produk</th>
            <th>Merek</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($rows)): ?>
        <tr><td colspan="7" style="text-align:center;">Belum ada data.</td></tr>
    <?php else: ?>
        <?php foreach ($rows as $r): ?>
        <tr>
            <td><?php echo $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['nama_produk']); ?></td>
            <td><?php echo htmlspecialchars($r['merek']); ?></td>
            <td><?php echo number_format($r['harga'], 0, ',', '.'); ?></td>
            <td><?php echo $r['stok']; ?></td>
            <td><?php echo $r['created_at']; ?></td>
            <td class="actions">
                <a class="btn" href="detail.php?id=<?php echo $r['id']; ?>">Detail</a>
                <a class="btn" href="update.php?id=<?php echo $r['id']; ?>">Edit</a>
                <a class="btn btn-danger" href="delete.php?id=<?php echo $r['id']; ?>" 
                   onclick="return confirm('Hapus produk ini?');">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table><!-- Navigasi halaman --><div style="margin-top:12px; text-align:center;">
    <?php if ($pages > 1): ?>
        <?php for ($p = 1; $p <= $pages; $p++): ?>
            <?php if ($p == $page): ?>
                <strong><?php echo $p; ?></strong>
            <?php else: ?>
                <a class="btn" href="read.php?page=<?php echo $p; ?><?php echo $keyword ? '&q=' . urlencode($keyword) : ''; ?>"><?php echo $p; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>
</div><?php require 'includes/footer.php'; ?>