-- SQL untuk membuat database dan tabel produk
CREATE DATABASE IF NOT EXISTS db_gamekonsol 
CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_gamekonsol;

CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(255) NOT NULL,
    merek VARCHAR(100) NOT NULL,
    harga INT NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
