<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Jadwal Pelajaran SMA Bethel Banjarbaru
      </div>

      <ul class="nav nav-tabs" id="myTabs">
         <li class="nav-item">
            <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">XA</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="tab2" data-toggle="tab" href="#content2">XB</a>
         </li>
      </ul>

      <div class="tab-content mt-2">
         <!-- TAB XA ------------------------- -->
         <div class="tab-pane fade show active mt-3" id="content1">
            <?php
            $this->view('jadwal/xa', $data);
            ?>
         </div>

         <!-- TAB XB ------------------------- -->
         <div class="tab-pane fade mt-3" id="content2">
            <?php
            $this->view('jadwal/xb', $data);
            ?>
         </div>

      </div>

      <style>
         .nav-tabs .nav-link {
            border: 1px solid #ddd;
            border-radius: 5px 5px 0px 0px;
            color: #333;
            background-color: #f8f9fa;
            margin-right: 2px;
            font-family: 'calibri';
            padding: 1px 20px;
         }

         .nav-tabs .nav-link.active {
            color: #fff;
            background-color: green;
            border-color: #007bff;
         }
      </style>


   </div>
</div>