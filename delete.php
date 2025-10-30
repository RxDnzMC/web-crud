<?php
require 'config/config.php';

$id = $_GET['id'] ?? null;
if (!$id || !ctype_digit($id)) {
    header('Location: read.php');
    exit;
}

$sql = 'DELETE FROM produk WHERE id = :id';
$stmt = $pdo->prepare($sql);
try {
    $stmt->execute([':id'=>$id]);
    header('Location: read.php?msg=deleted');
    exit;
} catch (Exception $e) {
    header('Location: read.php?msg=error');
    exit;
}
?>
