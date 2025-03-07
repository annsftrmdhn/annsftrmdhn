<?php

include_once("config.php");


if (isset($_GET['nim'])) {
    $nim = mysqli_real_escape_string($mysqli, $_GET['nim']); // Hindari SQL Injection

    $result = mysqli_query($mysqli, "DELETE FROM information WHERE nim='$nim'");

    if ($result) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('NIM tidak ditemukan!'); window.location='index.php';</script>";
}
?>
