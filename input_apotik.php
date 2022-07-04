<!-- Header -->
<?php include("template/header.php")?>
<!-- Navbar -->
<?php include("template/navbar.php")?>
<?php include "koneksi.php";
session_start();
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $pemilik = $_POST['pemilik'];
    $alamat = $_POST['alamat'];
    $kecamatan = $_POST['kecamatan'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $query = $conn->query("INSERT INTO apotik(nama,pemilik,alamat,kecamatan,latitude,longitude) 
    VALUES('$nama','$pemilik','$alamat','$kecamatan','$latitude','$longitude')");

    if ($query) {
        $_SESSION['pesan'] = 'Data Berhasil ditambahkan';
        echo "<script>
        window.location.href = 'apotik.php';
        </script>";
    }
}
?>
<!-- Content -->
<div class="page-content p-5" id="content">
    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4">
        <i class="fa fa-bars mr-2"></i></button>
    <div class="row">
        <div class="col-lg mb-2">
            <div id="maps" style="height:400px;"></div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Input Data
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pemilik</label>
                                <input type="text" class="form-control" name="pemilik" placeholder="Pemilik" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Alamat</label>
                            <input type="text" class="form-control" name="alamat" placeholder="Masukkan Alamat"
                                required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputState">Kecamatan</label>
                                <select id="inputState" class="form-control" name="kecamatan">
                                    <option selected>--Silahkan Pilih--</option>
                                    <?php
                                    $kec = $conn->query("SELECT * FROM kecamatan");

                                    if ($kec->num_rows > 0) {
                                        while($row = $kec->fetch_row()) {
                                    ?>
                                    <option><?= $row[1]; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Latitude</label>
                                <input type="text" class="form-control" id="Latitude" name="latitude">
                            </div>
                            <div class="form-group col-md-4">
                                <label>longitude</label>
                                <input type="text" class="form-control" id="Longitude" name="longitude">
                            </div>
                        </div>
                        <button type="submit" name="simpan" class="btn btn-info">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let latlang = [0, 0];
if (latlang[0] == 0 && latlang[1] == 0) {
    latlang = [-0.8959414599229022, 119.87195300335179];
}

let myMap = L.map('maps').setView([-0.8959414599229022, 119.87195300335179], 14);

let layerMap = L.tileLayer(
    api_mapbox, {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: "mapbox/streets-v11",
    });

myMap.addLayer(layerMap);

let marker = new L.marker(latlang, {
    draggable: 'true'
});

marker.on('dragend', function(event) {
    let position = marker.getLatLng();
    marker.setLatLng(position).update();
    $("#Latitude").val(position.lat);
    $("#Longitude").val(position.lng);
});

myMap.addLayer(marker);
</script>
<!-- End Content -->
<!-- Footer -->
<?php include("template/footer.php")?>