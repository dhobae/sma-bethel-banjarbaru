<?php
class Absen_siswa extends Controller
{

    public function __construct()
    {
        //if (!isLoggedIn()) {
        //    return redirect('auth/login');
        //}
        //new model instance
        $this->Mabsen_siswa = $this->model('Mabsen_siswa');
    }

    public function index()
    {
        $this->view('khusus/index');
    }

    // KHUSUS RFID --------------------------------
    public function ambil_siswa_by_rfid()
    {
        $isi = $_POST['isi'];

        $data['ada_data'] = $this->Mabsen_siswa->ambil_siswa_by_rfid($isi);

        if (!$data['ada_data']) {
            echo "error";
            return;
        } else {
            $nis = $data['ada_data']->nis;
            $data['cek_absen'] = $this->Mabsen_siswa->cek_absen_rfid($nis);
            if (!$data['cek_absen']) {
                $data['absen_datang'] = 'belum';
            } else {
                $data['absen_datang'] = 'sudah';
            }
        }

        $this->view('dashboard/isi_form_absen', $data);
    }

    public function hadir_rfid_siswa()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($_POST['absen_datang'] == 'belum') {
            if ($this->Mabsen_siswa->hadir_rfid_siswa($_POST)) {
                setFlash('Presensi Hadir berhasil.', 'success');
               return redirect('dashboard');
            } else {
                setFlash('Gagal melakukan presensi.', 'danger');
                return redirect('dashboard');
            }
        } else {
            if ($this->Mabsen_siswa->pulang_rfid_siswa($_POST)) {
                setFlash('Presensi Pulang berhasil.', 'success');
                return redirect('dashboard');
            } else {
                setFlash('Gagal melakukan presensi.', 'danger');
                return redirect('dashboard');
            }
        }
    }

    public function isi_absen_by_rfid()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mabsen_siswa->isi_absen_by_rfid($_POST)) {
            setFlash('Presensi Hadir berhasil.', 'success');
            //return redirect('absen_siswa');
        } else {
            setFlash('Gagal melakukan presensi.', 'danger');
            //return redirect('absen_siswa');
        }
    }
}
