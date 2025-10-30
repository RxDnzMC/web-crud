<?php
require 'config/config.php';
$page_title = 'Tambah Produk';
require 'includes/header.php';

$errors = [];
$old = ['nama_produk'=>'','merek'=>'','harga'=>'','stok'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitasi & validasi
    $nama = trim($_POST['nama_produk'] ?? '');
    $merek = trim($_POST['merek'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $stok = trim($_POST['stok'] ?? '');

    $old = ['nama_produk'=>$nama,'merek'=>$merek,'harga'=>$harga,'stok'=>$stok];

    if ($nama === '') $errors[] = 'Nama produk wajib diisi.';
    if ($merek === '') $errors[] = 'Merek wajib diisi.';
    if ($harga === '' || !ctype_digit($harga)) $errors[] = 'Harga wajib diisi dengan angka.';
    if ($stok === '' || !ctype_digit($stok)) $errors[] = 'Stok wajib diisi dengan angka.';

    if (empty($errors)) {
        $sql = "INSERT INTO produk (nama_produk, merek, harga, stok, created_at) 
                VALUES (:nama, :merek, :harga, :stok, :created_at)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':nama'=>$nama,
                ':merek'=>$merek,
                ':harga'=> (int)$harga,
                ':stok'=> (int)$stok,
                ':created_at'=> date('Y-m-d H:i:s')
            ]);
            echo '<div class="message success-message">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.5em;">🎉</span>
                        <div>
                            <strong>Produk berhasil ditambahkan!</strong>
                            <div style="margin-top: 8px;">
                                <a class="btn btn-primary" href="read.php">Lihat Daftar Produk</a>
                                <a class="btn" href="create.php">Tambah Lagi</a>
                            </div>
                        </div>
                    </div>
                  </div>';
            $old = ['nama_produk'=>'','merek'=>'','harga'=>'','stok'=>''];
        } catch (Exception $e) {
            echo '<div class="message error">
                    <div style="display: flex; align-items: flex-start; gap: 10px;">
                        <span style="font-size: 1.2em;">⚠️</span>
                        <div>
                            <strong>Gagal menyimpan data</strong>
                            <p style="margin: 5px 0 0 0;">Silakan coba lagi.</p>
                        </div>
                    </div>
                  </div>';
        }
    } else {
        echo '<div class="message error">
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <span style="font-size: 1.2em;">❌</span>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                            <li>' . implode('</li><li>', array_map('htmlspecialchars',$errors)) . '</li>
                        </ul>
                    </div>
                </div>
              </div>';
    }
}
?>

<div class="form-container">
    <div class="form-header">
        <h2 style="margin: 0; color: var(--grass); text-shadow: 2px 2px 0 #558b2f;">
            ⛏️ Tambah Produk Baru
        </h2>
        <p style="margin: 8px 0 0 0; color: #666; font-size: 0.95rem;">
            Isi form di bawah untuk menambahkan produk game konsol ke inventory
        </p>
    </div>

    <form method="post" action="create.php" class="minecraft-form">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">
                    <span class="label-icon">🎮</span>
                    Nama Produk
                </label>
                <input type="text" name="nama_produk" 
                       value="<?php echo htmlspecialchars($old['nama_produk']); ?>" 
                       placeholder="Contoh: Nintendo Switch OLED"
                       class="form-input" required>
                <div class="form-hint">Masukkan nama lengkap produk</div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-icon">🏷️</span>
                    Merek
                </label>
                <input type="text" name="merek" 
                       value="<?php echo htmlspecialchars($old['merek']); ?>" 
                       placeholder="Contoh: Nintendo, PlayStation, Xbox"
                       class="form-input" required>
                <div class="form-hint">Masukkan merek produk</div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-icon">💰</span>
                    Harga
                </label>
                <div class="input-with-prefix">
                    <span class="input-prefix">Rp</span>
                    <input type="number" name="harga" 
                           value="<?php echo htmlspecialchars($old['harga']); ?>" 
                           placeholder="0"
                           min="0"
                           class="form-input" required>
                </div>
                <div class="form-hint">Masukkan harga dalam Rupiah (angka saja)</div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="label-icon">📦</span>
                    Stok
                </label>
                <input type="number" name="stok" 
                       value="<?php echo htmlspecialchars($old['stok']); ?>" 
                       placeholder="0"
                       min="0"
                       class="form-input" required>
                <div class="form-hint">Jumlah stok yang tersedia</div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">
                <span class="btn-icon">💾</span>
                Simpan Produk
            </button>
            <a href="read.php" class="btn btn-secondary">
                <span class="btn-icon">↩️</span>
                Kembali ke Daftar
            </a>
        </div>
    </form>
</div>

<style>
.form-container {
    max-width: 700px;
    margin: 0 auto;
}

.form-header {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    background: linear-gradient(135deg, #e8f5e8 0%, #f1f8e9 100%);
    border: 3px solid var(--grass);
    border-radius: 8px;
}

.minecraft-form {
    background: white;
    padding: 30px;
    border: 4px solid var(--wood);
    border-radius: 8px;
    box-shadow: 0 6px 0 #6d4c41;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 30px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-weight: bold;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
}

.label-icon {
    font-size: 1.1em;
}

.form-input {
    padding: 12px;
    border: 2px solid var(--stone);
    border-radius: 6px;
    font-size: 1rem;
    background: white;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--water);
    box-shadow: 0 0 0 3px rgba(79, 195, 247, 0.3);
    transform: translateY(-2px);
}

.form-hint {
    font-size: 0.85rem;
    color: #666;
    font-style: italic;
}

.input-with-prefix {
    position: relative;
}

.input-prefix {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    font-weight: bold;
    background: #f5f5f5;
    padding: 2px 6px;
    border-radius: 4px;
}

.input-with-prefix .form-input {
    padding-left: 50px;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.btn-large {
    padding: 12px 24px;
    font-size: 1.1rem;
}

.btn-secondary {
    background: var(--cloud);
    color: #333;
    border-color: #bdbdbd;
}

.btn-icon {
    margin-right: 6px;
}

.success-message {
    background: var(--emerald);
    border: 3px solid #4caf50;
    color: white;
    text-shadow: 1px 1px 0 #388e3c;
}

/* Responsive design */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .form-container {
        padding: 0 10px;
    }
    
    .minecraft-form {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .form-actions .btn {
        text-align: center;
    }
}
</style>

<?php require 'includes/footer.php'; ?>