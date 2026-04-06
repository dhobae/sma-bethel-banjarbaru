<?php
class Mpresensi
{
    public function __construct()
    {
        $this->db = new Database;
    }

    public function daftar()
    {
        $sql = "SELECT * from pegawai where absen=:absen order by urutan, nama";
        $this->db->query($sql);
        $this->db->bind('absen', 'Aktif');
        return $this->db->resultSet();
    }

    public function daftar2()
    {
        $sql = "SELECT * from pegawai where absen=:absen order by urutan, nama";
        $this->db->query($sql);
        $this->db->bind('absen', 'aktif');
        return $this->db->resultSet();
    }

    public function daftar3()
    {
        $sql = "SELECT * from pegawai where absen=:absen order by nama";
        $this->db->query($sql);
        $this->db->bind('absen', 'aktif');
        return $this->db->resultSet();
    }

    public function daftar_wfo()
    {
        $sql = "SELECT * from pegawai left join absen on pegawai.nik=absen.nik where absen=:absen and absen.from_masuk=:from_masuk and absen.tanggal=curdate() order by urutan, nama";
        $this->db->query($sql);
        $this->db->bind('absen', 'Aktif');
        $this->db->bind('from_masuk', 'WFO');
        return $this->db->resultSet();
    }

    public function daftar_wfh()
    {
        $sql = "SELECT * from pegawai left join absen on pegawai.nik=absen.nik where absen=:absen and absen.from_masuk=:from_masuk and absen.tanggal=curdate() order by urutan, nama";
        $this->db->query($sql);
        $this->db->bind('absen', 'Aktif');
        $this->db->bind('from_masuk', 'WFH');
        return $this->db->resultSet();
    }

    public function belum_absen()
    {
        $sql = "SELECT * FROM pegawai
        LEFT JOIN absen ON pegawai.nik = absen.nik
        WHERE absen.nik IS NULL
        AND pegawai.absen =:absen
        /*AND absen.from_masuk NOT IN ('WFH', 'WFO')*/
        /*AND absen.tanggal = CURDATE()*/
        ORDER BY pegawai.jabatan";
        $this->db->query($sql);
        $this->db->bind('absen', 'Aktif');
        return $this->db->resultSet();
    }

    public function daftar_byid_tanggal($nik, $tanggal)
    {
        $sql = "SELECT * from absen where nik=:nik and tanggal=:tanggal";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }

