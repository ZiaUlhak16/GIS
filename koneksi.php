<?php

$conn = new mysqli("localhost", "root", "", "gis_apotik");

if (!$conn) {
    echo "Koneksi Gagal";
}
