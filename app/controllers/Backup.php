<?php
class Backup extends Controller
{

    public function __construct()
    {
        //if (!isLoggedIn()) {
        //    return redirect('auth/login');
        //}
        //new model instance
        $this->Mbackup = $this->model('Mbackup');
    }

    public function index()
    {
        $data['aktif'] = $this->Mbackup->aktif();
        require APPROOT . '/views/inc/header.php';
        $this->view('backup/aktif', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function notif()
    {
        $data['notif'] = $this->Mbackup->notif();
        require APPROOT . '/views/inc/header.php';
        $this->view('backup/notif', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_notif()
    {
        //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mbackup->simpan_notif($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('backup/notif');
        } else {
            setFlash('Gagal gagal tersimpan.', 'error');
            return redirect('backup/notif');
        }
    }

    public function pendapat_saya()
    {
        require APPROOT . '/views/inc/header.php';
        $this->view('backup/pendapat_saya');
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_pendapat()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mbackup->simpan_pendapat($_POST)) {
            setFlash('Pendapat dan saran anda berhasil terkirim.', 'success');
            return redirect('backup/pendapat_saya');
        } else {
            setFlash('Gagal gagal tersimpan.', 'error');
            return redirect('backup/pendapat_saya');
        }
    }

    public function pendapat_pegawai()
    {
        $data['pendapat'] = $this->Mbackup->pendapat();
        require APPROOT . '/views/inc/header.php';
        $this->view('backup/pendapat_pegawai', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function kirim_notif()
    {
        $hari_ini = $this->Mbackup->hari_ini();
        if (!$hari_ini) {
            $kirim_notif = $this->Mbackup->kirim_notif_datang();
            var_dump($kirim_notif);
            foreach ($kirim_notif as $d) {
                $data['no_telp'] = $d->nomor_hp;
                $data['isi_pesan'] = "[Presensi Skatel BJB].\n\nSelamat Pagi " . $d->nama . " anda belum mengisi Presensi Datang hari ini, anda bisa mengisi Presensi pada aplikasi presensi";
                //notifWA($data);
            }
        }
    }

    public function kirim_notif_pulang()
    {
        $hari_ini = $this->Mbackup->hari_ini();
        if (!$hari_ini) {
            $kirim_notif = $this->Mbackup->kirim_notif_pulang();
            foreach ($kirim_notif as $d) {
                $data['no_telp'] = $d->nomor_hp;
                $data['isi_pesan'] = "[Presensi Skatel BJB].\n\nSelamat Sore " . $d->nama . " anda belum mengisi Presensi Pulang hari ini, anda bisa mengisi Presensi pada aplikasi presensi";
                notifWA($data);
            }
        }
    }
}
