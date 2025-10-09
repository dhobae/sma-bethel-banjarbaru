<?php
class Mabsen
{
    public function __construct()
    {
        $this->db = new Database;
    }

    public function jadwal()
    {
        $sql = "SELECT * from jadwal";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function cek_absen($tgl, $kelas, $ruang, $jam)
    {
        $sql = "SELECT absen_kelas.*, pegawai.nama as nama, pegawai.kode as nama_pendek from absen_kelas left join pegawai on absen_kelas.nik_absen_kelas=pegawai.nik where tgl_absen_kelas=:tgl and kelas_absen_kelas=:kelas and ruang_absen_kelas=:ruang and jam_absen_kelas=:jam";
        $this->db->query($sql);
        $this->db->bind('tgl', $tgl);
        $this->db->bind('kelas', $kelas);
        $this->db->bind('ruang', $ruang);
        $this->db->bind('jam', $jam);
        return $this->db->single();
    }

    public function isi_absen($data, $kelas, $ruang, $jam, $tgl, $id_pelajaran, $wali_kelas)
    {
        $cari = "SELECT * from m_pelajaran where id_pelajaran=:id_pelajaran";
        $this->db->query($cari);
        $this->db->bind('id_pelajaran', $id_pelajaran);
        $result = $this->db->single();

        $singkatan = $result->singkatan;
        $panjang = $result->mata_pelajaran;

        $sql = "INSERT into absen_kelas (id_absen_kelas, nik_absen_kelas, tgl_absen_kelas, kelas_absen_kelas, ruang_absen_kelas, jam_absen_kelas, mata_pelajaran, mata_pelajaran_lengkap, materi_pelajaran, wali_kelas_absen) values (:id_absen_kelas, :nik_absen_kelas, :tgl_absen_kelas, :kelas_absen_kelas, :ruang_absen_kelas, :jam_absen_kelas, :mata_pelajaran, :mata_pelajaran_lengkap, :materi_pelajaran, :wali_kelas)";
        $this->db->query($sql);
        $this->db->bind('id_absen_kelas', null);
        $this->db->bind('nik_absen_kelas', $_SESSION['nik']);
        $this->db->bind('tgl_absen_kelas', $tgl);
        $this->db->bind('kelas_absen_kelas', $kelas);
        $this->db->bind('ruang_absen_kelas', $ruang);
        $this->db->bind('jam_absen_kelas', $jam);
        $this->db->bind('mata_pelajaran', $singkatan);
        $this->db->bind('mata_pelajaran_lengkap', $panjang);
        $this->db->bind('materi_pelajaran', '');
        $this->db->bind('wali_kelas', $wali_kelas);
        $this->db->execute();
        return true;
    }

    public function reset_absen($id)
    {
        $sql = "DELETE from absen_kelas where id_absen_kelas=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();
        return true;
    }

    //-----------------------------------------
    public function rekap_absen_saya($bulan, $tahun)
    {
        $sql = "SELECT * from absen_kelas where nik_absen_kelas=:nik and month(tgl_absen_kelas)=:bulan and year(tgl_absen_kelas)=:tahun order by tgl_absen_kelas, CAST(jam_absen_kelas as SIGNED)";
        $this->db->query($sql);
        $this->db->bind('nik', $_SESSION['nik']);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function rekap_absen_nik($nik, $bulan, $tahun)
    {
        $sql = "SELECT * from absen_kelas where nik_absen_kelas=:nik and month(tgl_absen_kelas)=:bulan and year(tgl_absen_kelas)=:tahun order by tgl_absen_kelas, CAST(jam_absen_kelas as SIGNED)";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function rekap_mengajar_admin($bulan, $tahun)
    {
        /*
        $sql = "SELECT pegawai.*, COUNT(absen_kelas.tgl_absen_kelas) as jumlah 
        FROM pegawai 
        LEFT JOIN absen_kelas ON pegawai.nik = absen_kelas.nik_absen_kelas 
            AND MONTH(absen_kelas.tgl_absen_kelas) = :bulan 
            AND YEAR(absen_kelas.tgl_absen_kelas) = :tahun 
        WHERE pegawai.mengajar=:mengajar
        GROUP BY pegawai.nik 
        ORDER BY mengajar DESC, nama, CAST(nik as signed)";

        $this->db->query($sql);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        $this->db->bind('mengajar', 'Ya');
        return $this->db->resultSet();
        */
        $sql = "SELECT 
                pegawai.*, 
                COUNT(absen_kelas.tgl_absen_kelas) AS jumlah,
                SUM(CASE WHEN DATE_FORMAT(absen_kelas.tgl_absen_kelas, '%u') = DATE_FORMAT(CONCAT(:tahun, '-', :bulan, '-01'), '%u') THEN 1 ELSE 0 END) AS minggu_1,
                SUM(CASE WHEN DATE_FORMAT(absen_kelas.tgl_absen_kelas, '%u') = DATE_FORMAT(CONCAT(:tahun, '-', :bulan, '-08'), '%u') THEN 1 ELSE 0 END) AS minggu_2,
                SUM(CASE WHEN DATE_FORMAT(absen_kelas.tgl_absen_kelas, '%u') = DATE_FORMAT(CONCAT(:tahun, '-', :bulan, '-15'), '%u') THEN 1 ELSE 0 END) AS minggu_3,
                SUM(CASE WHEN DATE_FORMAT(absen_kelas.tgl_absen_kelas, '%u') = DATE_FORMAT(CONCAT(:tahun, '-', :bulan, '-22'), '%u') THEN 1 ELSE 0 END) AS minggu_4,
                SUM(CASE WHEN DATE_FORMAT(absen_kelas.tgl_absen_kelas, '%u') = DATE_FORMAT(CONCAT(:tahun, '-', :bulan, '-29'), '%u') THEN 1 ELSE 0 END) AS minggu_5
            FROM pegawai 
            LEFT JOIN absen_kelas ON pegawai.nik = absen_kelas.nik_absen_kelas 
                AND MONTH(absen_kelas.tgl_absen_kelas) = :bulan 
                AND YEAR(absen_kelas.tgl_absen_kelas) = :tahun 
            WHERE pegawai.mengajar=:mengajar
            GROUP BY pegawai.nik 
            ORDER BY pegawai.nama, CAST(pegawai.nik AS SIGNED)";

        $this->db->query($sql);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        $this->db->bind('mengajar', 'Ya');
        return $this->db->resultSet();
    }

    public function ambil_nama($nik)
    {
        $sql = "SELECT nama from pegawai where nik=:nik";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        return $this->db->single();
    }

    // -- IZIN MENGAJAR --------------------------------
    public function izin_by_nik($nik)
    {
        $sql = "SELECT * from izin_mengajar where nik=:nik order by tanggal_awal DESC";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        return $this->db->resultSet();
    }

    public function izin_transaksi_by_nik($id)
    {
        $sql = "SELECT * from izin_mengajar_transaksi where id_izin_transaksi=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        return $this->db->resultSet();
    }

    public function izin_mengajar_byid($id)
    {
        $sql = "SELECT * from izin_mengajar where id_izin=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function izin_transaksi_by_id($id)
    {
        $sql = "SELECT * from izin_mengajar_transaksi where id_izin_transaksi=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        return $this->db->resultSet();
    }

    public function izin_guru()
    {
        $sql = "SELECT * from izin_mengajar order by tanggal_awal DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function pegawai_by_nik($nik)
    {
        $sql = "SELECT * from pegawai where nik=:nik";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        return $this->db->single();
    }

    public function pelajaran()
    {
        $sql = "SELECT * from m_pelajaran order by mata_pelajaran";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
    public function simpan_izin_mengajar($data)
    {
        $query = "INSERT INTO izin_mengajar (id_izin, nik, tanggal_awal, tanggal_akhir) values (:id_izin, :nik, :tanggal_awal, :tanggal_akhir)";
        $this->db->query($query);
        $this->db->bind('id_izin', NULL);
        $this->db->bind('nik', $_SESSION['nik']);
        $this->db->bind('tanggal_awal', $data['tanggal_awal']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->execute();

        $id_izin = $this->db->lastInsertId();

        if (isset($data['kelas']) && isset($data['mata_pelajaran']) && isset($data['status_izin']) && isset($data['alasan_izin'])) {
            $count = count($data['kelas']);
            for ($i = 0; $i < $count; $i++) {
                $kelas          = $data['kelas'][$i];
                $mata_pelajaran = $data['mata_pelajaran'][$i];
                $status_izin    = $data['status_izin'][$i];
                $alasan_izin    = $data['alasan_izin'][$i];

                $query = "INSERT INTO izin_mengajar_transaksi (id_transaksi, id_izin_transaksi, kelas, mata_pelajaran, status_izin, alasan_izin) values (:id_transaksi, :id_izin_transaksi, :kelas, :mata_pelajaran, :status_izin, :alasan_izin)";
                $this->db->query($query);
                $this->db->bind('id_transaksi', NULL);
                $this->db->bind('id_izin_transaksi', $id_izin);
                $this->db->bind('kelas', $kelas);
                $this->db->bind('mata_pelajaran', $mata_pelajaran);
                $this->db->bind('status_izin', $status_izin);
                $this->db->bind('alasan_izin', $alasan_izin);
                $this->db->execute();
            }
        }

        $pejabat = $this->wa_mengajar();
        foreach ($pejabat as $d) {
            $nip_array = explode(',', $d->nip_pegawai);
            foreach ($nip_array as $nip) {
                $nohp = $this->nomor_hp($nip);
                $nm = $this->nomor_hp($_SESSION['nik']);
                $data['no_telp'] = $nohp->nomor_hp;
                $data['isi_pesan'] = 'Ada Permohonan izin mengajar dari ' . strtoupper($nm->nama) . ' yang harus diperiksa oleh Admin Absen Mengajar, dan diberi konfirmasi di ACC/tidak';
                notifWA($data);
            }
        }
        return true;
    }

    public function simpan_edit_izin_mengajar($data)
    {
        $query = "UPDATE izin_mengajar set tanggal_awal=:tanggal_awal, tanggal_akhir=:tanggal_akhir WHERE id_izin=:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id_izin']);
        $this->db->bind('tanggal_awal', $data['tanggal_awal']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->execute();

        if (isset($data['kelas']) && isset($data['mata_pelajaran']) && isset($data['status_izin']) && isset($data['alasan_izin'])) {
            $count = count($data['kelas']);
            for ($i = 0; $i < $count; $i++) {
                $id_transaksi   = $data['id_transaksi'][$i];
                $kelas          = $data['kelas'][$i];
                $mata_pelajaran = $data['mata_pelajaran'][$i];
                $status_izin    = $data['status_izin'][$i];
                $alasan_izin    = $data['alasan_izin'][$i];

                $query = "UPDATE izin_mengajar_transaksi set kelas=:kelas, mata_pelajaran=:mata_pelajaran, status_izin=:status_izin, alasan_izin=:alasan_izin WHERE id_transaksi=:id_transaksi";
                $this->db->query($query);
                $this->db->bind('id_transaksi', $id_transaksi);
                $this->db->bind('kelas', $kelas);
                $this->db->bind('mata_pelajaran', $mata_pelajaran);
                $this->db->bind('status_izin', $status_izin);
                $this->db->bind('alasan_izin', $alasan_izin);
                $this->db->execute();
            }
        }

        if (isset($data['kelas2']) && isset($data['mata_pelajaran2']) && isset($data['status_izin2']) && isset($data['alasan_izin2'])) {
            $count = count($data['kelas2']);
            for ($i = 0; $i < $count; $i++) {
                $kelas          = $data['kelas2'][$i];
                $mata_pelajaran = $data['mata_pelajaran2'][$i];
                $status_izin    = $data['status_izin2'][$i];
                $alasan_izin    = $data['alasan_izin2'][$i];

                $query = "INSERT INTO izin_mengajar_transaksi (id_transaksi, id_izin_transaksi, kelas, mata_pelajaran, status_izin, alasan_izin) values (:id_transaksi, :id_izin_transaksi, :kelas, :mata_pelajaran, :status_izin, :alasan_izin)";
                $this->db->query($query);
                $this->db->bind('id_transaksi', NULL);
                $this->db->bind('id_izin_transaksi', $data['id_izin']);
                $this->db->bind('kelas', $kelas);
                $this->db->bind('mata_pelajaran', $mata_pelajaran);
                $this->db->bind('status_izin', $status_izin);
                $this->db->bind('alasan_izin', $alasan_izin);
                $this->db->execute();
            }
        }
        return true;
    }

    public function hapus_izin_mengajar($id)
    {
        $sql = "DELETE from izin_mengajar where id_izin=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();

        $sql = "DELETE from izin_mengajar_transaksi where id_izin_transaksi=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();
        return true;
    }

    public function hapus_transaksi_izin_mengajar($id)
    {
        $sql = "DELETE from izin_mengajar_transaksi where id_transaksi=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();
        return true;
    }

    public function acc_izin($id, $hp)
    {
        $data['no_telp'] = $hp;
        $data['isi_pesan'] = 'Izin meninggalkan jam mengajar anda sudah di setujui';
        notifWA($data);

        $sql = "UPDATE izin_mengajar set acc=:acc where id_izin=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->bind('acc', 'Sudah');
        $this->db->execute();
        return true;
    }


    //--IZIN MENGAJAR VERSI 2 
    public function isi_izin($data, $kelas, $ruang, $jam, $tgl)
    {
        $sql = "INSERT into absen_izin (id_izin, nik_izin, tgl_izin, kelas_izin, ruang_izin, jam_izin, mata_pelajaran_pendek, mata_pelajaran, jenis_izin, alasan_izin, acc) values (:id_izin, :nik_izin, :tgl_izin, :kelas_izin, :ruang_izin, :jam_izin, :mata_pelajaran_pendek, :mata_pelajaran, :jenis_izin, :alasan_izin, :acc)";
        $this->db->query($sql);
        $this->db->bind('id_izin', null);
        $this->db->bind('nik_izin', $_SESSION['nik']);
        $this->db->bind('tgl_izin', $tgl);
        $this->db->bind('kelas_izin', $kelas);
        $this->db->bind('ruang_izin', $ruang);
        $this->db->bind('jam_izin', $jam);
        $this->db->bind('mata_pelajaran_pendek', $data['mata_pelajaran_pendek']);
        $this->db->bind('mata_pelajaran', $data['mata_pelajaran']);
        $this->db->bind('jenis_izin', $data['jenis_izin']);
        $this->db->bind('alasan_izin', $data['alasan_izin']);
        $this->db->bind('acc', '0');
        $this->db->execute();
        return true;
    }

    public function simpan_jurnal($data)
    {
        $updates = array();
        foreach ($data['id_absen_kelas'] as $key => $id_absen_kelas) {
            $query = "SELECT materi_pelajaran FROM absen_kelas WHERE id_absen_kelas=:id_absen_kelas";
            $this->db->query($query);
            $this->db->bind(':id_absen_kelas', $id_absen_kelas);
            $row = $this->db->single();
            if ($data['materi_pelajaran'][$key] != $row->materi_pelajaran) {
                $updates[] = array(
                    'id_absen_kelas' => $id_absen_kelas,
                    'materi_pelajaran' => $data['materi_pelajaran'][$key]
                );
            }
        }
        foreach ($updates as $update) {
            $query = "UPDATE absen_kelas SET materi_pelajaran=:materi_pelajaran WHERE id_absen_kelas=:id_absen_kelas";
            $this->db->query($query);
            $this->db->bind(':id_absen_kelas', $update['id_absen_kelas']);
            $this->db->bind(':materi_pelajaran', $update['materi_pelajaran']);
            $this->db->execute();
        }
        return true;
    }











    public function ambil_nomor_guru($id)
    {
        $ambil = "SELECT izin_mengajar.nik, pegawai.nama, pegawai.nomor_hp from izin_mengajar left join pegawai on izin_mengajar.nik = pegawai.nik where izin_mengajar.id_izin=:id_izin";
        $this->db->query($ambil);
        $this->db->bind('id_izin', $id);
        return $this->db->single();
    }

    public function wa_mengajar()
    {
        $sql = "SELECT admin.*, pegawai.nomor_hp from admin left join pegawai on admin.nip_pegawai=pegawai.nik where admin.hak_akses='mengajar'";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function nomor_hp($nik)
    {
        $sql = "SELECT nomor_hp,nama from pegawai where nik=:nik";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        return $this->db->single();
    }
}
