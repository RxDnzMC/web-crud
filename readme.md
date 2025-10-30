# CRUD Game Konsol (PHP Native + PDO)

**Deskripsi singkat**  
Aplikasi CRUD sederhana untuk menyimpan data produk game konsol. Dibuat menggunakan PHP native (PHP >= 8.0), MySQL/MariaDB, dan koneksi database via PDO.

---

## 🚀 Fitur
- **Create:** tambah produk dengan validasi sisi server  
- **Read:** tampilkan daftar produk urut berdasarkan `created_at DESC`  
- **Detail:** halaman detail produk  
- **Update:** edit data produk dengan prefilled form  
- **Delete:** hapus produk (konfirmasi sebelum menghapus)  
- **Search:** cari berdasarkan nama produk atau merek  
- **Pagination:** tampilkan 5 data per halaman  
- **Keamanan:** sanitasi input & prepared statement (anti SQL Injection)  
- **Error Handling:** pesan error informatif tanpa stack trace  

---

## 🧱 Kebutuhan Sistem
- PHP 8.0 atau lebih baru  
- MySQL / MariaDB  
- Server lokal: **XAMPP** atau **Laragon**

---

## ⚙️ Instalasi & Konfigurasi
1. Ekstrak folder `web-crud-php-native` ke `htdocs` (XAMPP) atau `www` (Laragon)  
2. Import file `db_gamekonsol.sql` ke MySQL  
3. Ubah file `.env.example` jadi `.env`, lalu sesuaikan:
