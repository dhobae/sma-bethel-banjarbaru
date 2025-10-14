<?php
class Mabsen_pegawai
{
    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Ambil data pegawai berdasarkan RFID
     */
    public function ambil_pegawai_by_rfid($rfid)
    {
        $sql = "SELECT * FROM pegawai WHERE rfid = :rfid";
        $this->db->query($sql);
        $this->db->bind('rfid', $rfid);
        return $this->db->single();
    }

    /**
     * Cek IP Address apakah termasuk dalam subnet yang terdaftar
     * Mendukung format CIDR (contoh: 192.168.40.0/24)
     */
    public function cek_ip_address($client_ip)
    {
        // Ambil semua IP yang terdaftar
        $sql = "SELECT * FROM ip_address";
        $this->db->query($sql);
        $registered_ips = $this->db->resultSet();

        // Cek apakah client IP cocok dengan salah satu subnet
        foreach ($registered_ips as $ip_data) {
            $registered_ip = $ip_data->ip_address;

            // Cek apakah IP dalam format CIDR (ada /24, /16, dll)
            if (strpos($registered_ip, '/') !== false) {
                // Format CIDR - cek apakah client IP dalam subnet ini
                if ($this->ip_in_range($client_ip, $registered_ip)) {
                    return $ip_data;
                }
            } else {
                // Format IP biasa - cek exact match
                if ($client_ip == $registered_ip) {
                    return $ip_data;
                }
            }
        }

        return null; // IP tidak terdaftar
    }

    /**
     * Fungsi helper untuk mengecek apakah IP ada dalam range CIDR
     * Contoh: ip_in_range('192.168.40.50', '192.168.40.0/24') = true
     */
    private function ip_in_range($client_ip, $cidr)
    {
        // Pisahkan IP dan prefix (contoh: 192.168.40.0/24)
        list($subnet, $mask) = explode('/', $cidr);

        // Konversi IP ke format long integer
        $client_ip_long = ip2long($client_ip);
        $subnet_long = ip2long($subnet);

        // Hitung netmask
        $mask_long = -1 << (32 - (int) $mask);

        // Buat subnet mask dalam format long
        $subnet_long &= $mask_long;

        // Cek apakah client IP dalam range
        return ($client_ip_long & $mask_long) == $subnet_long;
    }

    /**
     * Cek apakah pegawai sudah absen hari ini
     */
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

    /**
     * Absen masuk pegawai (INSERT)
     */
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

    /**
     * Absen pulang pegawai (UPDATE)
     */
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
}