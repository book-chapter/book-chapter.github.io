<?php
// $host = 'localhost';
// $db = 'book_chapter';
// $user = 'root';
// $pass = '';

// $conn = new mysqli($host, $user, $pass, $db);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

$host = 'localhost';
$db = 'book_chapter';
$user = 'root';
$pass = '';

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengatur karakter encoding (opsional, tapi direkomendasikan)
$conn->set_charset("utf8");

// Untuk testing koneksi, hapus komentar baris berikut:
// echo "Koneksi berhasil!";
