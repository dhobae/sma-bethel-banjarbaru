<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
    <div class="card-body box-profile">

        <div class="text-center">
            <h5><b>Jadwal Pelajaran</b></h5>
            <div style="font-weight:bold">
                Kelas &nbsp;:&nbsp; <?= $data['jadwal']->kelas ?><?= $data['jadwal']->ruang ?>
            </div>
            <div class="mb-3" style="font-weight:bold">
                Hari &nbsp;:&nbsp; <?= $data['jadwal']->hari ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 center">
                <form method="POST" action="<?= URLROOT ?>/jadwal/simpan_edit_jadwal">
                    <div>
                        <table class="table tabel1">
                            <thead style="height:40px">
                                <tr>
                                    <th style="width:60px" class="text-center">Jam Ke</th>
                                    <th style="width:30%" class="text-center">Mata Pelajaran</th>
                                    <th class="text-center">Guru Pengajar</th>
                                </tr>
                            </thead>
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                            <tr>
                                <input type="hidden" name="id_jadwal_lengkap"
                                    value="<?= $data['jadwal']->id_jadwal_lengkap ?>">
                                <input type="hidden" name="kelasnya"
                                    value="<?= $data['jadwal']->kelas ?><?= $data['jadwal']->ruang ?>">
                                <input type="hidden" name="nik_lama_validasi_oleh" value="<?= $data['jadwal']->validasi_oleh ?>">
                                <td class="text-center" style="vertical-align: middle">
                                    <?= $i ?>
                                </td>
                                <td>
                                    <select name="mp<?= $i ?>" style="width:100%" class="jadwal pilihjadwal"
                                        multiple="multiple">
                                        <option value="">~Pilih~</option>
                                        <?php foreach ($data['pelajaran'] as $p) : ?>
                                        <option value="<?= $p->id_pelajaran ?>"
                                            <?= ($p->id_pelajaran === $data['jadwal']->{'mp' . $i}) ? 'selected' : '' ?>>
                                            <?= $p->mata_pelajaran ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <!--
                              <select name="guru<?= $i ?>[]" style="width:100%" class="jadwal pilihguru" multiple="multiple">
                                 <option value="">~Pilih~</option>
                                 <?php foreach ($data['guru'] as $g) : ?>
                                    <option value="<?= $g->nik ?>" <?= ($g->nik === $data['jadwal']->{'guru' . $i}) ? 'selected' : '' ?>><?= $g->nama ?></option>
                                 <?php endforeach; ?>
                              </select>
                              -->

                                    <select name="guru<?= $i ?>[]" style="width:100%" class="jadwal pilihguru"
                                        multiple="multiple">
                                        <option value="">~Pilih~</option>
                                        <?php foreach ($data['guru'] as $g) : ?>
                                        <?php
                                    $selected = in_array($g->nik, explode(",", $data['jadwal']->{'guru' . $i}));
                                    ?>
                                        <option value="<?= $g->nik ?>" <?= ($selected ? 'selected' : '') ?>>
                                            <?= $g->nama ?></option>
                                        <?php endforeach; ?>
                                    </select>


                                </td>
                            </tr>
                            <?php } ?>

                        </table>
                    </div>
                    <a href="<?= URLROOT ?>/jadwal/jadwal?kelas=<?= $data['jadwal']->kelas ?><?= $data['jadwal']->ruang ?>"
                        title="Kembali" class="btn btn-danger btn-sm tombol3">Kembali</a>
                    <button type="submit" class="btn btn-success btn-sm tombol3" title="Simpan jadwal">Simpan
                        Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/*
   .select2-container--default .select2-selection--single {
      height: 30px;
      padding: 2px 8px;
      border-radius: 0px;
      color: red;
   }

   .select2-container--default .select2-selection--single .select2-selection__rendered {
      font-weight: bold;
   }

   .select2-container--default .select2-search--dropdown .select2-search__field {
      color: white;
      background-color: brown;
   }
   */
</style>