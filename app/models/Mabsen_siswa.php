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
        $tanggal = date('Y-m-d');

        // FIX: Ganti raw string interpolation ke prepared statement (cegah SQL injection)
        $sql = "SELECT ahs.*, l.keterangan_libur AS keterangan
                FROM absen_harian_siswa ahs
                LEFT JOIN libur l ON ahs.status_ahs = l.id
                WHERE ahs.nis_ahs IN (:nis, 'all')
                AND ahs.tgl_ahs = :tanggal";

        $this->db->query($sql);
        $this->db->bind('nis', $nis);
        $this->db->bind('tanggal', $tanggal);
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

    // FIX: Terima $nis langsung — tidak perlu baca RFID lagi dari $_POST
    public function hadir_rfid_siswa($data)
    {
        $sql = "INSERT INTO absen_harian_siswa
                    (nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs, kelas_ahs, wali_kelas_ahs, id_jadwal_setting_ahs)
                VALUES
                    (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs, :kelas_ahs, :wali_kelas_ahs, :id_jadwal_setting_ahs)";

        $this->db->query($sql);
        $this->db->bind('nis_ahs', $data['nis']);
        $this->db->bind('tgl_ahs', date('Y-m-d'));
        $this->db->bind('status_ahs', 'Hadir');
        $this->db->bind('jam_masuk_ahs', date('H:i:s'));
        $this->db->bind('kelas_ahs', $data['kelas']);
        $this->db->bind('wali_kelas_ahs', $data['wali_kelas']);
        $this->db->bind('id_jadwal_setting_ahs', $data['id_jadwal_setting']);
    

        return $this->db->execute();
    }

    // FIX: Terima $nis langsung — tidak perlu baca RFID lagi dari $_POST
    public function pulang_rfid_siswa($nis)
    {
        $sql = "UPDATE absen_harian_siswa
                SET jam_pulang_ahs = :jam_pulang_ahs
                WHERE nis_ahs = :nis_ahs
                AND tgl_ahs = :tgl_ahs";

        $this->db->query($sql);
        $this->db->bind('jam_pulang_ahs', date('H:i:s'));
        $this->db->bind('nis_ahs', $nis);
        $this->db->bind('tgl_ahs', date('Y-m-d'));

        return $this->db->execute();
    }

    public function ambil_jam_sekolah()
    {
        $sql = "SELECT masuk, pulang FROM master_jam ORDER BY berlaku_mulai DESC LIMIT 1";
        $this->db->query($sql);
        return $this->db->single();
    }

    public function ambil_wali_kelas_nik($kelas)
    {
        $sql = "SELECT DISTINCT wali_kelas FROM jadwal_lengkap WHERE kode_kelas = :kode_kelas";
        $this->db->query($sql);
        $this->db->bind('kode_kelas', $kelas);
        return $this->db->single();
    }
}