<?php
$loc = explode(",", $_GET['data']);
echo 'Lokasi: ' . $_GET['data'];
?>
<div id="map" style="height: 300px; "></div>

<script type="text/javascript">
    $(function() {
        var map = L.map('map').setView([<?php echo $loc[0]; ?>, <?php echo $loc[1]; ?>], 16);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([<?php echo $loc[0]; ?>, <?php echo $loc[1]; ?>]).addTo(map);
    });
</script>