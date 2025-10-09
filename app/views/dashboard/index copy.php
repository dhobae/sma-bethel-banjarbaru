<?php require APPROOT . '/views/inc/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
   document.addEventListener("DOMContentLoaded", function() {
      var breadPahdi = document.getElementById("bread_pahdi");
      if (breadPahdi) {
         breadPahdi.style.setProperty('display', 'none', 'important');
      }
   });
</script>

<div class="row">
   <div class="col mb-3">
      <div class="card">
         <div class="card-body text-center">
            <div class="row">
               <div class="col-lg-3 mb-2" style="text-align:right">
                  <img src="<?= URLROOT ?>/public/img/logo/baristand.png" width="210px">
               </div>
               <div class="col mb-2 mt-2" style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-weight:bold; line-height:1.5em">
                  <span style=" font-size:2.13em">S I P</span><br />
                  <span style="font-size:1em">Sistem Informasi Perkantoran</span><br />
                  <span style="font-size:1em">Balai Standardisasi dan Pelayanan Jasa Industri Banjarbaru</span><br />
               </div>
               <div class="col-lg-3 mb-2" style="text-align:left">
                  <img src="<?= URLROOT ?>/public/img/logo/BSPJI_baru.png" width="160px">
               </div>
            </div>
         </div>

         <hr style="margin-top:0px; margin-bottom:0px">
         <div class="row">
            <div class="card-body text-center">
               <span style="font-size:1.1em; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                  <b>MAKLUMAT PELAYANAN</b>
               </span><br />
               <span class="blink" style="font-size:0.9em; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                  <b>Dengan ini, Kami Menyatakan Sanggup Menyelenggarakan Pelayanan Sesuai Standar Pelayanan yang Telah ditetapkan dan Apabila Tidak Menepati Janji Ini, Kami Siap Menerima Sanksi Sesuai Peraturan Perundang - Undangan</b>
               </span>
            </div>
         </div>
      </div>
   </div>
</div>

<!------------------------------------------------------------ -->
<div class="row mb-3">
   <div class="col-lg-3 col-md-6 mb-2">
      <div class="card" style="border:1px solid #DDDDDD">
         <div class="card-body">
            <div id="chart_dahsboard_utama"></div>
         </div>
      </div>
   </div>

   <div class="col-lg-9">
      <div class="row">
         <div class="col-lg-4 col-md-6 mb-2">
            <div class="card" style="border:1px solid #DDDDDD">
               <div class="card-body">
                  <div class="row align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Ijin Keluar (<?php echo dateID(date('-m-')) ?>)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($data['ijin_keluar']) ?></div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-warning"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <div class="card" style="border:1px solid #DDDDDD">
               <div class="card-body">
                  <div class="row align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Ijin Lembur (<?php echo dateID(date('-m-')) ?>)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($data['ijin_lembur']) ?></div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-success"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <div class="card" style="border:1px solid #DDDDDD">
               <div class="card-body">
                  <div class="row align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Surat Tugas (<?php echo dateID(date('-m-')) ?>)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($data['surat_tugas']) ?></div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-primary"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <a href="#" id="tombol_kepegawaian" style="text-decoration:none">
               <div class="card" style="border:1px solid #DDDDDD">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col mr-2">
                           <div class="text-xs font-weight-bold text-uppercase mb-1">Informasi</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800">Kepegawaian</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-folder-open fa-2x text-danger"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <a href="#" id="tombol_pnbp" style="text-decoration:none">
               <div class="card" style="border:1px solid #DDDDDD">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col mr-2">
                           <div class="text-xs font-weight-bold text-uppercase mb-1">Informasi</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800">PNBP</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-folder-open fa-2x text-danger"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <a href="#" id="tombol_keuangan" style="text-decoration:none">
               <div class="card" style="border:1px solid #DDDDDD">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col mr-2">
                           <div class="text-xs font-weight-bold text-uppercase mb-1">Informasi</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800">Keuangan</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-folder-open fa-2x text-danger"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <a href="#" id="tombol_spk" style="text-decoration:none">
               <div class="card" style="border:1px solid #DDDDDD">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col mr-2">
                           <div class="text-xs font-weight-bold text-uppercase mb-1">Informasi</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800">SPK Layanan</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-folder-open fa-2x text-danger"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <a href="#" id="tombol_ikm" style="text-decoration:none">
               <div class="card" style="border:1px solid #DDDDDD">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col mr-2">
                           <div class="text-xs font-weight-bold text-uppercase mb-1">Informasi</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800">IKM</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-folder-open fa-2x text-danger"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </a>
         </div>

         <div class="col-lg-4 col-md-6 mb-2">
            <a href="#" id="tombol_pelanggan" style="text-decoration:none">
               <div class="card" style="border:1px solid #DDDDDD">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col mr-2">
                           <div class="text-xs font-weight-bold text-uppercase mb-1">Informasi</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800">Pelanggan</div>
                        </div>
                        <div class="col-auto">
                           <i class="fas fa-folder-open fa-2x text-danger"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </a>
         </div>

      </div>
   </div>

