<?php
class Mabsen_siswa
{
    public function __construct()
    {
        $this->db = new Database;
    }

    // KHUSUS RFID SISWA -----------------
    public function ambil_siswa_by_rfid($rfid)
    {
        $sql = "SELECT * from siswa where rfid=:rfid";
        $this->db->query($sql);
        $this->db->bind('rfid', $rfid);
        return $this->db->single();
    }

    public function hadir_rfid_siswa($data)
    {
        $nis = $_SESSION['nik'];
        $tanggal = date("Y-m-d");

        $sudah_absen = "SELECT * from absen_harian_siswa where nis_ahs=:nis and tgl_ahs=:tanggal";
        $this->db->query($sudah_absen);
        $this->db->bind('nis', $nis);
        $this->db->bind('tanggal', $tanggal);
        $result3 = $this->db->resultSet();
        if ($result3) {
            return true;
        }

        $queryupdate = "INSERT INTO absen_harian_siswa (nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs) values (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs)";
        $this->db->query($queryupdate);
        $this->db->bind('nis_ahs', $nis);
        $this->db->bind('tgl_ahs', $tanggal);
        $this->db->bind('status_ahs', 'Hadir');
        $this->db->bind('jam_masuk_ahs', date('H:i:s'));
        $this->db->execute();

        return true;
    }

    public function isi_absen_by_rfid($data)
    {
        $rfid = $data['isi'];
        $cari1 = "SELECT nis from siswa where rfid=:rfid";
        $this->db->query($cari1);
        $this->db->bind('rfid', $rfid);
        $result_cari1 = $this->db->single();

        $nis = $result_cari1->nis;
        $tanggal = date("Y-m-d");

        $sudah_absen = "SELECT * from absen_harian_siswa where nis_ahs=:nis and tgl_ahs=:tanggal";
        $this->db->query($sudah_absen);
        $this->db->bind('nis', $nis);
        $this->db->bind('tanggal', $tanggal);
        $result3 = $this->db->resultSet();
        if ($result3) {
            return true;
        }

        $queryupdate = "INSERT INTO absen_harian_siswa (nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs) values (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs)";
        $this->db->query($queryupdate);
        $this->db->bind('nis_ahs', $nis);
        $this->db->bind('tgl_ahs', $tanggal);
        $this->db->bind('status_ahs', 'Hadir');
        $this->db->bind('jam_masuk_ahs', date('H:i:s'));
        $this->db->execute();

        return true;
    }

    public function cek_absen_rfid($nis)
    {
        $sql = "SELECT * from absen_harian_siswa where nis_ahs=:nis and tgl_ahs=:tanggal";
        $this->db->query($sql);
        $this->db->bind('nis', $nis);
        $this->db->bind('tanggal', date('Y-m-d'));
        return $this->db->single();
    }
}
