<?php
class Mdar
{
    public function __construct()
    {
        $this->db = new Database;
    }

    public function dar_saya($nik, $bulan, $tahun)
    {
        $sql = "SELECT * from dar where nik_dar=:nik and month(tanggal_dar)=:bulan and year(tanggal_dar)=:tahun order by tanggal_dar";
        $this->db->query($sql);
        $this->db->bind(':nik', $nik);
        $this->db->bind(':bulan', $bulan);
        $this->db->bind(':tahun', $tahun);
        return $this->db->resultSet();
    }

    public function dar_pertanggal_saya($tanggal)
    {
        $nik = $_SESSION['nik'];
        $sql = "SELECT * from dar where nik_dar=:nik and tanggal_dar=:tanggal";
        $this->db->query($sql);
        $this->db->bind(':nik', $nik);
        $this->db->bind(':tanggal', $tanggal);
        return $this->db->single();
    }

    public function cek_isi($nik, $tanggal)
    {
        $this->db->query("SELECT * FROM dar WHERE nik_dar=:nik AND tanggal_dar=:tanggal");
        $this->db->bind('nik', $nik);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->single();
    }

    public function simpan_isi($dataField, $nik, $tanggal)
    {
        $sqlCopy = "INSERT INTO dar (nik_dar, tanggal_dar, isi_dar, waktu_input) value (:nik_dar, :tanggal_dar, :isi_dar, :waktu_input)";
        $this->db->query($sqlCopy);
        $this->db->bind('isi_dar', $dataField);
        $this->db->bind('nik_dar', $nik);
        $this->db->bind('tanggal_dar', $tanggal);
        $this->db->bind('waktu_input', date('Y-m-d H:i:s'));
        return $this->db->execute();
    }

    public function update_isi($dataField, $nik, $tanggal)
    {
        $sqlCopy = "UPDATE dar set isi_dar=:isi where nik_dar=:nik and tanggal_dar=:tanggal";
        $this->db->query($sqlCopy);
        $this->db->bind('isi', $dataField);
        $this->db->bind('nik', $nik);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->execute();
    }

    //--- admin -----------------------------------
    public function pegawai()
    {
        $sql = "SELECT nik, nama from pegawai where nama!= '' and dar='Ya' order by nama";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function dar_pertanggal_karyawan($tanggal, $nik)
    {
        $sql = "SELECT * from dar where nik_dar=:nik and tanggal_dar=:tanggal";
        $this->db->query($sql);
        $this->db->bind(':nik', $nik);
        $this->db->bind(':tanggal', $tanggal);
        return $this->db->single();
    }

    //--- admin -----------------------------------
    public function wajib_dar()
    {
        $sql = "SELECT nik, nama, dar from pegawai where dar='Ya' and hapus_pegawai='0' and full_time='Full Time' order by nama";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function tidak_wajib_dar()
    {
        $sql = "SELECT nik, nama, dar from pegawai where dar='Tidak' and hapus_pegawai='0' and full_time='Full Time' order by nama";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    //---wajib------------------------------------
    public function hidupkan_dar($data)
    {
        $sql = "UPDATE pegawai set dar=:dar where nik=:nik";
        $this->db->query($sql);
        $this->db->bind(':dar', 'Ya');
        $this->db->bind(':nik', $data['nik']);
        $this->db->execute();
        return true;
    }

    public function matikan_dar($data)
    {
        $sql = "UPDATE pegawai set dar=:dar where nik=:nik";
        $this->db->query($sql);
        $this->db->bind(':dar', 'Tidak');
        $this->db->bind(':nik', $data['nik']);
        $this->db->execute();
        return true;
    }
}
