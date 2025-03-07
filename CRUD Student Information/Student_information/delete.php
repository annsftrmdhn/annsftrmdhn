<?php
// Hubungkan ke database
include_once("config.php");

// Periksa apakah parameter 'nim' ada di URL
if (isset($_GET['nim'])) {
    $nim = mysqli_real_escape_string($mysqli, $_GET['nim']); // Hindari SQL Injection

    // Query untuk menghapus data berdasarkan NIM
    $result = mysqli_query($mysqli, "DELETE FROM information WHERE nim='$nim'");

    // Periksa apakah penghapusan berhasil
    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('NIM tidak ditemukan!'); window.location='index.php';</script>";
}
?>
