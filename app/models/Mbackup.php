<?php
class Mbackup
{
    public function __construct()
    {
        $this->db = new Database;
    }

    public function aktif()
    {
        $sql = "SELECT pengunjung.*, pegawai.nama as namadosen from pengunjung left join pegawai on pengunjung.npk=pegawai.nik order by tanggal DESC, online desc";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function simpan_pendapat($data)
    {
        $sql = "INSERT into pendapat (id_pendapat, nik_pendapat, pendapat, saran) values (:id_pendapat, :nik_pendapat, :pendapat, :saran)";
        $this->db->query($sql);
        $this->db->bind('id_pendapat', NULL);
        $this->db->bind('nik_pendapat', $_SESSION['nik']);
        $this->db->bind('pendapat', $data['pendapat']);
        $this->db->bind('saran', $data['saran']);
        $this->db->execute();
        return true;
    }

    public function pendapat()
    {
        $sql = "SELECT * from pendapat order by id_pendapat DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function notif()
    {
        $sql = "SELECT * from notif where id_notif='1'";
        $this->db->query($sql);
        return $this->db->single();
    }

    public function simpan_notif($data)
    {
        $sql = "UPDATE notif set status_notif=:status_notif, icon=:icon, title=:title, text=:teks, isi_tombol=:isi_tombol, warna_tombol=:warna_tombol, background=:background, warna_title=:warna_title, warna_konten=:warna_konten WHERE id_notif='1'";
        $this->db->query($sql);
        $this->db->bind('status_notif', $data['status_notif']);
        $this->db->bind('icon', $data['icon']);
        $this->db->bind('title', $data['title']);
        $this->db->bind('teks', $data['teks']);
        $this->db->bind('isi_tombol', $data['isi_tombol']);
        $this->db->bind('warna_tombol', $data['warna_tombol']);
        $this->db->bind('background', $data['background']);
        $this->db->bind('warna_title', $data['warna_title']);
        $this->db->bind('warna_konten', $data['warna_konten']);
        $this->db->execute();
        return true;
    }

    public function kirim_notif_datang()
    {
        $sql = "SELECT pegawai.nama, pegawai.nomor_hp, absen.status_masuk, absen.nik, absen.tanggal FROM pegawai LEFT JOIN send_wa on pegawai.nik=send_wa.nik_send_wa LEFT JOIN absen ON pegawai.nik = absen.nik AND absen.tanggal = CURDATE() WHERE absen.tanggal IS NULL AND pegawai.nomor_hp LIKE '0%' and send_wa.notif_datang='1'";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function kirim_notif_pulang()
    {
        $sql = "SELECT pegawai.nama, pegawai.nomor_hp, absen.status_masuk, absen.nik, absen.tanggal FROM pegawai LEFT JOIN send_wa on pegawai.nik=send_wa.nik_send_wa LEFT JOIN absen ON pegawai.nik = absen.nik where absen.tanggal = CURDATE() and pegawai.nomor_hp LIKE '0%' and status_masuk='Hadir' and jam_pulang='00:00:00' and send_wa.notif_pulang='1'";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function hari_ini()
    {
        $sql = "select * from absen where tanggal=curdate() and nik='all';";
        $this->db->query($sql);
        return $this->db->single();
    }
}
