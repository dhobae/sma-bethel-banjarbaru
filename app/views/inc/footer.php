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

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<?php require_once APPROOT . '/helpers/location_helper.php'; ?>
<script type="text/javascript">
    // Mengambil koordinat dan radius dari location_helper.php (Single Source of Truth)
    const SCHOOL_LAT = <?= SCHOOL_LAT ?>;
    const SCHOOL_LNG = <?= SCHOOL_LNG ?>;
    const WFO_RADIUS = <?= WFO_RADIUS ?>;

    // Variabel global agar view lain (seperti absen.php) bisa melihat status WFO
    window.isGlobalWFO = false;
    window.locationChecked = false;

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            updateLocationStatusToWFH();
        }
    }

    function updateLocationStatusToWFH() {
        // Set default WFH jika lokasi tidak bisa didapat
        window.isGlobalWFO = false;
        window.locationChecked = true;

        // Update info lokasi dengan default values
        const accuracyEl = document.getElementById('accuracy-info');
        const distanceEl = document.getElementById('distance-info');
        const statusEl = document.getElementById('status-info');
        
        if (accuracyEl) accuracyEl.textContent = 'Tidak tersedia';
        if (distanceEl) distanceEl.textContent = 'Tidak tersedia';
        if (statusEl) statusEl.innerHTML = '<strong style="color: #ffc107;">WFH</strong><br/><small style="color:#666;">Lokasi tidak dapat dideteksi</small>';
        
        // Sembunyikan loading, tampilkan info
        const locationLoading = document.getElementById('location-loading');
        const locationInfo = document.getElementById('location-info');
        if (locationLoading) {
            locationLoading.style.display = 'none';
        }
        if (locationInfo) {
            locationInfo.style.display = 'block';
        }

        const wfoBox = document.getElementById('wfo-status-box');
        if (wfoBox && wfoBox.getAttribute('data-ip-wfo') === '0') {
            const wfoText = document.getElementById('wfo-status-text');
            const wfoLabel = document.getElementById('wfo-status-label');
            
            if (wfoText) wfoText.innerHTML = 'Anda berada di luar lingkungan Sekolah';
            if (wfoLabel) wfoLabel.innerHTML = 'WFH';
        }
    }

    function showPosition(position) {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;
        const accuracy = Math.round(position.coords.accuracy);
        
        console.log("Latitude: " + userLat + ", Longitude: " + userLng + ", Accuracy: " + accuracy);
        
        // Simpan koordinat ke form input
        if ($("#loc_masuk").length) $("#loc_masuk").val(userLat + ', ' + userLng);
        if ($("#loc_pulang").length) $("#loc_pulang").val(userLat + ', ' + userLng);
        
        // Inisialisasi peta jika element map ada
        if (document.getElementById('map')) {
            const map = L.map('map').setView([userLat, userLng], 16);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Marker lokasi user
            L.marker([userLat, userLng]).addTo(map)
                .bindPopup('Lokasi Anda saat ini');

            // Circle radius WFO
            L.circle([SCHOOL_LAT, SCHOOL_LNG], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: WFO_RADIUS
            }).addTo(map)
                .bindPopup('Area WFO (' + WFO_RADIUS + 'm dari Sekolah)');

            // Marker sekolah di pusat circle
            L.marker([SCHOOL_LAT, SCHOOL_LNG]).addTo(map)
                .bindPopup('<b>Lokasi Sekolah</b>');
        }

        // UPDATE DASHBOARD INFO LOKASI
        updateDashboardLocationInfo(userLat, userLng, accuracy);
    }

    // Function untuk menghitung jarak (Haversine formula)
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371000; // Radius bumi dalam meter
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.asin(Math.sqrt(a));
        return R * c;
    }

    // Function untuk update dashboard info lokasi
    function updateDashboardLocationInfo(userLat, userLng, accuracy) {
        // Hitung jarak dari sekolah
        const distance = calculateDistance(userLat, userLng, SCHOOL_LAT, SCHOOL_LNG);
        
        // Update accuracy info
        const accuracyEl = document.getElementById('accuracy-info');
        if (accuracyEl) {
            if (accuracy > 100) {
                accuracyEl.textContent = accuracy + ' meter (Kurang akurat)';
            } else {
                accuracyEl.textContent = accuracy + ' meter (Sangat akurat)';
            }
        }
        
        // Update distance info
        const distanceEl = document.getElementById('distance-info');
        if (distanceEl) {
            distanceEl.textContent = distance.toFixed(2) + ' meter';
        }
        
        // Update status WFO/WFH pada map info
        const statusEl = document.getElementById('status-info');
        let isWFO = distance <= WFO_RADIUS;
        let status = isWFO ? 'WFO' : 'WFH';
        
        window.isGlobalWFO = isWFO;
        window.locationChecked = true;

        if (statusEl) {
            let statusColor = isWFO ? '#28a745' : '#ffc107'; // Green atau Yellow
            let message = isWFO 
                ? 'Anda berada di dalam radius sekolah' 
                : 'Anda berada di luar radius sekolah';
            
            statusEl.innerHTML = 
                '<strong style="color:' + statusColor + ';">' + status + '<span style="color:#666;"> (GPS)</span>' + '</strong><br/>' +
                '<small style="color:#666;">' + message + '</small>';
        }

        // Tampilkan info lokasi, sembunyikan loading
        const locationLoading = document.getElementById('location-loading');
        const locationInfo = document.getElementById('location-info');
        if (locationLoading) {
            locationLoading.style.display = 'none';
        }
        if (locationInfo) {
            locationInfo.style.display = 'block';
        }

        // Update status di header dashboard utama jika IP gagal (data-ip-wfo='0')
        const wfoBox = document.getElementById('wfo-status-box');
        if (wfoBox && wfoBox.getAttribute('data-ip-wfo') === '0') {
            const wfoText = document.getElementById('wfo-status-text');
            const wfoLabel = document.getElementById('wfo-status-label');
            
            if (isWFO) {
                wfoText.innerHTML = 'Anda sedang berada di lingkungan Sekolah';
                wfoLabel.innerHTML = 'WFO';
            } else {
                wfoText.innerHTML = 'Anda berada di luar lingkungan Sekolah';
                wfoLabel.innerHTML = 'WFH';
            }
        }
    }

    function showError(error) {
        let errorMessage = '';
        
        switch (error.code) {
            case error.PERMISSION_DENIED:
                console.log("User denied the request for Geolocation.");
                errorMessage = 'Izin akses lokasi ditolak. Silakan izinkan di pengaturan browser.';
                break;
            case error.POSITION_UNAVAILABLE:
                console.log("Location information is unavailable.");
                errorMessage = 'Informasi lokasi tidak tersedia. Pastikan GPS aktif.';
                break;
            case error.TIMEOUT:
                console.log("The request to get user location timed out.");
                errorMessage = 'Permintaan lokasi timeout. Cek koneksi internet/GPS Anda.';
                break;
            case error.UNKNOWN_ERROR:
                console.log("An unknown error occurred.");
                errorMessage = 'Terjadi kesalahan saat mengakses lokasi.';
                break;
        }
        
        updateLocationStatusToWFH();
    }

    $(function() {
        getLocation();
    });
</script>


<script>
    $('.pilihsiswaizin').select2({
        placeholder: "~ Pilih Siswa ~",
        dropdownParent: $('#tambahIzin')
    });

    $('.pilihjadwal').select2({
        placeholder: "~ Pilih Mata Pelajaran ~"
    });

    $('.pilihpegawai').select2({
        placeholder: "~ Pilih Pegawai ~"
    });

    $('.pilihkelas').select2({
        placeholder: "~ Pilih Kelas ~"
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