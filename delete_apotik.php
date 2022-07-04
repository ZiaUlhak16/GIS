<?php

//Koneksi Database
include "koneksi.php";

session_start();

$id = $_GET['id'];

$queryResult = $conn->query("DELETE FROM apotik WHERE id='$id'");

if ($queryResult) {
    $_SESSION['pesan'] = 'Data Apotik Berhasil Dihapus';
    echo "<script>
    window.location.href = 'apotik.php';
    </script>";
}