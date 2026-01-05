<?php

class Mjadwal_otomatis
{
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMataPelajaran()
    {
        $sql = "SELECT * from m_pelajaran order by mata_pelajaran";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getJadwalSettingAktif()
    {
        $sql = "SELECT 
            js.*,
            ta.tahun_ajaran
        FROM jadwal_setting js
        JOIN m_tahun_ajaran ta ON js.id_tahun_ajaran = ta.id_tahun_ajaran
        WHERE js.status = 1
        ORDER BY js.id_tahun_ajaran DESC, js.semester DESC, js.blok DESC
        LIMIT 1";

        $this->db->query($sql);
        return $this->db->single();
    }

    public function getOrCreateTahunAjaran($tahunAjaran)
    {
        // Cek apakah tahun ajaran sudah ada
        $this->db->query("SELECT * FROM m_tahun_ajaran WHERE tahun_ajaran = :tahun_ajaran");
        $this->db->bind(':tahun_ajaran', $tahunAjaran);
        $existing = $this->db->single();

        if ($existing) {
            // Jika tahun ajaran sudah ada, set statusnya menjadi aktif (1) dan nonaktifkan yang lain
            $this->db->query("UPDATE m_tahun_ajaran SET status = 0");
            $this->db->execute();

            $this->db->query("UPDATE m_tahun_ajaran SET status = 1 WHERE id_tahun_ajaran = :id_tahun_ajaran");
            $this->db->bind(':id_tahun_ajaran', $existing->id_tahun_ajaran);
            $this->db->execute();

            error_log("CONTROLLER: Tahun ajaran $tahunAjaran diaktifkan (ID: {$existing->id_tahun_ajaran})");
            return $existing->id_tahun_ajaran;
        }

        // Non-aktifkan semua tahun ajaran lain
        $this->db->query("UPDATE m_tahun_ajaran SET status = 0");
        $this->db->execute();

        // Buat tahun ajaran baru dengan status aktif (1)
        $this->db->query("INSERT INTO m_tahun_ajaran (tahun_ajaran, status) VALUES (:tahun_ajaran, 1)");
        $this->db->bind(':tahun_ajaran', $tahunAjaran);

        if ($this->db->execute()) {
            $newId = $this->db->lastInsertId();
            error_log("CONTROLLER: Tahun ajaran baru dibuat dan diaktifkan: $tahunAjaran (ID: $newId)");
            return $newId;
        }

        return null;
    }

    public function getOrCreateJadwalSetting($idTahunAjaran, $semester, $blok, $berlakuDari, $tanggalDirubah)
    {
        // Cek apakah kombinasi sudah ada
        $this->db->query("SELECT * FROM jadwal_setting 
                         WHERE id_tahun_ajaran = :id_tahun_ajaran 
                         AND semester = :semester 
                         AND blok = :blok");
        $this->db->bind(':id_tahun_ajaran', $idTahunAjaran);
        $this->db->bind(':semester', $semester);
        $this->db->bind(':blok', $blok);
        $existing = $this->db->single();

        if ($existing) {
            $this->db->query("UPDATE jadwal_setting SET status = 0");
            $this->db->execute();
            // Update yang sudah ada
            $this->db->query("UPDATE jadwal_setting 
                            SET berlaku_dari = :berlaku_dari,
                                tanggal_dirubah = :tanggal_dirubah,
                                status = 1
                            WHERE id_jadwal_setting = :id");
            $this->db->bind(':berlaku_dari', $berlakuDari);
            $this->db->bind(':tanggal_dirubah', $tanggalDirubah);
            $this->db->bind(':id', $existing->id_jadwal_setting);
            $this->db->execute();

            error_log("CONTROLLER: Jadwal setting diupdate exiting (ID: {$existing->id_jadwal_setting})");
            return $existing->id_jadwal_setting;
        }

        $this->db->query("UPDATE jadwal_setting SET status = 0");
        $this->db->execute();

        $this->db->query("INSERT INTO jadwal_setting 
                         (id_tahun_ajaran, semester, blok, berlaku_dari, tanggal_dirubah, status) 
                         VALUES 
                         (:id_tahun_ajaran, :semester, :blok, :berlaku_dari, :tanggal_dirubah, 1)");
        $this->db->bind(':id_tahun_ajaran', $idTahunAjaran);
        $this->db->bind(':semester', $semester);
        $this->db->bind(':blok', $blok);
        $this->db->bind(':berlaku_dari', $berlakuDari);
        $this->db->bind(':tanggal_dirubah', $tanggalDirubah);

        if ($this->db->execute()) {
            $newId = $this->db->lastInsertId();
            error_log("CONTROLLER: Jadwal setting baru dibuat (ID: $newId)");
            return $newId;
        }

        return null;
    }

    public function getWaliKelasLama()
    {
        $sql = "SELECT DISTINCT kelas, ruang, wali_kelas 
                FROM jadwal_lengkap 
                WHERE wali_kelas IS NOT NULL AND wali_kelas != ''";

        $this->db->query($sql);
        $result = $this->db->resultSet();

        if (empty($result)) {
            error_log("CONTROLLER: Tidak ada wali kelas lama ditemukan.");
            return null;
        }

        $waliKelasMap = [];
        foreach ($result as $row) {
            // Format kunci: kelas tanpa spasi (misal: XIIA, XIB)
            $kelasKey = str_replace(' ', '', $row->kelas . $row->ruang);
            $waliKelasMap[$kelasKey] = $row->wali_kelas;
        }

        error_log("CONTROLLER: " . count($waliKelasMap) . " wali kelas lama ditemukan.");
        return $waliKelasMap;
    }
    
}