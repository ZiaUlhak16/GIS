<!-- Header -->
<?php include("template/header.php") ?>
<!-- Navbar -->
<?php include("template/navbar.php") ?>
<!-- Content -->
<div class="page-content p-5" id="content">
    <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4">
        <i class="fa fa-bars mr-2"></i></button>
    <div class="row">
        <div class="col-lg-10">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Lokasi Awal</label>
                    <select id="lokasi_awal" class="form-control">
                        <option selected>--Silahkan Pilih--</option>
                        <?php
                        include "koneksi.php";
                        $kec = $conn->query("SELECT * FROM apotik");
                        if ($kec->num_rows > 0) {
                            while ($row = $kec->fetch_assoc()) {
                        ?>
                                <!-- Tambahkan spasi antara, dan longitude -->
                                <option value="<?= $row['latitude']; ?>, <?= $row['longitude']; ?>" ?>
                                    <?= $row['nama']; ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Lokasi Tujuan</label>
                    <select id="lokasi_tujuan" class="form-control">
                        <option selected>--Silahkan Pilih--</option>
                        <?php
                        include "koneksi.php";
                        $kec = $conn->query("SELECT * FROM apotik");
                        if ($kec->num_rows > 0) {
                            while ($row = $kec->fetch_assoc()) {
                        ?>
                                <option value="<?= $row['latitude']; ?>, <?= $row['longitude']; ?>" ?>
                                    <?= $row['nama']; ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <button style="margin-top: 32px;" id="rute" class="btn btn-danger">Rute</button>
        </div>
        <div class="col">.
            <div id="maps" style="height: 730px;"></div>
        </div>
    </div>
</div>
<script>
    let myMap = L.map('maps').setView([-0.8931699926701577, 119.86473745747928], 20);
    let layerMap = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href=https://creativecommons.org/licences/by-sa/2.0/">CC-BY-SA</a>, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/satellite-v9'
    });
    myMap.addLayer(layerMap);

    <?php
    //Icon
    $noMarker = 0; ?>
    let markers;
    <?php
    include "koneksi.php";
    $sql = "SELECT * FROM apotik";
    $hasil = $conn->query($sql);
    if ($hasil->num_rows > 0) {
        while ($row = $hasil->fetch_row()) { ?>
            markers<?= $noMarker += 1; ?> = L.marker([<?= $row[5] ?>, <?= $row[6] ?>]).bindPopup("Nama : <?= $row[1] ?> <br> Alamat : <?= $row[3] ?> <br>" +
                "<a href='detail_apotik.php?id=<?= $row[0] ?>' class='btn btn-outline-info btn-sm'>Detail</a>").addTo(myMap);
    <?php }
    } ?>

    //Kecamatan
    <?php
    $sql = "SELECT * FROM kecamatan";
    $hasil = $conn->query($sql);
    if ($hasil->num_rows > 0) {
        while ($row = $hasil->fetch_assoc()) { ?>
            L.geoJson(<?= $row['poligon'] ?>, {
                color: "<?= $row['warna'] ?>",
            }).bindPopup("Kecamatan : <?= $row['nama'] ?>").addTo(myMap);
    <?php }
    } ?>

    $('#rute').on('click', function() {
        let awal = $('#lokasi_awal').val();
        let awalLatLng = awal.split(',')
        let tujuan = $('#lokasi_tujuan').val();
        let tujuanLatlng = tujuan.split(',')
        // console.log(awal)
        // console.log(tujuan)
        // routing machine
        L.Routing.control({
            waypoints: [
                L.latLng(awalLatLng[0], awalLatLng[1]),
                L.latLng(tujuanLatlng[0], tujuanLatlng[1])
            ],
            routeWhileDragging: false,
        }).addTo(myMap);
    })


    let baseLayer = [{
        group: "Tipe Maps",
        layers: [{
                name: "Satellite",
                layer: layerMap
            },
            {
                name: "Light",
                layer: L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' + 'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    id: 'mapbox/streets-v11'
                }),
            },
            {
                name: "Street",
                layer: L.tileLayer(
                    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}", {
                        foo: "bar",
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    }
                ),
            },
            {
                name: "Dark",
                layer: L.tileLayer(
                    "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw", {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        id: "mapbox/dark-v10",
                    }
                ),
            },
        ],
    }, ];

    <?php
    $noLayer = 0;
    ?>
    let marker;
    let overLayers = [{
        group: "Apotik Kota Palu",
        layers: [
            <?php
            $sqllegend = "SELECT * FROM apotik";
            $hasil = $conn->query($sqllegend);
            if ($hasil->num_rows > 0) {
                while ($row = $hasil->fetch_assoc()) { ?> {
                        active: true,
                        name: "<?= $row['nama'] ?>",
                        layer: markers<?= $noLayer += 1; ?>,
                    },
            <?php }
            } ?>
        ],
    }, ];

    let panelLayers = new L.Control.PanelLayers(baseLayer, overLayers);

    myMap.addControl(panelLayers);
</script>
<!-- End Content -->
<!-- Footer -->
<?php include("template/footer.php") ?>