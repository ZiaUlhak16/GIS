<!-- Header -->
<?php include("template/header.php") ?>
<!-- Navbar -->
<?php include("template/navbar.php") ?>
<!-- Content -->
<?php

include 'koneksi.php';

$id = $_GET['id'];

$query = $conn->query("SELECT * FROM apotik WHERE id='$id'");
$row = $query->fetch_assoc();

$nama = $row['nama'];
$pemilik = $row['pemilik'];
$alamat = $row['alamat'];
$kecamatan = $row['kecamatan'];
$latitude = $row['latitude'];
$longitude = $row['longitude'];
?>
<div class="page-content p-5" id="content">
    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4">
        <i class="fa fa-bars mr-2"></i></button>
    <div class="row">
        <div class="col-lg-12 mb-2">
            <a href="pemetaan.php" class="btn btn-info">Kembali</a>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Data Apotik
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Nama : <?= $nama; ?></li>
                        <li class="list-group-item">Pemilik : <?= $pemilik; ?></li>
                        <li class="list-group-item">Alamat : <?= $alamat; ?></li>
                        <li class="list-group-item">Kecamatan : <?= $kecamatan; ?></li>
                        <li class="list-group-item">Latitude : <?= $latitude; ?></li>
                        <li class="list-group-item">Longitude : <?= $longitude; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<!-- Footer -->
<?php include("template/footer.php")?>