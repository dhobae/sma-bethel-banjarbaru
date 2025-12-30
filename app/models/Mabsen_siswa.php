<?php
class Mabsen_siswa
{
    // KHUSUS RFID SISWA 
    public function __construct()
    {
        $this->db = new Database;
    }

    public function ambil_siswa_by_rfid($rfid)
    {
        $sql = "SELECT * FROM siswa WHERE rfid = :rfid";
        $this->db->query($sql);
        $this->db->bind('rfid', $rfid);
        return $this->db->single();
    }

    public function cek_absen_siswa($nis)
    {
       $tanggal = date("Y-m-d");
       $query = "SELECT absen_harian_siswa.*, libur.keterangan_libur as keterangan from absen_harian_siswa left join libur on absen_harian_siswa.status_ahs=libur.id where absen_harian_siswa.nis_ahs in ('$nis','all') and absen_harian_siswa.tgl_ahs='$tanggal'";
       $this->db->query($query);
       return $this->db->resultSet();
    }

    public function cek_absen_hari_ini($nis)
    {
        $sql = "SELECT * FROM absen_harian_siswa
                WHERE nis_ahs = :nis
                AND tgl_ahs = :tanggal";
        $this->db->query($sql);
        $this->db->bind('nis', $nis);
        $this->db->bind('tanggal', date('Y-m-d'));
        return $this->db->single();
    }

    public function hadir_rfid_siswa($data)
    {
        // Ambil data siswa dari RFID
        $rfid = $data['isi'];
        $siswa = $this->ambil_siswa_by_rfid($rfid);

        if (!$siswa) {
            return false;
        }

        $nis = $siswa->nis;
        $tanggal = date("Y-m-d");

        // Cek apakah sudah absen hari ini
        $cek = $this->cek_absen_hari_ini($nis);
        if ($cek) {
            // Sudah absen, return true tapi tidak insert lagi
            return true;
        }

        // Insert absen masuk
        $query = "INSERT INTO absen_harian_siswa
                  (nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs)
                  VALUES (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs)";

        $this->db->query($query);
        $this->db->bind('nis_ahs', $nis);
        $this->db->bind('tgl_ahs', $tanggal);
        $this->db->bind('status_ahs', 'Hadir');
        $this->db->bind('jam_masuk_ahs', date('H:i:s'));

        return $this->db->execute();
    }


    //  Absen pulang siswa (UPDATE)
    public function pulang_rfid_siswa($data)
    {
        $rfid = $data['isi'];
        $siswa = $this->ambil_siswa_by_rfid($rfid);

        if (!$siswa) {
            return false;
        }

        $nis = $siswa->nis;
        $tanggal = date("Y-m-d");

        $cek = $this->cek_absen_hari_ini($nis);
        if (!$cek) {
            // Belum absen masuk, tidak bisa absen pulang
            return false;
        }

        if (!empty($cek->jam_pulang_ahs)) {
            // Sudah absen pulang
            return true;
        }

        $query = "UPDATE absen_harian_siswa
                  SET jam_pulang_ahs = :jam_pulang_ahs
                  WHERE nis_ahs = :nis_ahs
                  AND tgl_ahs = :tgl_ahs";

        $this->db->query($query);
        $this->db->bind('jam_pulang_ahs', date('H:i:s'));
        $this->db->bind('nis_ahs', $nis);
        $this->db->bind('tgl_ahs', $tanggal);

        return $this->db->execute();
    }

    public function ambil_jam_sekolah() {
        $sql = "SELECT masuk,pulang FROM master_jam ORDER BY berlaku_mulai DESC LIMIT 1";
        $this->db->query($sql);
        return $this->db->single(); // jam masuk 07.30.00 & jam pulang 16.00.00 hasilnya
    }

    // old method
    // public function isi_absen_by_rfid($data)
    // {
    //     $rfid = $data['isi'];
    //     $siswa = $this->ambil_siswa_by_rfid($rfid);

    //     if (!$siswa) {
    //         return false;
    //     }

    //     $nis = $siswa->nis;
    //     $tanggal = date("Y-m-d");

    //     // Cek apakah sudah absen hari ini
    //     $cek = $this->cek_absen_hari_ini($nis);
    //     if ($cek) {
    //         return true;
    //     }

    //     // Insert absen masuk
    //     $query = "INSERT INTO absen_harian_siswa
    //               (nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs)
    //               VALUES (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs)";

    //     $this->db->query($query);
    //     $this->db->bind('nis_ahs', $nis);
    //     $this->db->bind('tgl_ahs', $tanggal);
    //     $this->db->bind('status_ahs', 'Hadir');
    //     $this->db->bind('jam_masuk_ahs', date('H:i:s'));

    //     return $this->db->execute();
    // }
}
