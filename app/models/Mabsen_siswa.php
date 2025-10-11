<?php
class Mabsen_siswa
{
    public function __construct()
    {
        $this->db = new Database;
    }

    // KHUSUS RFID SISWA -----------------

    /**
     * Ambil data siswa berdasarkan RFID
     */
    public function ambil_siswa_by_rfid($rfid)
    {
        $sql = "SELECT * FROM siswa WHERE rfid = :rfid";
        $this->db->query($sql);
        $this->db->bind('rfid', $rfid);
        return $this->db->single();
    }

    /**
     * Cek apakah siswa sudah absen hari ini
     */
    public function cek_absen_rfid($nis)
    {
        $sql = "SELECT * FROM absen_harian_siswa
                WHERE nis_ahs = :nis
                AND tgl_ahs = :tanggal";
        $this->db->query($sql);
        $this->db->bind('nis', $nis);
        $this->db->bind('tanggal', date('Y-m-d'));
        return $this->db->single();
    }

    /**
     * Absen masuk siswa (INSERT)
     */
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
        $cek = $this->cek_absen_rfid($nis);
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

    /**
     * Absen pulang siswa (UPDATE)
     */
    public function pulang_rfid_siswa($data)
    {
        // Ambil data siswa dari RFID
        $rfid = $data['isi'];
        $siswa = $this->ambil_siswa_by_rfid($rfid);

        if (!$siswa) {
            return false;
        }

        $nis = $siswa->nis;
        $tanggal = date("Y-m-d");

        // Cek apakah sudah absen masuk hari ini
        $cek = $this->cek_absen_rfid($nis);
        if (!$cek) {
            // Belum absen masuk, tidak bisa absen pulang
            return false;
        }

        // Cek apakah sudah absen pulang
        if (!empty($cek->jam_pulang_ahs)) {
            // Sudah absen pulang
            return true;
        }

        // Update jam pulang
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

    /**
     * Method lama - bisa dihapus jika tidak digunakan
     */
    public function isi_absen_by_rfid($data)
    {
        $rfid = $data['isi'];
        $siswa = $this->ambil_siswa_by_rfid($rfid);

        if (!$siswa) {
            return false;
        }

        $nis = $siswa->nis;
        $tanggal = date("Y-m-d");

        // Cek apakah sudah absen hari ini
        $cek = $this->cek_absen_rfid($nis);
        if ($cek) {
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
}
