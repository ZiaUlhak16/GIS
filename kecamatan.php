<!-- Content -->
<?php include "koneksi.php";
session_start();
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $poligon = $_POST['poligon'];
    $warna = $_POST['warna'];

    $queryResult = $conn->query("INSERT INTO kecamatan(nama,poligon,warna) 
    VALUES('$nama','$poligon','$warna')");

    if ($queryResult) {
        $_SESSION['pesan'] = 'Data Berhasil Ditambahkan';
    }
}
?>
<!-- Header -->
<?php include("template/header.php") ?>
<!-- Navbar -->
<?php include("template/navbar.php") ?>
<div class="page-content p-5" id="content">
    <div class="data-pesan" data-pesan="<?php if (isset($_SESSION['pesan'])) {
                                            echo $_SESSION['pesan'];
                                        }
                                        unset($_SESSION['pesan']); ?>"></div>
    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4">
        <i class="fa fa-bars mr-2"></i></button>
    <div class="row">
        <div class="col-lg-7">
            <div id="maps" style="height: 500px;"></div>
        </div>
        <div class="col-lg-5">
            <form action="" method="POST">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Warna</label>
                    <div class="col-sm-4">
                        <input type="color" class="form-control" name="warna" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Koordinat Poligon</label>
                    <textarea class="form-control" name="poligon" id="poligon" rows="3" required></textarea>
                </div>
                <button type="submit" name="simpan" class="btn btn-info">Simpan</button>
            </form>
        </div>

        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-header">Data Kecamatan</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Kecamatan</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $conn->query("SELECT * FROM kecamatan");
                            $no = 0;
                            if ($query->num_rows > 0) {
                                while ($row = $query->fetch_row()) {
                            ?>
                                    <tr>
                                        <td><?= $no += 1; ?> </td>
                                        <td><?= $row[1]; ?> </td>
                                        <td>
                                            <a class="btn btn-danger btn-hapus-kecamatan" href="delete_kecamatan.php?id=<?= $row[0]; ?>">
                                                <i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let myMap = L.map('maps').setView([-0.9002753758954589, 119.8664202972103], 14);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11'
    }).addTo(myMap);


    let drawnItems = new L.FeatureGroup();
    myMap.addLayer(drawnItems);
    let drawControl = new L.Control.Draw({
        draw: {
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false,
            circlemarker: false,
        },
        edit: {
            featureGroup: drawnItems
        }
    });
    myMap.addControl(drawControl);

    myMap.on('draw:created', function(event) {
        let layer = event.layer,
            feature = layer.feature = layer.feature || {};

        feature.type = feature.type || "Feature";
        let props = feature.properties = feature.properties || {};
        drawnItems.addLayer(layer);

        let hasil = $('#poligon').val(JSON.stringify(drawnItems.toGeoJSON()));
    });

    //Sweetalert
    //Success
    let pesan = $(".data-pesan").data("pesan");

    if (pesan) {
        Swal.fire({
            icon: "success",
            title: pesan,
            showConfirmButton: false,
            timer: 1500
        })
    }

    //Hapus Kecamatan
    $(".btn-hapus-kecamatan").on("click", function(e) {
        e.preventDefault();
        const href = $(this).attr("href");

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data Kecamatan Akan Dihapus?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus data!'
        }).then((result) => {
            if (result.value) {
                document.location.href = href;
            }
        })
    });
</script>
<!-- End Content -->
<!-- Footer -->
<?php include("template/footer.php") ?>