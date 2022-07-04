<?php
include "koneksi.php";
session_start();
$id = $_GET['id'];
$queryResult = $conn->query("DELETE FROM kecamatan WHERE id='$id'");
if ($queryResult) {
    $_SESSION['pesan'] = 'Data Kecamatan Berhasil Dihapus';
    echo "<script>
    window.location.href = 'kecamatan.php';
    </script>";
}