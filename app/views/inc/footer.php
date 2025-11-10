</div>
</section>
</div>

</body>



<!-- jQuery -->
<!-- <script src="<?= $_url ?>plugins/jquery/jquery.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.1.0.js"></script> -->
<!-- jQuery ini yang baru-->
<script src="<?= URLROOT ?>/dist/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= URLROOT ?>/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= URLROOT ?>/dist/js/adminlte.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script src="<?= URLROOT ?>/dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= URLROOT ?>/dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= URLROOT ?>/dist/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= URLROOT ?>/dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="<?= URLROOT ?>/dist/plugins/select2/js/select2.full.min.js"></script>

<script src="<?= URLROOT ?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= URLROOT ?>/dist/plugins/toastr/toastr.min.js"></script>



<script src="<?= URLROOT; ?>/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= URLROOT; ?>/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= URLROOT; ?>/vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= URLROOT; ?>/vendor/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?= URLROOT; ?>/vendor/datatables-buttons/js/jszip.min.js"></script>



<script type="text/javascript">
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        }
    };

    function showPosition(position) {
        console.log("Latitude: " + position.coords.latitude + ", " +
            "Longitude: " + position.coords.longitude + ", " + "Akurasi :" + position.coords.accuracy);
        $("#loc_masuk").val(position.coords.latitude + ', ' + position.coords.longitude);
        $("#loc_pulang").val(position.coords.latitude + ', ' + position.coords.longitude);
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);


        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

        //RADIUS KANTOR
        <?php
        $locate = '';

        if (isset($_username)) {
            $sql = "SELECT * FROM dosen WHERE npk='{$_username}'";
            $query = mysqli_query($koneksi, $sql);
            if (mysqli_num_rows($query) == 1) {
                $field = mysqli_fetch_array($query);
                if ($field['id_kantor'] == 1) {
                    $locate = '-3.443483,114.822717';
                } else {
                    $locate = '-3.2968008,114.6025797';
                }
            } else {
                $locate = '-3.443483,114.822717';
            }
        } else {
            $locate = '-3.443483,114.822717';
        }
        ?>
        var locate = '<?php echo $locate; ?>';
        var LocateArr = locate.split(',');
        var lat_kantor = LocateArr[0];
        var lng_kantor = LocateArr[1];
        var circle = L.circle([lat_kantor, lng_kantor], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 70
        }).addTo(map);
        akurasi = Math.round(position.coords.accuracy);
        if (akurasi > 100) {
            $("#alert").text('Tingkat akurasi lokasi tergantung perangkat GPS anda.');
        } else {
            $("#alert").text('Akurasi lokasi: ' + akurasi + 'm');
        }
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                console.log("User denied the request for Geolocation.");
                $("#alert").text('Anda tidak mengizinkan akses lokasi. Sebaiknya izinkan aplikasi mengakses lokasi anda agar mengoptimalkan performa aplikasi.');
                break;
            case error.POSITION_UNAVAILABLE:
                console.log("Location information is unavailable.")
                break;
            case error.TIMEOUT:
                console.log("The request to get user location timed out.")
                break;
            case error.UNKNOWN_ERROR:
                console.log("An unknown error occurred.")
                break;
        }
    }
    $(function() {
        getLocation();
    });
</script>


<script>
    $('.pilihjadwal').select2({
        placeholder: "~ Pilih Mata Pelajaran ~"
    });

    $('.pilihguru').select2({
        placeholder: "~ Pilih Guru ~"
    });
</script>


<script>
    /*
    $(document).ready(function() {
        $('.select2-multiple').select2();
    });
    */
</script>

</html>


<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>
<script>
    FingerprintJS.load().then(fp => {
        fp.get().then(result => {
            let visitorId = result.visitorId;
            console.log("Visitor ID: " + visitorId);
            $('#visitid').val(visitorId);
            // Simpan visitorId ke server untuk pelacakan
        });
    });
</script>
<script>
    FingerprintJS.load().then(fp => {
        fp.get().then(result => {
            let visitorId = result.visitorId;
            console.log("Visitor ID: " + visitorId);
            $('#visitid_pulang').val(visitorId);
            // Simpan visitorId ke server untuk pelacakan
        });
    });
</script>