</div>
<!-- ------------------------------------------ -->


<hr />

<?php
$lainnya = $data['total_pegawai']->total_pegawai - ($data['rekap']->pns + $data['rekap']->pppk + $data['rekap']->ppnpn + $data['rekap']->outsourcing);
?>

<?php require APPROOT . '/views/inc/footer.php'; ?>


<!-- PNBP ------------------------------------------------------ -->
<script>
   document.getElementById("tombol_kepegawaian").addEventListener("click", function(event) {
      event.preventDefault();
      $('#kepegawaian').modal('show');
   });
   document.getElementById("tombol_pnbp").addEventListener("click", function(event) {
      event.preventDefault();
      $('#pnbp').modal('show');
   });
   document.getElementById("tombol_keuangan").addEventListener("click", function(event) {
      event.preventDefault();
      $('#keuangan').modal('show');
   });
   document.getElementById("tombol_spk").addEventListener("click", function(event) {
      event.preventDefault();
      $('#spk').modal('show');
   });
   document.getElementById("tombol_ikm").addEventListener("click", function(event) {
      event.preventDefault();
      $('#ikm').modal('show');
   });
   document.getElementById("tombol_pelanggan").addEventListener("click", function(event) {
      event.preventDefault();
      $('#pelanggan').modal('show');
   });
</script>

<div class="modal fade" id="kepegawaian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-body" style="margin-bottom:-40px !important">
            <?php $this->view('tamu/kepegawaian', $data) ?>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="keuangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-body" style="margin-bottom:-40px !important">
            <?php $this->view('tamu/keuangan', $data) ?>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="pnbp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <?php $this->view('tamu/pnbp', $data) ?>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="spk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <?php $this->view('tamu/spk', $data) ?>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="ikm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <?php $this->view('tamu/ikm', $data) ?>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="pelanggan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <?php $this->view('tamu/pelanggan', $data) ?>
         </div>
      </div>
   </div>
</div>









<!--STATUS ----------------------------------------------- -->
<?php
$pns = $data['rekap']->pns;
$pppk = $data['rekap']->pppk;
$ppnpn = $data['rekap']->ppnpn;
$outsourcing = $data['rekap']->outsourcing;

$label_1 = 'PNS (' . $data['rekap']->pns . ')';
$label_2 = 'PPPK (' . $data['rekap']->pppk . ')';
$label_3 = 'PPNPN (' . $data['rekap']->ppnpn . ')';
$label_4 = 'Outsourcing (' . $data['rekap']->outsourcing . ')';
?>
<script>
   var options = {
      series: [<?= $pns ?>, <?= $pppk ?>, <?= $ppnpn ?>, <?= $outsourcing ?>],
      chart: {
         //width: 480,
         height: 310,
         type: 'pie',
         "fontFamily": "verdana",
      },
      colors: ['#E74C3C', '#3498DB', '#2ECC71', '#F1C40F', '#E67E22', '#9B59B6', '#34495E', '#1ABC9C', '#F39C12', '#D35400'],
      legend: {
         show: true,
         position: 'bottom',
         fontFamily: 'Helvetica, Arial',
         fontSize: '11px',
         fontWeight: 600,
      },

      labels: [<?= "'" . $label_1 . "', '" . $label_2 . "', '" . $label_3 . "', '" . $label_4 . "'" ?>],
      tooltip: {
         y: {
            formatter: function(val, opts) {
               var index = opts.seriesIndex;
               var data = [<?= $pns ?>, <?= $pppk ?>, <?= $ppnpn ?>, <?= $outsourcing ?>, <?= $lainnya ?>];
               var label = options.labels[index];
               var value = data[index];
               return value.toLocaleString('id-ID') + ' orang';
            }
         }
      },
      title: {
         text: 'Pegawai BSPJI Bjb',
         align: 'center',
         margin: 10,
         offsetY: 0,
         offsetX: 0,
         floating: false,
         style: {
            fontSize: '14px',
            fontWeight: 'bold',
            fontFamily: undefined,
            color: '#263238'
         },
      },
      responsive: [{
         breakpoint: 480,
         options: {
            chart: {
               width: 200
            },

         }
      }]

   };
   var chart = new ApexCharts(document.querySelector("#chart_dahsboard_utama"), options);
   chart.render();
</script>



<style>
   .blink {
      animation: blink-animation 4s ease-in-out infinite;
      opacity: 0;
   }

   @keyframes blink-animation {
      0% {
         opacity: 0;
      }

      20% {
         opacity: 1;
      }

      80% {
         opacity: 1;
      }

      100% {
         opacity: 0;
      }
   }
</style>