    public function libur()
    {
        $sql = "SELECT * from libur order by tanggal_mulai DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function simpan_libur($data)
    {
        $tanggal_mulai = $data['tanggal_mulai'];
        $tanggal_akhir = $data['tanggal_akhir'];
        $tgl1 = new DateTime("$tanggal_mulai");
        $tgl2 = new DateTime("$tanggal_akhir");
        $jumlahhari = $tgl2->diff($tgl1)->days + 1;

        $sql = "INSERT into libur (id, tanggal_mulai, tanggal_akhir, keterangan_libur) values (:id, :tanggal_mulai, :tanggal_akhir, :keterangan_libur)";
        $this->db->query($sql);
        $this->db->bind('id', NULL);
        $this->db->bind('tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->bind('keterangan_libur', $data['keterangan']);
        $this->db->execute();
        $id_terakhir = $this->db->lastInsertId();

        $sql2 = "SELECT * from master_jam limit 1";
        $this->db->query($sql2);
        $result = $this->db->single();
        $master_masuk = $result->masuk;
        $master_pulang = $result->pulang;

        for ($x = 0; $x < $jumlahhari; $x++) {
            $tanggallibur = date('Y-m-d', strtotime($tgl1->format('Y-m-d') . ' + ' . $x . ' days'));

            $sql3 = "INSERT INTO absen (id, nik, tanggal, jam_masuk, status_masuk, from_masuk, jam_pulang, status_pulang, from_pulang, keterangan, loc_masuk, loc_pulang) values (:id, :nik, :tanggal, :jam_masuk, :status_masuk, :from_masuk, :jam_pulang, :status_pulang, :from_pulang, :keterangan, :loc_masuk, :loc_pulang)";
            $this->db->query($sql3);
            $this->db->bind('id', NULL);
            $this->db->bind('nik', 'all');
            $this->db->bind('tanggal', $tanggallibur);
            $this->db->bind('jam_masuk', $master_masuk);
            $this->db->bind('status_masuk', 'Libur');
            $this->db->bind('from_masuk', $id_terakhir);
            $this->db->bind('jam_pulang', $master_pulang);
            $this->db->bind('status_pulang', '-');
            $this->db->bind('from_pulang', '-');
            $this->db->bind('keterangan', '-');
            $this->db->bind('loc_masuk', '-');
            $this->db->bind('loc_pulang', '-');
            $this->db->execute();

            $sql4 = "INSERT INTO absen_harian_siswa(nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs, id_libur) values (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs, :id_libur)";
            $this->db->query($sql4);
            $this->db->bind('nis_ahs', 'all');
            $this->db->bind('tgl_ahs', $tanggallibur);
            $this->db->bind('jam_masuk_ahs', '07:30:00');
            $this->db->bind('status_ahs', 'Libur');
            $this->db->bind('id_libur', $id_terakhir);
            $this->db->execute();
        }

        return true;
    }

    public function hapus_libur($id)
    {
        $sql = "DELETE from libur where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();

        $sql2 = "DELETE from absen where from_masuk=:from_masuk and nik=:nik";
        $this->db->query($sql2);
        $this->db->bind('from_masuk', $id);
        $this->db->bind('nik', 'all');
        $this->db->execute();

        $sql2 = "DELETE from absen_harian_siswa where id_libur=:id_libur and nis_ahs=:nis";
        $this->db->query($sql2);
        $this->db->bind('id_libur', $id);
        $this->db->bind('nis', 'all');
        $this->db->execute();

        return true;
    }

    public function libur_kelas()
    {
        $sql = "SELECT * from libur_kelas order by tanggal_mulai DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function simpan_libur_kelas($data)
    {
        $tanggal_mulai = $data['tanggal_mulai'];
        $tanggal_akhir = $data['tanggal_akhir'];
        $kelas = $data['kelas'];
        $tgl1 = new DateTime("$tanggal_mulai");
        $tgl2 = new DateTime("$tanggal_akhir");
        $jumlahhari = $tgl2->diff($tgl1)->days + 1;

        $sql = "INSERT into libur_kelas (tanggal_mulai, tanggal_akhir, kelas, keterangan_libur) values (:tanggal_mulai, :tanggal_akhir, :kelas, :keterangan_libur)";
        $this->db->query($sql);
        $this->db->bind('tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->bind('kelas', $kelas);
        $this->db->bind('keterangan_libur', $data['keterangan']);
        $this->db->execute();
        $id_terakhir = $this->db->lastInsertId();

        $id_libur_prefix = "LK_" . $id_terakhir;

        $sqlSiswa = "SELECT nis FROM siswa WHERE status_siswa = 'Aktif' AND kelas_siswa LIKE :kelas_pattern";
        $this->db->query($sqlSiswa);
        $this->db->bind('kelas_pattern', $kelas . '%');
        
        $siswa_list = $this->db->resultSet();

        for ($x = 0; $x < $jumlahhari; $x++) {
            $tanggallibur = date('Y-m-d', strtotime($tgl1->format('Y-m-d') . ' + ' . $x . ' days'));

            foreach($siswa_list as $sw) {
                $sql4 = "INSERT INTO absen_harian_siswa(nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs, id_libur) values (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs, :id_libur)";
                $this->db->query($sql4);
                $this->db->bind('nis_ahs', $sw->nis);
                $this->db->bind('tgl_ahs', $tanggallibur);
                $this->db->bind('jam_masuk_ahs', '07:30:00');
                $this->db->bind('status_ahs', 'Libur');
                $this->db->bind('id_libur', $id_libur_prefix);
                $this->db->execute();
            }
        }

        return true;
    }

    public function hapus_libur_kelas($id)
    {
        $sql = "DELETE from libur_kelas where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();

        $id_libur_prefix = "LK_" . $id;

        $sql2 = "DELETE from absen_harian_siswa where id_libur=:id_libur";
        $this->db->query($sql2);
        $this->db->bind('id_libur', $id_libur_prefix);
        $this->db->execute();

        return true;
    }

    public function ajukan_izin($username)
    {
        $sql = "SELECT tmp_izin.*, tmp_izin.id as idtmpnya, pegawai.nik as nip, pegawai.nama as nama  from tmp_izin left join pegawai on tmp_izin.npk = pegawai.nik where tmp_izin.npk=:username order by tmp_izin.tanggal_mulai DESC";
        $this->db->query($sql);
        $this->db->bind('username', $username);
        return $this->db->resultSet();
    }

    public function cek_double_tmp_izin($nik, $mulai, $sampai)
    {
        $sql = "SELECT * FROM tmp_izin WHERE npk=:nik AND tanggal_mulai <= :end_date AND tanggal_akhir >= :start_date";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        $this->db->bind('start_date', $mulai);
        $this->db->bind('end_date', $sampai);
        return $this->db->resultSet();
    }

    public function cek_double_izin($nik, $mulai, $sampai)
    {
        $sql = "SELECT * FROM absen WHERE nik=:nik AND tanggal <= :end_date AND tanggal >= :start_date";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        $this->db->bind('start_date', $mulai);
        $this->db->bind('end_date', $sampai);
        return $this->db->resultSet();
    }

    public function simpan_pengajuan_izin($data)
    {
        $cek = $this->cek_double_tmp_izin($_SESSION['nik'], $data['tanggal_mulai'], $data['tanggal_akhir']);
        if ($cek) {
            return false;
        }

        $cek = $this->cek_double_izin($_SESSION['nik'], $data['tanggal_mulai'], $data['tanggal_akhir']);
        if ($cek) {
            return false;
        }

        $tgl1 = new DateTime($data['tanggal_mulai']);
        $tgl2 = new DateTime($data['tanggal_akhir']);
        $jumlahhari = $tgl2->diff($tgl1)->days + 1;
        $sql = "INSERT into tmp_izin (id, npk, tanggal_mulai, tanggal_akhir, status_izin, keterangan_izin, status) values (:id, :npk, :tanggal_mulai, :tanggal_akhir, :status_izin, :keterangan_izin, :status)";
        $this->db->query($sql);
        $this->db->bind('id', NULL);
        $this->db->bind('npk', $_SESSION['nik']);
        $this->db->bind('tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->bind('status_izin', $data['status']);
        $this->db->bind('keterangan_izin', $data['keterangan']);
        $this->db->bind('status', 'Belum ACC');
        $this->db->execute();

        $nm = $this->ambil_nama($_SESSION['nik']);
        $no_hp = $this->wa_hci();
        $data['no_telp'] = $no_hp->nomor_hp;
        $data['isi_pesan'] = 'Ada Permohonan izin baru dari ' . strtoupper($nm->nama) . ' yang harus diperiksa oleh HCI, dan diberi keputusan di ACC/Tolak';
        notifWA($data);

        return true;
    }

    public function ajukan_izin_byid($id)
    {
        $sql = "SELECT tmp_izin.*, pegawai.nama as namapegawai FROM tmp_izin left join pegawai on tmp_izin.npk=pegawai.nik WHERE tmp_izin.id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function simpan_edit_pengajuan_izin($data)
    {
        $sql = "UPDATE tmp_izin set npk=:npk, tanggal_mulai=:tanggal_mulai, tanggal_akhir=:tanggal_akhir, status_izin=:status_izin, keterangan_izin=:keterangan_izin where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $data['id']);
        $this->db->bind('npk', $data['npk']);
        $this->db->bind('tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->bind('status_izin', $data['status']);
        $this->db->bind('keterangan_izin', $data['keterangan']);
        $this->db->execute();
        return true;
    }

    public function hapus_pengajuan_izin($id)
    {
        $sql = "DELETE from tmp_izin where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();
        return true;
    }

    public function karyawan()
    {
        $sql = "SELECT dosen.*, jabatan.jabatan as jabatan1 FROM dosen left join jabatan on dosen.jabatan=jabatan.no ORDER BY jabatan";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function karyawan_byid($npk)
    {
        $sql = "SELECT dosen.*, jabatan.jabatan as jabatan1 FROM dosen left join jabatan on dosen.jabatan=jabatan.no WHERE npk=:npk";
        $this->db->query($sql);
        $this->db->bind('npk', $npk);
        return $this->db->single();
    }

    public function karyawan_wfh()
    {
        $sql = "SELECT dosen.*, absen.* from dosen left join absen on dosen.npk=absen.nik where dosen.absen='aktif' and absen.from_masuk='WFH' order by dosen.jabatan";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function karyawan_wfh_byid($tanggal)
    {
        $sql = "SELECT dosen.*, absen.* from dosen left join absen on dosen.npk=absen.nik where dosen.absen='aktif' and absen.tanggal=:tanggal and absen.from_masuk='WFH' order by dosen.jabatan";
        $this->db->query($sql);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }

    public function karyawan_wfh_npk_tanggal($npk, $tanggal)
    {
        $query2 = "SELECT * from absen where nik=:npk and tanggal=:tanggal and from_masuk='WFH'";
        $this->db->query($query2);
        $this->db->bind('npk', $npk);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }

    public function jabatan()
    {
        $query = "SELECT * FROM jabatan order by no";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function karyawan_simpan($data)
    {
        $sql = "INSERT into dosen (npk, nik, nama, jabatan, alamat, telpon, jenis_kelamin, status, absen, id_kantor) values (:npk, :nik, :nama, :jabatan, :alamat, :telpon, :jenis_kelamin, :status, :absen, :id_kantor)";
        $this->db->query($sql);
        $this->db->bind('npk', $data['npk']);
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('telpon', $data['telpon']);
        $this->db->bind('jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('absen', $data['absen']);
        $this->db->bind('id_kantor', '0');
        $this->db->execute();
        return true;
    }

    public function karyawan_edit_simpan($data)
    {
        $sql = "UPDATE dosen set nik=:nik, nama=:nama, jabatan=:jabatan, alamat=:alamat, telpon=:telpon, jenis_kelamin=:jenis_kelamin, status=:status, absen=:absen WHERE npk=:npk";
        $this->db->query($sql);
        $this->db->bind('npk', $data['npk']);
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('jabatan', $data['jabatan']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('telpon', $data['telpon']);
        $this->db->bind('jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('absen', $data['absen']);
        $this->db->execute();
        return true;
    }

    public function karyawan_hapus($id)
    {
        $sql = "DELETE from dosen where npk=:npk";
        $this->db->query($sql);
        $this->db->bind('npk', $id);
        $this->db->execute();
        return true;
    }

    public function today()
    {
        $sql = "SELECT * from pegawai where absen=:absen order by nama";
        $this->db->query($sql);
        $this->db->bind('absen', 'aktif');
        return $this->db->resultSet();
    }

    public function today_by_tanggal($tanggal)
    {
        $query3 = "SELECT absen.*, libur.keterangan_libur as kenapa from absen left join libur on absen.from_masuk=libur.id where absen.nik='all' and absen.tanggal=:tanggal";
        $this->db->query($query3);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }

    public function today_by_nik($nik, $tanggal)
    {
        $query2 = "SELECT * from absen where nik=:nik and tanggal=:tanggal";
        $this->db->query($query2);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('nik', $nik);
        return $this->db->resultSet();
    }

    public function jam_kerja()
    {
        $libur_all = "SELECT * from master_jam limit 1";
        $this->db->query($libur_all);
        return $this->db->single();
    }

    public function jam_kerja_bydate($month, $year)
    {
        $tanggal_absen = $year . '-' . $month . '-01';
        $libur_all = "SELECT * FROM master_jam WHERE berlaku_mulai <= :tanggal_absen ORDER BY berlaku_mulai DESC LIMIT 1";
        $this->db->query($libur_all);
        $this->db->bind('tanggal_absen', $tanggal_absen);
        return $this->db->single();
    }

    public function rekap_jam_kerja($month, $year)
    {
        $sql = "SELECT 
        pegawai.*, 
        absen.status_masuk as status, 
        absen.jam_masuk as jam_masuk, 
        absen.jam_pulang as jam_pulang, 
        count(absen.nik) as jumlah_absen,
        SUM(
            CASE 
                WHEN status_masuk = 'Hadir' AND jam_pulang != '00:00:00' THEN TIMESTAMPDIFF(SECOND, jam_masuk, jam_pulang)
                ELSE 0
            END
        ) AS 'total_detik_hadir',
        SUM(
            CASE 
                WHEN status_masuk != 'Hadir' AND jam_pulang != '00:00:00' THEN TIMESTAMPDIFF(SECOND, jam_masuk, jam_pulang)
                ELSE 0
            END
        ) AS 'total_detik_selain_hadir'
        FROM pegawai 
        LEFT JOIN absen 
        ON pegawai.nik = absen.nik 
        WHERE 
            pegawai.absen = 'Aktif' 
            AND (YEAR(absen.tanggal) =:tahun OR ISNULL(YEAR(absen.tanggal))) 
            AND (MONTH(absen.tanggal) =:bulan OR ISNULL(MONTH(absen.tanggal)))
        GROUP BY pegawai.nik 
        ORDER BY pegawai.nama";

        $this->db->query($sql);
        $this->db->bind('bulan', $month);
        $this->db->bind('tahun', $year);
        return $this->db->resultSet();
    }

    public function rekap_jam_kerja_by_nip($nip, $month, $year)
    {
        $sql = "SELECT * from absen where nik=:nik and MONTH(tanggal)=:bulan and YEAR(tanggal)=:tahun";
        $this->db->query($sql);
        $this->db->bind('nik', $nip);
        $this->db->bind('bulan', $month);
        $this->db->bind('tahun', $year);
        return $this->db->resultSet();
    }

    public function rekap_jam_kerja_nik($month, $year)
    {
        //$year = date('Y');
        //$month = date('m');
        $sql_all = "select absen.*,sum(TIMESTAMPDIFF(second, jam_masuk, jam_pulang)) AS 'Seconds_all' from absen where month(tanggal)=:bulan and nik='all' and year(absen.tanggal)=:tahun group by nik";
        $this->db->query($sql_all);
        $this->db->bind('bulan', $month);
        $this->db->bind('tahun', $year);
        return $this->db->resultSet();
    }

    public function jumlah_libur($month, $year)
    {
        $libur = "select absen.nik,count(absen.nik) AS 'jumlah_libur' from absen where month(tanggal)=:bulan and nik='all' and year(absen.tanggal)=:tahun group by nik";
        $this->db->query($libur);
        $this->db->bind('bulan', $month);
        $this->db->bind('tahun', $year);
        return $this->db->single();
    }

    public function rekap_wfo_wfh($bulan, $tahun)
    {
        $sql = "select pegawai.*, pegawai.nik,
        sum(case when absen.status_masuk='Hadir' then 1 else 0 end) as hadir,
        sum(case when absen.from_masuk='WFO' then 1 else 0 end) as wfo_masuk, 
        sum(case when absen.from_masuk='WFH' then 1 else 0 end) as wfh_masuk, 
        sum(case when absen.from_pulang='WFO' then 1 else 0 end) as wfo_pulang, 
        sum(case when absen.from_pulang='WFH' then 1 else 0 end) as wfh_pulang, 
        sum(case when absen.status_masuk='Izin' then 1 else 0 end) as izin,
        sum(case when absen.status_masuk='Sakit' then 1 else 0 end) as sakit,
        sum(case when absen.status_masuk='Cuti' then 1 else 0 end) as cuti,
        sum(case when absen.status_masuk='TL' then 1 else 0 end) as tl,
        SUM(CASE WHEN absen.jam_masuk > '07:30:00' THEN 1 ELSE 0 END) AS telat,
        SUM(CASE WHEN absen.jam_masuk <= '07:30:00' THEN 1 ELSE 0 END) AS ontime
        from 
        pegawai left join absen on pegawai.nik=absen.nik 
        where pegawai.absen='aktif' and (month(tanggal)=:bulan or isnull(month(absen.tanggal)=:bulan) and year(tanggal)=:tahun or isnull(year(absen.tanggal)=:tahun))
        group by pegawai.nik 
        order by pegawai.nama";
        $this->db->query($sql);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function query_libur($bulan, $tahun)
    {
        $sqllibur = "SELECT sum(case when status_masuk='Libur' then 1 else 0 end) as libur from absen where nik='all' and month(tanggal)=:bulan and year(tanggal)=:tahun";
        $this->db->query($sqllibur);
        $this->db->bind('bulan', $bulan);
        $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    //--------------------------
    public function daftar_izin()
    {
        $sql = "SELECT izin.*, pegawai.nik as nip, pegawai.nama as namadosen  from izin left join pegawai on izin.nik = pegawai.nik order by izin.tanggal_mulai DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function daftar_izin_byid($id)
    {
        $sql = "SELECT izin.*, pegawai.nik as nip, pegawai.nama as namadosen  from izin left join pegawai on izin.nik = pegawai.nik where izin.id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tmp_izin()
    {
        $sql = "SELECT tmp_izin.*, tmp_izin.id as idtmpnya, pegawai.nik as nip, pegawai.nama as namadosen  from tmp_izin left join pegawai on tmp_izin.npk = pegawai.nik order by tmp_izin.tanggal_mulai DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function hapus_permohonan_izin($id)
    {
        $sql = "DELETE from tmp_izin where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();
        return true;
    }

    public function tmp_izin_byid($id)
    {
        $sql = "SELECT tmp_izin.*, tmp_izin.id as idtmpnya, pegawai.nik as nik, pegawai.nama as nama  from tmp_izin left join pegawai on tmp_izin.npk = pegawai.nik where tmp_izin.id =:id order by tmp_izin.tanggal_mulai DESC";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function simpan_tambah_izin($data)
    {
        $cek = $this->cek_double_izin($data['npk'], $data['tanggal_mulai'], $data['tanggal_akhir']);
        if ($cek) {
            return false;
        }

        $tgl_m = $data['tanggal_mulai'];
        $tgl_a = $data['tanggal_akhir'];
        $tgl1 = new DateTime("$tgl_m");
        $tgl2 = new DateTime("$tgl_a");
        $jumlahhari = $tgl2->diff($tgl1)->days + 1;

        $sql = "INSERT INTO izin (id, nik, tanggal_mulai, tanggal_akhir, status_izin, keterangan_izin) values (:id, :nik, :tanggal_mulai, :tanggal_akhir, :status_izin, :keterangan_izin)";
        $this->db->query($sql);
        $this->db->bind('id', NULL);
        $this->db->bind('nik', $data['npk']);
        $this->db->bind('tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->bind('status_izin', $data['status']);
        $this->db->bind('keterangan_izin', $data['keterangan']);
        $this->db->execute();

        $id_terakhir = $this->db->lastInsertId();

        $sql2 = "SELECT * from master_jam limit 1";
        $this->db->query($sql2);
        $result = $this->db->single();
        $master_masuk = $result->masuk;
        $master_pulang = $result->pulang;

        for ($x = 0; $x < $jumlahhari; $x++) {
            $tanggallibur = date('Y-m-d', strtotime($tgl1->format('Y-m-d') . ' + ' . $x . ' days'));

            $dayOfWeek = date('N', strtotime($tanggallibur));
            if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                // Hari Sabtu (6) atau Minggu (7), lewati penginputan absen
                continue;
            }

            $sql3 = "INSERT INTO absen (id, nik, tanggal, jam_masuk, status_masuk, from_masuk, jam_pulang, status_pulang, from_pulang, keterangan, loc_masuk, loc_pulang) values (:id, :nik, :tanggal, :jam_masuk, :status_masuk, :from_masuk, :jam_pulang, :status_pulang, :from_pulang, :keterangan, :loc_masuk, :loc_pulang)";
            $this->db->query($sql3);
            $this->db->bind('id', NULL);
            $this->db->bind('nik', $data['npk']);
            $this->db->bind('tanggal', $tanggallibur);
            $this->db->bind('jam_masuk', $master_masuk);
            $this->db->bind('status_masuk', $data['status']);
            $this->db->bind('from_masuk', $id_terakhir);
            $this->db->bind('jam_pulang', $master_pulang);
            $this->db->bind('status_pulang', '-');
            $this->db->bind('from_pulang', '-');
            $this->db->bind('keterangan', '-');
            $this->db->bind('loc_masuk', '-');
            $this->db->bind('loc_pulang', '-');
            $this->db->execute();
        }
        return true;
    }

    public function simpan_edit_tambah_izin($data)
    {
        $tgl_m = $data['tanggal_mulai'];
        $tgl_a = $data['tanggal_akhir'];
        $tgl1 = new DateTime("$tgl_m");
        $tgl2 = new DateTime("$tgl_a");
        $jumlahhari = $tgl2->diff($tgl1)->days + 1;

        $sql = "UPDATE izin set nik=:nik, tanggal_mulai=:tanggal_mulai, tanggal_akhir=:tanggal_akhir, status_izin=:status_izin, keterangan_izin=:keterangan_izin WHERE id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $data['id_izin']);
        $this->db->bind('nik', $data['npk']);
        $this->db->bind('tanggal_mulai', $data['tanggal_mulai']);
        $this->db->bind('tanggal_akhir', $data['tanggal_akhir']);
        $this->db->bind('status_izin', $data['status']);
        $this->db->bind('keterangan_izin', $data['keterangan']);
        $this->db->execute();

        $sql2 = "DELETE from absen where from_masuk=:id_izin";
        $this->db->query($sql2);
        $this->db->bind('id_izin', $data['id_izin']);
        $this->db->execute();

        $sql2 = "SELECT * from master_jam limit 1";
        $this->db->query($sql2);
        $result = $this->db->single();
        $master_masuk = $result->masuk;
        $master_pulang = $result->pulang;

        for ($x = 0; $x < $jumlahhari; $x++) {
            $tanggallibur = date('Y-m-d', strtotime($tgl1->format('Y-m-d') . ' + ' . $x . ' days'));

            $sql3 = "INSERT INTO absen (id, nik, tanggal, jam_masuk, status_masuk, from_masuk, jam_pulang, status_pulang, from_pulang, keterangan, loc_masuk, loc_pulang) values (:id, :nik, :tanggal, :jam_masuk, :status_masuk, :from_masuk, :jam_pulang, :status_pulang, :from_pulang, :keterangan, :loc_masuk, :loc_pulang)";
            $this->db->query($sql3);
            $this->db->bind('id', NULL);
            $this->db->bind('nik', $data['npk']);
            $this->db->bind('tanggal', $tanggallibur);
            $this->db->bind('jam_masuk', $master_masuk);
            $this->db->bind('status_masuk', $data['status']);
            $this->db->bind('from_masuk', $data['id_izin']);
            $this->db->bind('jam_pulang', $master_pulang);
            $this->db->bind('status_pulang', '-');
            $this->db->bind('from_pulang', '-');
            $this->db->bind('keterangan', '-');
            $this->db->bind('loc_masuk', '-');
            $this->db->bind('loc_pulang', '-');
            $this->db->execute();
        }
        return true;
    }

    public function hapus_izin($id)
    {
        $sql = "DELETE from izin where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();

        $sql2 = "DELETE from absen where from_masuk=:from_masuk";
        $this->db->query($sql2);
        $this->db->bind('from_masuk', $id);
        $this->db->execute();
        return true;
    }

    public function simpan_acc_permohonan($data)
    {
        $sql3 = "INSERT INTO izin (id, nik, tanggal_mulai, tanggal_akhir, status_izin, keterangan_izin) values (:id, :nik, :tanggal_mulai, :tanggal_akhir, :status_izin, :keterangan_izin)";
        $this->db->query($sql3);
        $this->db->bind('id', NULL);
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('tanggal_mulai', $data['mulai']);
        $this->db->bind('tanggal_akhir', $data['sampai']);
        $this->db->bind('status_izin', $data['status']);
        $this->db->bind('keterangan_izin', $data['keterangan']);
        $this->db->execute();

        $last_id = $this->db->lastInsertId();

        $querymaster = "SELECT * FROM master_jam";
        $this->db->query($querymaster);
        $master_jam = $this->db->single();

        $masuk = $master_jam->masuk;
        $pulang = $master_jam->pulang;

        $tgl1 = new DateTime($data['mulai']);
        $tgl2 = new DateTime($data['sampai']);
        $jumlahhari = $tgl2->diff($tgl1)->days + 1;

        for ($x = 0; $x < $jumlahhari; $x++) {
            $tanggallibur = date('Y-m-d', strtotime($tgl1->format('Y-m-d') . ' + ' . $x . ' days'));
            $sql6 = "INSERT INTO absen (id, nik, tanggal, jam_masuk, status_masuk, from_masuk, jam_pulang, status_pulang, from_pulang, keterangan, loc_masuk, loc_pulang) values (:id, :nik, :tanggal, :jam_masuk, :status_masuk, :from_masuk, :jam_pulang, :status_pulang, :from_pulang, :keterangan, :loc_masuk, :loc_pulang)";
            $this->db->query($sql6);
            $this->db->bind('id', NULL);
            $this->db->bind('nik', $data['nik']);
            $this->db->bind('tanggal', $tanggallibur);
            $this->db->bind('jam_masuk', $masuk);
            $this->db->bind('from_masuk', $last_id);
            $this->db->bind('status_masuk', $data['status']);
            $this->db->bind('jam_pulang', $pulang);
            $this->db->bind('status_pulang', '-');
            $this->db->bind('from_pulang', '-');
            $this->db->bind('keterangan', '-');
            $this->db->bind('loc_masuk', '-');
            $this->db->bind('loc_pulang', '-');
            $this->db->execute();
        }

        $sql2 = "DELETE from tmp_izin where id=:id";
        $this->db->query($sql2);
        $this->db->bind('id', $data['id_tmp']);
        $this->db->execute();

        $nm = $this->ambil_nama($data['nik']);
        $no_hp = $this->wa_kepsek();
        $data['no_telp'] = $no_hp->nomor_hp;
        $data['isi_pesan'] = 'Ada Permohonan izin baru dari ' . strtoupper($nm->nama) . ' dari tanggal ' . dateID($data['mulai']) . ' sampai ' . dateID($data['sampai']) . ' yang telah di ACC oleh HCI';
        notifWA($data);

        return true;
    }

    //--- WA ------------------------------------
    public function wa_kepsek()
    {
        $sql = "SELECT admin.*, pegawai.nomor_hp from admin left join pegawai on admin.nip_pegawai=pegawai.nik where admin.hak_akses='kepala_sekolah'";
        $this->db->query($sql);
        return $this->db->single();
    }

    public function wa_hci()
    {
        $sql = "SELECT admin.*, pegawai.nomor_hp from admin left join pegawai on admin.nip_pegawai=pegawai.nik where admin.hak_akses='hci'";
        $this->db->query($sql);
        return $this->db->single();
    }

    public function wa_keuangan()
    {
        $sql = "SELECT admin.*, pegawai.nomor_hp from admin left join pegawai on admin.nip_pegawai=pegawai.nik where admin.hak_akses='keuangan'";
        $this->db->query($sql);
        return $this->db->single();
    }

    public function ambil_nama($nik)
    {
        $sql = "SELECT nama from pegawai where nik=:nik";
        $this->db->query($sql);
        $this->db->bind('nik', $nik);
        return $this->db->single();
    }

    //-- RESET ABSEN --------------------
    public function reset_absen($id)
    {
        $sql = "DELETE from absen where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->execute();
        return true;
    }

    public function reset_absen_pulang($id)
    {
        $sql = "UPDATE absen set status_pulang=:status_pulang, jam_pulang=:jam_pulang, from_pulang=:from_pulang where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        $this->db->bind('status_pulang', '-');
        $this->db->bind('jam_pulang', '00:00:00');
        $this->db->bind('from_pulang', '-');
        $this->db->execute();
        return true;
    }

    public function ambil_reset($id)
    {
        $sql = "SELECT absen.*, absen.id as id_absen, pegawai.* from absen left join pegawai on absen.nik=pegawai.nik where absen.id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function simpan_absen_admin($data)
    {
        if ($data['jam_masuk'] != '00:00:00') {
            $status_masuk = 'Hadir';
        } else {
            $status_masuk = '-';
        }

        if ($data['jam_pulang'] != '00:00:00') {
            $status_pulang = 'Pulang';
        } else {
            $status_pulang = '-';
        }

        $sql = "UPDATE absen set jam_masuk=:jam_masuk, from_masuk=:from_masuk, jam_pulang=:jam_pulang, from_pulang=:from_pulang, status_masuk=:status_masuk, status_pulang=:status_pulang where id=:id";
        $this->db->query($sql);
        $this->db->bind('id', $data['id_absen']);
        $this->db->bind('jam_masuk', $data['jam_masuk']);
        $this->db->bind('from_masuk', $data['from_masuk']);
        $this->db->bind('jam_pulang', $data['jam_pulang']);
        $this->db->bind('from_pulang', $data['from_pulang']);
        $this->db->bind('status_masuk', $status_masuk);
        $this->db->bind('status_pulang', $status_pulang);
        $this->db->execute();
        return true;
    }

    public function setting_urutan()
    {
        $status = 'Aktif';
        $sql = "SELECT * from pegawai where absen=:absen order by urutan";
        $this->db->query($sql);
        $this->db->bind('absen', $status);
        return $this->db->resultSet();
    }

    public function reset_urutan()
    {
        $sql = "UPDATE pegawai set urutan='100'";
        $this->db->query($sql);
        $this->db->execute();
        return true;
    }

    public function simpan_urutan($data)
    {
        foreach ($data as $nik => $urutan) {
            $sql = "UPDATE pegawai SET urutan =:urutan WHERE nik =:nik";
            $this->db->query($sql);
            $this->db->bind('urutan', $urutan);
            $this->db->bind('nik', $nik);
            $this->db->execute();
        }
        return true;
    }

    //--- ISIKAN PRESENSI ------------------------
    public function simpan_isikan_absen($data)
    {
        $sql3 = "INSERT INTO absen (id, nik, tanggal, jam_masuk, status_masuk, from_masuk, jam_pulang, status_pulang, from_pulang, keterangan, loc_masuk, loc_pulang) values (:id, :nik, :tanggal, :jam_masuk, :status_masuk, :from_masuk, :jam_pulang, :status_pulang, :from_pulang, :keterangan, :loc_masuk, :loc_pulang)";
        $this->db->query($sql3);
        $this->db->bind('id', NULL);
        $this->db->bind('nik', $data['nik']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('jam_masuk', $data['jam_masuk']);
        $this->db->bind('status_masuk', 'Hadir');
        $this->db->bind('from_masuk', $data['from_masuk']);
        if ($data['jam_pulang']) {
            $this->db->bind('jam_pulang', $data['jam_pulang']);
            $this->db->bind('status_pulang', 'Pulang');
            $this->db->bind('from_pulang', $data['from_pulang']);
        } else {
            $this->db->bind('jam_pulang', '00:00:00');
            $this->db->bind('status_pulang', '-');
            $this->db->bind('from_pulang', '-');
        }
        $this->db->bind('keterangan', '-');
        $this->db->bind('loc_masuk', '-');
        $this->db->bind('loc_pulang', '-');
        $this->db->execute();
        return true;
    }


    //-- IZIN JAM KERJA -------------------------------
    public function izin_jam_kerja()
    {
        $sql = "SELECT izin_keluar_jam_kerja.*, pegawai.nama from izin_keluar_jam_kerja left join pegawai on izin_keluar_jam_kerja.nik=pegawai.nik order by tanggal DESC, pegawai.nama ASC, dari_jam DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function simpan_izin_jam_kerja($data)
    {
        $dari_jam_new = $data['dari_jam'];
        $sampai_jam_new = $data['sampai_jam'];

        $sql = "SELECT dari_jam, sampai_jam FROM izin_keluar_jam_kerja WHERE (:dari_jam_new >= sampai_jam AND :sampai_jam_new <= dari_jam)";
        $this->db->query($sql);
        $this->db->bind(':dari_jam_new', $dari_jam_new);
        $this->db->bind(':sampai_jam_new', $sampai_jam_new);
        $overlapData = $this->db->resultSet();

        if (!empty($overlapData)) {
            return false;
        }

        $sql = "INSERT INTO izin_keluar_jam_kerja (id_izin_keluar, nik, tanggal, keperluan, dari_jam, sampai_jam, status_izin_keluar) values (:id_izin_keluar, :nik, :tanggal, :keperluan, :dari_jam, :sampai_jam, :status_izin_keluar)";
        $this->db->query($sql);
        $this->db->bind(':id_izin_keluar', NULL);
        $this->db->bind(':nik', $_SESSION['nik']);
        $this->db->bind(':tanggal', date('Y-m-d'));
        $this->db->bind(':keperluan', $data['keperluan']);
        $this->db->bind(':dari_jam', $data['dari_jam']);
        $this->db->bind(':sampai_jam', $data['sampai_jam']);
        $this->db->bind(':status_izin_keluar', '0');
        $this->db->execute();

        $nm = $this->ambil_nama($_SESSION['nik']);
        $no_hp = $this->wa_hci();
        $data['no_telp'] = $no_hp->nomor_hp;
        $data['isi_pesan'] = 'Ada Permohonan izin pada jam kerja dari ' . strtoupper($nm->nama) . ' yang harus diperiksa oleh HCI, dan diberi keputusan di ACC/Tolak';
        notifWA($data);

        return true;
    }

    public function edit_izin_jam_kerja($data)
    {
        $sql = "UPDATE izin_keluar_jam_kerja set keperluan=:keperluan, dari_jam=:dari_jam, sampai_jam=:sampai_jam WHERE id_izin_keluar=:id_izin_keluar";
        $this->db->query($sql);
        $this->db->bind(':id_izin_keluar', $data['id_izin_keluar']);
        $this->db->bind(':keperluan', $data['keperluan']);
        $this->db->bind(':dari_jam', $data['dari_jam']);
        $this->db->bind(':sampai_jam', $data['sampai_jam']);
        $this->db->execute();
        return true;
    }

    public function status_izin_jam_kerja($data)
    {
        $sql = "UPDATE izin_keluar_jam_kerja set status_izin_keluar=:status_izin_keluar WHERE id_izin_keluar=:id_izin_keluar";
        $this->db->query($sql);
        $this->db->bind(':id_izin_keluar', $data['id_izin_keluar']);
        $this->db->bind(':status_izin_keluar', $data['status_izin_keluar']);
        $this->db->execute();
        return true;
    }

    public function hapus_izin_jam_kerja($id)
    {
        $sql = "DELETE from izin_keluar_jam_kerja where id_izin_keluar=:id_izin_keluar";
        $this->db->query($sql);
        $this->db->bind('id_izin_keluar', $id);
        $this->db->execute();
        return true;
    }

    //--LIHAT DETAIL
    public function ambil_nama2()
    {
        $id = $_GET['data'];
        $sql = "SELECT * from pegawai where nik=:npk";
        $this->db->query($sql);
        $this->db->bind('npk', $id);
        return $this->db->single();
    }

    public function rekap()
    {
        $id = $_GET['id'];
        $sql = "SELECT * from absen where nik=:nik order by tanggal";
        $this->db->query($sql);
        $this->db->bind('nik', $id);
        return $this->db->resultSet();
    }

    //-----------------------------
    public function teman_hadir()
    {
        $sql2 = "SELECT kelas_siswa, tahun_masuk from siswa where nis=:nis";
        $this->db->query($sql2);
        $this->db->bind('nis', $_SESSION['nik']);
        $ambil = $this->db->single();
        $kelas = $ambil->kelas_siswa;
        $tahun_masuk = $ambil->tahun_masuk;

        $sql = "SELECT * from siswa where kelas_siswa=:kelas_siswa and tahun_masuk=:tahun_masuk order by nama_siswa";
        $this->db->query($sql);
        $this->db->bind('kelas_siswa', $kelas);
        $this->db->bind('tahun_masuk', $tahun_masuk);
        return $this->db->resultSet();
    }

    public function daftar_byid_tanggal_siswa($nis, $tanggal)
    {
        $sql = "SELECT * from absen_harian_siswa where nis_ahs=:nis and tgl_ahs=:tanggal";
        $this->db->query($sql);
        $this->db->bind('nis', $nis);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->resultSet();
    }

    //---------------------------------
    public function nama_rekap_cuti($tahun)
    {
        $sql = "SELECT pegawai.nik, pegawai.nama 
                FROM pegawai 
                where nama!= '' 
                AND absen='Aktif' 
                ORDER BY pegawai.nama";
        $this->db->query($sql);
        // $this->db->bind('tahun', $tahun);
        return $this->db->resultSet();
    }

    public function hitung_cuti($nik, $tahun)
    {
        $sql = "SELECT COUNT(*) AS total FROM absen WHERE nik = :nik AND YEAR(tanggal) = :tahun AND status_masuk IN ('Cuti', 'Cuti2')";

        $this->db->query($sql);
        $this->db->bind('tahun', $tahun);
        $this->db->bind('nik', $nik);
        return $this->db->single();
    }

    public function detail_cuti($nik, $tahun)
    {
        $sql = "SELECT absen.*, izin.* from absen left join izin on absen.from_masuk=izin.id where year(tanggal)=:tahun and absen.nik=:nik and status_masuk IN ('Cuti', 'Cuti2')";
        $this->db->query($sql);
        $this->db->bind('tahun', $tahun);
        $this->db->bind('nik', $nik);
        return $this->db->resultSet();
    }

    //--------------------------------
    public function device()
    {
        $sql = "SELECT * from pegawai where absen=:absen order by nama";
        $this->db->query($sql);
        $this->db->bind('absen', 'aktif');
        return $this->db->resultSet();
    }
}
