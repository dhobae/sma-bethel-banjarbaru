<div class="card card-primary card-outline" style="margin-top:10px;">
    <div class="card-body box-profile">

        <div class="bg-danger col-sm-6 mb-1" style="margin:auto; padding:10px 25px;">
            <b>Perhatian :</b><br />
            <ul style="margin-bottom:0px; padding-left:20px">
                <li>Sebelum mengisikan presensi, pastikan terlebih dahulu pada tanggal yang ditambahkan pegawai tersebut memang belum mengisi presensi</li>
                <li>Isikan presensi boleh hanya mengisi <b>Jam Masuk</b> dan <b>Status Masuk</b> saja, nanti pegawai bersangkutan yang akan mengisi presensi pulangnya</li>
                <li>Pastikan tanggal diplih bukan tanggal libur, dan bukan hari sabtu dan minggu</li>
            </ul>
        </div>

        <div class="bg-danger col-sm-6" style="background-color:red; margin:auto; padding:25px;">

            <div class="mb-3">
                <h5><b>Isikan Presensi Pegawai</b></h5>
            </div>

            <form method="POST" action="<?= URLROOT ?>/presensi/simpan_isikan_absen">
                <table class="table tabel2" style="color:white !important">
                    <tr>
                        <td style="width:120px">NIK / Nama</td>
                        <td style="width:20px">:</td>
                        <td>
                            <select name="nik" required style="height:28px">
                                <option value="">Pilih Pegawai</option>
                                <?php foreach ($data['pegawai'] as $d) : ?>
                                    <option value="<?= $d->nik ?>"><?= $d->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>
                            <input type="date" name="tanggal" id="datePicker" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Jam Masuk</td>
                        <td>:</td>
                        <td>
                            <input type="time" name="jam_masuk" style="width:120px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Status Masuk</td>
                        <td>:</td>
                        <td>
                            <select name="from_masuk" style="width:100px; height:28px" required>
                                <option value="-">-</option>
                                <option value="WFO">WFO</option>
                                <option value="WFH">WFH</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Jam Pulang</td>
                        <td>:</td>
                        <td>
                            <input type="time" name="jam_pulang" style="width:120px">
                        </td>
                    </tr>

                    <tr>
                        <td>Status Pulang</td>
                        <td>:</td>
                        <td>
                            <select name="from_pulang" style="width:100px; height:28px">
                                <option value="-">-</option>
                                <option value="WFO">WFO</option>
                                <option value="WFH">WFH</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success btn-sm tombol2" title="Simpan Data"><i class="fa fa-save"></i> &nbsp;Simpan</button>

                    <a href="<?= URLROOT ?>/presensi/today" class="btn btn-warning btn-sm tombol2" title="Kembali"><i class="fa fa-undo"></i> &nbsp;Kembali</a>

                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var datePicker = document.getElementById('datePicker');

        datePicker.addEventListener('input', function() {
            var selectedDate = new Date(datePicker.value);
            var dayOfWeek = selectedDate.getDay(); // 0 for Sunday, 1 for Monday, ..., 6 for Saturday

            // Disable selection if Saturday (6) or Sunday (0)
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                alert('Hari Sabtu dan Minggu tidak dapat dipilih.');
                datePicker.value = ''; // Reset the value
            }
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteData(id) {
        //console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data presensi pegawai bersangkutan akan dihapus, dan pegawai diharuskkan untuk absen ulang",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ye, reset!",
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= URLROOT ?>/presensi/reset_absen?id=' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.message,
                                icon: 'success'
                            }).then((result) => {
                                //location.reload();
                                window.location.href = '<?= URLROOT ?>/presensi/today';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    }
</script>