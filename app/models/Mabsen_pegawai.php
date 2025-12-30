<?php
class Mabsen_pegawai
{
    // KHUSUS RFID PEGAWAI
    public function __construct()
    {
        $this->db = new Database;
    }

    public function ambil_pegawai_by_rfid($rfid)
    {
        $sql = "SELECT * FROM pegawai WHERE rfid = :rfid";
        $this->db->query($sql);
        $this->db->bind('rfid', $rfid);
        return $this->db->single();
    }

    public function cek_absen($nik)
    {
       $tanggal = date("Y-m-d");
       $query = "SELECT absen.*, libur.keterangan_libur as keterangan from absen left join libur on absen.from_masuk=libur.id where absen.nik in ('$nik','all') and absen.tanggal='$tanggal'";
       $this->db->query($query);
       return $this->db->resultSet();
    }

    public function cek_absen_hari_ini($nik)
    {
        $sql = "SELECT * FROM absen
                WHERE nik = :nik
                AND tanggal = :tanggal
                LIMIT 1";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        $this->db->bind('tanggal', date('Y-m-d'));
        return $this->db->single();
    }

    public function absen_masuk($data)
    {
        $nik = $data['nik'];
        $tanggal = isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d');

        // Cek apakah sudah absen hari ini
        $cek = $this->cek_absen_hari_ini($nik);
        if ($cek) {
            // Sudah absen, return true tapi tidak insert lagi
            return true;
        }

        // Insert absen masuk
        $query = "INSERT INTO absen
                  (nik, tanggal, jam_masuk, status_masuk, from_masuk, loc_masuk, keterangan)
                  VALUES
                  (:nik, :tanggal, TIME(:jam_masuk), :status_masuk, :from_masuk, :loc_masuk, :keterangan)";

        $this->db->query($query);
        $this->db->bind('nik', $nik);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('jam_masuk', date('H:i:s'));
        $this->db->bind('status_masuk', 'Hadir');
        $this->db->bind('from_masuk', $data['from_masuk']);

        // Loc_masuk boleh NULL jika tidak ada koordinat
        if (!empty($data['loc_masuk'])) {
            $this->db->bind('loc_masuk', $data['loc_masuk']);
        } else {
            $this->db->bind('loc_masuk', null);
        }

        $this->db->bind('keterangan', $data['keterangan']);

        return $this->db->execute();
    }

    public function absen_pulang($data)
    {
        $nik = $data['nik'];
        $tanggal = isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d');

        // Cek apakah sudah absen masuk hari ini
        $cek = $this->cek_absen_hari_ini($nik);
        if (!$cek) {
            return false; // Belum absen masuk
        }

        // Cek apakah sudah absen pulang
        if (!empty($cek->jam_pulang)) {
            return true; // Sudah absen pulang
        }

        // Update jam pulang
        $query = "UPDATE absen
                  SET jam_pulang = TIME(:jam_pulang),
                      status_pulang = :status_pulang,
                      from_pulang = :from_pulang,
                      loc_pulang = :loc_pulang,
                      keterangan = CONCAT(IFNULL(keterangan, ''), ' | ', :keterangan)
                  WHERE nik = :nik
                  AND tanggal = :tanggal";

        $this->db->query($query);
        $this->db->bind('jam_pulang', date('H:i:s'));
        $this->db->bind('status_pulang', 'Pulang');
        $this->db->bind('from_pulang', $data['from_pulang']);
        $this->db->bind('loc_pulang', !empty($data['loc_pulang']) ? $data['loc_pulang'] : null);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->bind('nik', $nik);
        $this->db->bind('tanggal', $tanggal);

        return $this->db->execute();
    }

    public function ambil_jam_kerja() {
        $sql = "SELECT masuk,pulang FROM master_jam ORDER BY berlaku_mulai DESC LIMIT 1";
        $this->db->query($sql);
        return $this->db->single(); // jam masuk 07.30.00 & jam pulang 16.00.00 hasilnya
    }
}