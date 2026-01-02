<?php

class Mrapor {

    public function __construct()
    {
       $this->db = new Database;
    }
 
    // Ambil semua jadwal setting
    public function ambil_jadwal_setting()
    {
       $sql = "SELECT 
                 js.*,
                 ta.tahun_ajaran
               FROM jadwal_setting js
               JOIN m_tahun_ajaran ta ON js.id_tahun_ajaran = ta.id_tahun_ajaran
               ORDER BY js.id_tahun_ajaran DESC, js.semester DESC, js.blok DESC";
       
       $this->db->query($sql);
       return $this->db->resultSet();
    }
 
    // Ambil jadwal setting yang aktif
    public function ambil_jadwal_aktif()
    {
       $sql = "SELECT 
                 js.*,
                 ta.tahun_ajaran
               FROM jadwal_setting js
               JOIN m_tahun_ajaran ta ON js.id_tahun_ajaran = ta.id_tahun_ajaran
               WHERE js.status = 1
               LIMIT 1";
       
       $this->db->query($sql);
       return $this->db->single();
    }

    // Ambil semua kelas yang diampu oleh wali kelas
    public function ambil_kelas_wali_kelas($nik_wali_kelas)
    {
        $sql = "SELECT DISTINCT
                    jl.kelas,
                    jl.ruang,
                    jl.kode_kelas,
                    jl.prodi
                FROM jadwal_lengkap jl
                WHERE jl.wali_kelas = :nik_wali_kelas
                  AND jl.validasi = 1
                ORDER BY jl.kelas, jl.ruang";

        $this->db->query($sql);
        $this->db->bind('nik_wali_kelas', $nik_wali_kelas);
        return $this->db->resultSet();
    }

 
    // Ambil siswa berdasarkan wali kelas
    public function ambil_siswa_berdasarkan_wali_kelas($nik_wali_kelas)
    {
        $sql = "SELECT DISTINCT
                 s.id_siswa,  
                 s.nis,
                 s.nama_siswa,
                 s.kelas_siswa,
                 s.ruang_siswa,
                 jl.wali_kelas,
                 p.nama AS nama_wali_kelas,
                 jl.kelas,
                 jl.ruang
               FROM siswa s
               JOIN jadwal_lengkap jl 
                 ON s.kelas_siswa = jl.kode_kelas
               JOIN pegawai p
                 ON jl.wali_kelas = p.nik
               WHERE jl.wali_kelas = :nik_wali_kelas
                 AND s.status_siswa = 'Aktif'
                 AND jl.validasi = 1
               ORDER BY s.kelas_siswa";
    
        $this->db->query($sql);
        $this->db->bind('nik_wali_kelas', $nik_wali_kelas);
        return $this->db->resultSet();
    }
    
 
    // Ambil mata pelajaran berdasarkan kelas siswa (IMPROVED)
    public function ambil_mata_pelajaran_kelas($kode_kelas, $id_jadwal_setting = null)
    {
        // Jika id_jadwal_setting tidak diberikan, ambil yang aktif
        if ($id_jadwal_setting === null) {
            $jadwal_aktif = $this->ambil_jadwal_aktif();
            if (!$jadwal_aktif) return [];
            $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
        }
        
        // Ambil tanggal berlaku dari jadwal_setting
        $this->db->query("SELECT berlaku_dari FROM jadwal_setting WHERE id_jadwal_setting = :id_jadwal");
        $this->db->bind('id_jadwal', $id_jadwal_setting);
        $jadwal_result = $this->db->single();
        
        if (!$jadwal_result) return [];
        
        $berlaku_dari = $jadwal_result->berlaku_dari;
        
        $sql = "SELECT DISTINCT 
                 mp.id_pelajaran,
                 mp.mata_pelajaran,
                 mp.singkatan
               FROM jadwal_lengkap jl
               JOIN m_pelajaran mp ON (
                 jl.mp1 = mp.id_pelajaran OR 
                 jl.mp2 = mp.id_pelajaran OR 
                 jl.mp3 = mp.id_pelajaran OR 
                 jl.mp4 = mp.id_pelajaran OR 
                 jl.mp5 = mp.id_pelajaran OR 
                 jl.mp6 = mp.id_pelajaran OR 
                 jl.mp7 = mp.id_pelajaran OR 
                 jl.mp8 = mp.id_pelajaran OR 
                 jl.mp9 = mp.id_pelajaran OR 
                 jl.mp10 = mp.id_pelajaran
               )
               WHERE jl.kode_kelas = :kode_kelas
                 AND jl.validasi = 1
                 AND jl.berlaku_jadwal_dari = :berlaku_dari
               ORDER BY mp.mata_pelajaran";
    
        $this->db->query($sql);
        $this->db->bind('kode_kelas', $kode_kelas);
        $this->db->bind('berlaku_dari', $berlaku_dari);
        return $this->db->resultSet();
    }


    // --- Siswa ---
    public function ambil_siswa_by_id($id)
    {
        $this->db->query("SELECT * FROM siswa WHERE id_siswa = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // --- Nilai Pelajaran (IMPROVED) ---
    public function ambil_nilai_pelajaran($id_jadwal, $id_siswa)
    {
        $sql = "SELECT 
                  np.*,
                  mp.mata_pelajaran,
                  mp.singkatan
                FROM nilai_pelajaran np
                JOIN m_pelajaran mp ON np.id_pelajaran = mp.id_pelajaran
                WHERE np.id_jadwal_setting = :idj
                  AND np.id_siswa = :ids
                ORDER BY mp.mata_pelajaran";

        $this->db->query($sql);
        $this->db->bind('idj', $id_jadwal);
        $this->db->bind('ids', $id_siswa);
        return $this->db->resultSet();
    }


    // --- Nilai Sikap ---
    public function ambil_nilai_sikap($id_jadwal, $id_siswa)
    {
        $this->db->query("SELECT * FROM nilai_sikap WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
        $this->db->bind('idj', $id_jadwal);
        $this->db->bind('ids', $id_siswa);
        return $this->db->single();
    }

    // --- Ekstrakurikuler ---
    public function ambil_ekstrakurikuler($id_jadwal, $id_siswa)
    {
        $this->db->query("SELECT * FROM ekstrakurikuler WHERE id_jadwal_setting = :idj AND id_siswa = :ids ORDER BY id_ekstrakurikuler");
        $this->db->bind('idj', $id_jadwal);
        $this->db->bind('ids', $id_siswa);
        return $this->db->resultSet();
    }

    // --- Prestasi ---
    public function ambil_prestasi($id_jadwal, $id_siswa)
    {
        $this->db->query("SELECT * FROM prestasi WHERE id_jadwal_setting = :idj AND id_siswa = :ids ORDER BY id_prestasi");
        $this->db->bind('idj', $id_jadwal);
        $this->db->bind('ids', $id_siswa);
        return $this->db->resultSet();
    }

    // --- Catatan Wali Kelas ---
    public function ambil_catatan_wali($id_jadwal, $id_siswa)
    {
        $this->db->query("SELECT * FROM catatan_wali_kelas WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
        $this->db->bind('idj', $id_jadwal);
        $this->db->bind('ids', $id_siswa);
        return $this->db->single();
    }

    // --- Simpan Semua Data Rapor (IMPROVED) ---
    public function simpan_semua_nilai($post)
    {
        $id_jadwal = $post['id_jadwal_setting'];
        $id_siswa = $post['id_siswa'];

        try {
            // Start transaction
            $this->db->beginTransaction();

            // 1. Simpan nilai pelajaran
            if (isset($post['nilai']) && is_array($post['nilai'])) {
                foreach ($post['nilai'] as $id_pelajaran => $nilai) {
                    // Skip jika kosong semua
                    $predikat = isset($post['predikat'][$id_pelajaran]) ? $post['predikat'][$id_pelajaran] : null;
                    $deskripsi = isset($post['deskripsi'][$id_pelajaran]) ? $post['deskripsi'][$id_pelajaran] : null;
                    
                    // Konversi string kosong menjadi NULL
                    $nilai = ($nilai === '' || $nilai === null) ? null : $nilai;
                    $predikat = ($predikat === '' || $predikat === null) ? null : $predikat;
                    $deskripsi = ($deskripsi === '' || $deskripsi === null) ? null : $deskripsi;

                    // Hanya simpan jika minimal ada nilai atau deskripsi
                    if ($nilai !== null || $deskripsi !== null) {
                        $this->db->query("INSERT INTO nilai_pelajaran 
                                          (id_jadwal_setting, id_siswa, id_pelajaran, nilai, predikat, deskripsi)
                                          VALUES (:idj, :ids, :idp, :nilai, :predikat, :desk)
                                          ON DUPLICATE KEY UPDATE 
                                            nilai = :nilai, 
                                            predikat = :predikat, 
                                            deskripsi = :desk,
                                            updated_at = CURRENT_TIMESTAMP");
                        $this->db->bind('idj', $id_jadwal);
                        $this->db->bind('ids', $id_siswa);
                        $this->db->bind('idp', $id_pelajaran);
                        $this->db->bind('nilai', $nilai);
                        $this->db->bind('predikat', $predikat);
                        $this->db->bind('desk', $deskripsi);
                        $this->db->execute();
                    }
                }
            }

            // 2. Simpan sikap
            $psp = isset($post['predikat_spiritual']) ? $post['predikat_spiritual'] : null;
            $dsp = isset($post['deskripsi_spiritual']) ? $post['deskripsi_spiritual'] : null;
            $pso = isset($post['predikat_sosial']) ? $post['predikat_sosial'] : null;
            $dso = isset($post['deskripsi_sosial']) ? $post['deskripsi_sosial'] : null;

            $this->db->query("INSERT INTO nilai_sikap 
                              (id_jadwal_setting, id_siswa, predikat_spiritual, deskripsi_spiritual, predikat_sosial, deskripsi_sosial)
                              VALUES (:idj, :ids, :psp, :dsp, :pso, :dso)
                              ON DUPLICATE KEY UPDATE 
                                predikat_spiritual = :psp, 
                                deskripsi_spiritual = :dsp, 
                                predikat_sosial = :pso, 
                                deskripsi_sosial = :dso,
                                updated_at = CURRENT_TIMESTAMP");
            $this->db->bind('idj', $id_jadwal);
            $this->db->bind('ids', $id_siswa);
            $this->db->bind('psp', $psp);
            $this->db->bind('dsp', $dsp);
            $this->db->bind('pso', $pso);
            $this->db->bind('dso', $dso);
            $this->db->execute();

            // 3. Simpan ekstrakurikuler (hapus dulu, insert baru)
            $this->db->query("DELETE FROM ekstrakurikuler WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
            $this->db->bind('idj', $id_jadwal);
            $this->db->bind('ids', $id_siswa);
            $this->db->execute();
            
            if (isset($post['ekskul_nama']) && is_array($post['ekskul_nama'])) {
                foreach ($post['ekskul_nama'] as $i => $nama) {
                    // Skip jika nama kosong
                    if (empty(trim($nama))) continue;
                    
                    $nilai = isset($post['ekskul_nilai'][$i]) ? $post['ekskul_nilai'][$i] : null;
                    $ket = isset($post['ekskul_ket'][$i]) ? $post['ekskul_ket'][$i] : null;
                    
                    $this->db->query("INSERT INTO ekstrakurikuler 
                                      (id_jadwal_setting, id_siswa, nama_ekstrakurikuler, nilai, keterangan)
                                      VALUES (:idj, :ids, :nama, :nilai, :ket)");
                    $this->db->bind('idj', $id_jadwal);
                    $this->db->bind('ids', $id_siswa);
                    $this->db->bind('nama', $nama);
                    $this->db->bind('nilai', $nilai);
                    $this->db->bind('ket', $ket);
                    $this->db->execute();
                }
            }

            // 4. Simpan prestasi (hapus dulu, insert baru)
            $this->db->query("DELETE FROM prestasi WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
            $this->db->bind('idj', $id_jadwal);
            $this->db->bind('ids', $id_siswa);
            $this->db->execute();
            
            if (isset($post['prestasi_jenis']) && is_array($post['prestasi_jenis'])) {
                foreach ($post['prestasi_jenis'] as $i => $jenis) {
                    // Skip jika nama kosong
                    $nama = isset($post['prestasi_nama'][$i]) ? $post['prestasi_nama'][$i] : '';
                    if (empty(trim($nama))) continue;
                    
                    $ket = isset($post['prestasi_ket'][$i]) ? $post['prestasi_ket'][$i] : null;
                    
                    $this->db->query("INSERT INTO prestasi 
                                      (id_jadwal_setting, id_siswa, jenis_prestasi, nama_prestasi, keterangan)
                                      VALUES (:idj, :ids, :jenis, :nama, :ket)");
                    $this->db->bind('idj', $id_jadwal);
                    $this->db->bind('ids', $id_siswa);
                    $this->db->bind('jenis', $jenis);
                    $this->db->bind('nama', $nama);
                    $this->db->bind('ket', $ket);
                    $this->db->execute();
                }
            }

            // 5. Simpan catatan wali
            $catatan = isset($post['catatan']) ? $post['catatan'] : null;
            
            $this->db->query("INSERT INTO catatan_wali_kelas 
                              (id_jadwal_setting, id_siswa, catatan)
                              VALUES (:idj, :ids, :catatan)
                              ON DUPLICATE KEY UPDATE 
                                catatan = :catatan,
                                updated_at = CURRENT_TIMESTAMP");
            $this->db->bind('idj', $id_jadwal);
            $this->db->bind('ids', $id_siswa);
            $this->db->bind('catatan', $catatan);
            $this->db->execute();

            // Commit transaction
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Rollback jika ada error
            $this->db->rollback();
            error_log("Error simpan rapor: " . $e->getMessage());
            return false;
        }
    }

    // --- Cek kelengkapan data rapor siswa ---
// public function cek_kelengkapan_rapor($id_jadwal, $id_siswa)
// {
//     // Ambil data siswa untuk mendapatkan kelasnya
//     $this->db->query("SELECT kelas_siswa FROM siswa WHERE id_siswa = :ids");
//     $this->db->bind('ids', $id_siswa);
//     $siswa = $this->db->single();
    
//     if (!$siswa) {
//         return [
//             'nilai_sikap' => false,
//             'jumlah_nilai_mapel' => 0,
//             'total_mapel' => 0,
//             'persen_mapel' => 0,
//             'jumlah_ekskul' => 0,
//             'jumlah_prestasi' => 0,
//             'catatan' => false,
//             'persentase_total' => 0,
//             'status' => 'belum'
//         ];
//     }
    
//     // Ambil tanggal berlaku dari jadwal_setting
//     $this->db->query("SELECT berlaku_dari FROM jadwal_setting WHERE id_jadwal_setting = :id_jadwal");
//     $this->db->bind('id_jadwal', $id_jadwal);
//     $jadwal_result = $this->db->single();
    
//     if (!$jadwal_result) {
//         return [
//             'nilai_sikap' => false,
//             'jumlah_nilai_mapel' => 0,
//             'total_mapel' => 0,
//             'persen_mapel' => 0,
//             'jumlah_ekskul' => 0,
//             'jumlah_prestasi' => 0,
//             'catatan' => false,
//             'persentase_total' => 0,
//             'status' => 'belum'
//         ];
//     }
    
//     $berlaku_dari = $jadwal_result->berlaku_dari;
    
//     // Ambil semua mata pelajaran untuk kelas siswa pada periode ini
//     $sql = "SELECT COUNT(DISTINCT mp.id_pelajaran) as total 
//             FROM jadwal_lengkap jl
//             JOIN m_pelajaran mp ON (
//               jl.mp1 = mp.id_pelajaran OR 
//               jl.mp2 = mp.id_pelajaran OR 
//               jl.mp3 = mp.id_pelajaran OR 
//               jl.mp4 = mp.id_pelajaran OR 
//               jl.mp5 = mp.id_pelajaran OR 
//               jl.mp6 = mp.id_pelajaran OR 
//               jl.mp7 = mp.id_pelajaran OR 
//               jl.mp8 = mp.id_pelajaran OR 
//               jl.mp9 = mp.id_pelajaran OR 
//               jl.mp10 = mp.id_pelajaran
//             )
//             WHERE jl.kode_kelas = :kode_kelas
//               AND jl.validasi = 1
//               AND jl.berlaku_jadwal_dari = :berlaku_dari";
    
//     $this->db->query($sql);
//     $this->db->bind('kode_kelas', $siswa->kelas_siswa);
//     $this->db->bind('berlaku_dari', $berlaku_dari);
//     $result = $this->db->single();
//     $total_mapel = $result ? $result->total : 0;
    
//     // Cek nilai sikap
//     $this->db->query("SELECT id_nilai_sikap FROM nilai_sikap WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
//     $this->db->bind('idj', $id_jadwal);
//     $this->db->bind('ids', $id_siswa);
//     $nilai_sikap = ($this->db->single() !== false);

//     // Hitung nilai mapel
//     $this->db->query("SELECT COUNT(*) as jml FROM nilai_pelajaran WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
//     $this->db->bind('idj', $id_jadwal);
//     $this->db->bind('ids', $id_siswa);
//     $result = $this->db->single();
//     $jumlah_nilai_mapel = $result ? $result->jml : 0;
    
//     // Hitung persentase kelengkapan nilai mapel
//     $persen_mapel = ($total_mapel > 0) ? ($jumlah_nilai_mapel / $total_mapel) * 100 : 0;

//     // Hitung ekskul
//     $this->db->query("SELECT COUNT(*) as jml FROM ekstrakurikuler WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
//     $this->db->bind('idj', $id_jadwal);
//     $this->db->bind('ids', $id_siswa);
//     $result = $this->db->single();
//     $jumlah_ekskul = $result ? $result->jml : 0;

//     // Hitung prestasi
//     $this->db->query("SELECT COUNT(*) as jml FROM prestasi WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
//     $this->db->bind('idj', $id_jadwal);
//     $this->db->bind('ids', $id_siswa);
//     $result = $this->db->single();
//     $jumlah_prestasi = $result ? $result->jml : 0;

//     // Cek catatan
//     $this->db->query("SELECT id_catatan FROM catatan_wali_kelas WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
//     $this->db->bind('idj', $id_jadwal);
//     $this->db->bind('ids', $id_siswa);
//     $catatan = ($this->db->single() !== false);
    
//     // Hitung persentase total dengan bobot yang ditentukan
//     $persentase_total = 0;
    
//     // Nilai Mata Pelajaran 20%
//     $persentase_total += ($persen_mapel / 100) * 20;
    
//     // Penilaian Sikap 20%
//     $persentase_total += $nilai_sikap ? 20 : 0;
    
//     // Ekstrakurikuler 20%
//     $persentase_total += ($jumlah_ekskul > 0) ? 20 : 0;
    
//     // Prestasi 20%
//     $persentase_total += ($jumlah_prestasi > 0) ? 20 : 0;
    
//     // Catatan Wali Kelas 20%
//     $persentase_total += $catatan ? 20 : 0;
    
//     // Tentukan status kelengkapan
//     $status = 'belum';
//     if ($persentase_total >= 80) {
//         $status = 'lengkap';
//     } elseif ($persentase_total >= 40) {
//         $status = 'sebagian';
//     } else {
//         $status = 'minim';
//     }

//     return [
//         'nilai_sikap' => $nilai_sikap,
//         'jumlah_nilai_mapel' => $jumlah_nilai_mapel,
//         'total_mapel' => $total_mapel,
//         'persen_mapel' => round($persen_mapel),
//         'jumlah_ekskul' => $jumlah_ekskul,
//         'jumlah_prestasi' => $jumlah_prestasi,
//         'catatan' => $catatan,
//         'persentase_total' => round($persentase_total),
//         'status' => $status
//     ];
// }


// --- Cek kelengkapan data rapor siswa (REVISI) ---
public function cek_kelengkapan_rapor($id_jadwal, $id_siswa)
{
    // Ambil data siswa untuk mendapatkan kelasnya
    $this->db->query("SELECT kelas_siswa FROM siswa WHERE id_siswa = :ids");
    $this->db->bind('ids', $id_siswa);
    $siswa = $this->db->single();
    
    if (!$siswa) {
        return [
            'nilai_sikap' => false,
            'jumlah_nilai_mapel' => 0,
            'total_mapel' => 0,
            'persen_mapel' => 0,
            'jumlah_ekskul' => 0,
            'jumlah_prestasi' => 0,
            'catatan' => false,
            'persentase_total' => 0,
            'status' => 'belum'
        ];
    }
    
    // Ambil tanggal berlaku dari jadwal_setting
    $this->db->query("SELECT berlaku_dari FROM jadwal_setting WHERE id_jadwal_setting = :id_jadwal");
    $this->db->bind('id_jadwal', $id_jadwal);
    $jadwal_result = $this->db->single();
    
    if (!$jadwal_result) {
        return [
            'nilai_sikap' => false,
            'jumlah_nilai_mapel' => 0,
            'total_mapel' => 0,
            'persen_mapel' => 0,
            'jumlah_ekskul' => 0,
            'jumlah_prestasi' => 0,
            'catatan' => false,
            'persentase_total' => 0,
            'status' => 'belum'
        ];
    }
    
    $berlaku_dari = $jadwal_result->berlaku_dari;
    
    // Ambil semua mata pelajaran untuk kelas siswa pada periode ini
    $sql = "SELECT COUNT(DISTINCT mp.id_pelajaran) as total 
            FROM jadwal_lengkap jl
            JOIN m_pelajaran mp ON (
              jl.mp1 = mp.id_pelajaran OR 
              jl.mp2 = mp.id_pelajaran OR 
              jl.mp3 = mp.id_pelajaran OR 
              jl.mp4 = mp.id_pelajaran OR 
              jl.mp5 = mp.id_pelajaran OR 
              jl.mp6 = mp.id_pelajaran OR 
              jl.mp7 = mp.id_pelajaran OR 
              jl.mp8 = mp.id_pelajaran OR 
              jl.mp9 = mp.id_pelajaran OR 
              jl.mp10 = mp.id_pelajaran
            )
            WHERE jl.kode_kelas = :kode_kelas
              AND jl.validasi = 1
              AND jl.berlaku_jadwal_dari = :berlaku_dari";
    
    $this->db->query($sql);
    $this->db->bind('kode_kelas', $siswa->kelas_siswa);
    $this->db->bind('berlaku_dari', $berlaku_dari);
    $result = $this->db->single();
    $total_mapel = $result ? $result->total : 0;
    
    // Cek nilai sikap
    $this->db->query("SELECT id_nilai_sikap FROM nilai_sikap WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
    $this->db->bind('idj', $id_jadwal);
    $this->db->bind('ids', $id_siswa);
    $nilai_sikap = ($this->db->single() !== false);

    // Hitung nilai mapel
    $this->db->query("SELECT COUNT(*) as jml FROM nilai_pelajaran WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
    $this->db->bind('idj', $id_jadwal);
    $this->db->bind('ids', $id_siswa);
    $result = $this->db->single();
    $jumlah_nilai_mapel = $result ? $result->jml : 0;
    
    // Hitung persentase kelengkapan nilai mapel
    $persen_mapel = ($total_mapel > 0) ? ($jumlah_nilai_mapel / $total_mapel) * 100 : 0;

    // Hitung ekskul
    $this->db->query("SELECT COUNT(*) as jml FROM ekstrakurikuler WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
    $this->db->bind('idj', $id_jadwal);
    $this->db->bind('ids', $id_siswa);
    $result = $this->db->single();
    $jumlah_ekskul = $result ? $result->jml : 0;

    // Hitung prestasi
    $this->db->query("SELECT COUNT(*) as jml FROM prestasi WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
    $this->db->bind('idj', $id_jadwal);
    $this->db->bind('ids', $id_siswa);
    $result = $this->db->single();
    $jumlah_prestasi = $result ? $result->jml : 0;

    // Cek catatan
    $this->db->query("SELECT id_catatan FROM catatan_wali_kelas WHERE id_jadwal_setting = :idj AND id_siswa = :ids");
    $this->db->bind('idj', $id_jadwal);
    $this->db->bind('ids', $id_siswa);
    $catatan = ($this->db->single() !== false);
    
    // Hitung persentase total dengan bobot yang ditentukan
    $persentase_total = 0;
    
    // Nilai Mata Pelajaran 20%
    $persentase_total += ($persen_mapel / 100) * 20;
    
    // Penilaian Sikap 20%
    $persentase_total += $nilai_sikap ? 20 : 0;
    
    // Ekstrakurikuler 20%
    $persentase_total += ($jumlah_ekskul > 0) ? 20 : 0;
    
    // Prestasi 20%
    $persentase_total += ($jumlah_prestasi > 0) ? 20 : 0;
    
    // Catatan Wali Kelas 20%
    $persentase_total += $catatan ? 20 : 0;
    
    // Tentukan status kelengkapan
    $status = 'belum';
    if ($persentase_total >= 100) {
        $status = 'lengkap'; // 100% - Semua lengkap
    } elseif ($persentase_total >= 80) {
        $status = 'hampir_lengkap'; // 80-99% - Hampir lengkap
    } elseif ($persentase_total >= 40) {
        $status = 'sebagian'; // 40-79% - Sebagian
    } else {
        $status = 'minim'; // <40% - Minim
    }

    return [
        'nilai_sikap' => $nilai_sikap,
        'jumlah_nilai_mapel' => $jumlah_nilai_mapel,
        'total_mapel' => $total_mapel,
        'persen_mapel' => round($persen_mapel),
        'jumlah_ekskul' => $jumlah_ekskul,
        'jumlah_prestasi' => $jumlah_prestasi,
        'catatan' => $catatan,
        'persentase_total' => round($persentase_total),
        'status' => $status
    ];
}

    // Cek ID siswa berdasarkan NIS
  public function cek_id_saya($nis) 
  {
      $sql = "SELECT id_siswa FROM siswa WHERE nis = :nis AND status_siswa = 'Aktif'";
      $this->db->query($sql);
      $this->db->bind('nis', $nis);
      return $this->db->single();
  }

  // Ambil data lengkap siswa berdasarkan NIS
  public function ambil_data_saya_by_id($id_siswa)
  {
      $sql = "SELECT 
                s.*,
                jl.wali_kelas,
                p.nama as nama_wali_kelas
              FROM siswa s
              LEFT JOIN jadwal_lengkap jl ON s.kelas_siswa = jl.kode_kelas AND jl.validasi = 1
              LEFT JOIN pegawai p ON jl.wali_kelas = p.nik
              WHERE s.id_siswa = :id_siswa 
                AND s.status_siswa = 'Aktif'
              LIMIT 1";
      
      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      return $this->db->single();
  }

  // Ambil semua jadwal setting (untuk dropdown pemilihan semester)
  public function ambil_semua_jadwal_setting()
  {
      $sql = "SELECT 
                js.*,
                ta.tahun_ajaran
              FROM jadwal_setting js
              JOIN m_tahun_ajaran ta ON js.id_tahun_ajaran = ta.id_tahun_ajaran
              ORDER BY js.id_tahun_ajaran DESC, js.semester DESC, js.blok DESC";
      
      $this->db->query($sql);
      return $this->db->resultSet();
  }

  // Ambil nilai pelajaran siswa berdasarkan ID siswa dan jadwal setting
  public function ambil_siswa_nilai_pelajaran($id_siswa, $id_jadwal_setting = null)
  {
      // Jika tidak ada id_jadwal_setting, ambil yang aktif
      if ($id_jadwal_setting === null) {
          $jadwal_aktif = $this->ambil_jadwal_aktif();
          if (!$jadwal_aktif) return [];
          $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
      }

      $sql = "SELECT 
                np.*,
                mp.mata_pelajaran,
                mp.singkatan
              FROM nilai_pelajaran np
              JOIN m_pelajaran mp ON np.id_pelajaran = mp.id_pelajaran
              WHERE np.id_siswa = :id_siswa
                AND np.id_jadwal_setting = :id_jadwal_setting
              ORDER BY mp.mata_pelajaran";

      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      $this->db->bind('id_jadwal_setting', $id_jadwal_setting);
      return $this->db->resultSet();
  }

  // Ambil nilai sikap siswa
  public function ambil_siswa_nilai_sikap($id_siswa, $id_jadwal_setting = null)
  {
      if ($id_jadwal_setting === null) {
          $jadwal_aktif = $this->ambil_jadwal_aktif();
          if (!$jadwal_aktif) return null;
          $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
      }

      $sql = "SELECT * FROM nilai_sikap 
              WHERE id_siswa = :id_siswa 
                AND id_jadwal_setting = :id_jadwal_setting";
      
      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      $this->db->bind('id_jadwal_setting', $id_jadwal_setting);
      return $this->db->single();
  }

  // Ambil ekstrakurikuler siswa
  public function ambil_siswa_ekstrakurikuler($id_siswa, $id_jadwal_setting = null)
  {
      if ($id_jadwal_setting === null) {
          $jadwal_aktif = $this->ambil_jadwal_aktif();
          if (!$jadwal_aktif) return [];
          $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
      }

      $sql = "SELECT * FROM ekstrakurikuler 
              WHERE id_siswa = :id_siswa 
                AND id_jadwal_setting = :id_jadwal_setting
              ORDER BY nama_ekstrakurikuler";
      
      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      $this->db->bind('id_jadwal_setting', $id_jadwal_setting);
      return $this->db->resultSet();
  }

  // Ambil prestasi siswa
  public function ambil_siswa_prestasi($id_siswa, $id_jadwal_setting = null)
  {
      if ($id_jadwal_setting === null) {
          $jadwal_aktif = $this->ambil_jadwal_aktif();
          if (!$jadwal_aktif) return [];
          $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
      }

      $sql = "SELECT * FROM prestasi 
              WHERE id_siswa = :id_siswa 
                AND id_jadwal_setting = :id_jadwal_setting
              ORDER BY jenis_prestasi, nama_prestasi";
      
      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      $this->db->bind('id_jadwal_setting', $id_jadwal_setting);
      return $this->db->resultSet();
  }

  // Ambil catatan wali kelas untuk siswa
  public function ambil_siswa_catatan_wali($id_siswa, $id_jadwal_setting = null)
  {
      if ($id_jadwal_setting === null) {
          $jadwal_aktif = $this->ambil_jadwal_aktif();
          if (!$jadwal_aktif) return null;
          $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
      }

      $sql = "SELECT * FROM catatan_wali_kelas 
              WHERE id_siswa = :id_siswa 
                AND id_jadwal_setting = :id_jadwal_setting";
      
      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      $this->db->bind('id_jadwal_setting', $id_jadwal_setting);
      return $this->db->single();
  }

  // Ambil rapor lengkap siswa (ALL IN ONE)
  public function ambil_rapor_lengkap_siswa($id_siswa, $id_jadwal_setting = null)
  {
      if ($id_jadwal_setting === null) {
          $jadwal_aktif = $this->ambil_jadwal_aktif();
          if (!$jadwal_aktif) {
              return [
                  'ada_data' => false,
                  'message' => 'Tidak ada semester yang aktif'
              ];
          }
          $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
      }

      // Ambil info jadwal
      $this->db->query("SELECT js.*, ta.tahun_ajaran 
                        FROM jadwal_setting js
                        JOIN m_tahun_ajaran ta ON js.id_tahun_ajaran = ta.id_tahun_ajaran
                        WHERE js.id_jadwal_setting = :id");
      $this->db->bind('id', $id_jadwal_setting);
      $jadwal = $this->db->single();

      // Cek apakah ada nilai
      $this->db->query("SELECT COUNT(*) as jml FROM nilai_pelajaran 
                        WHERE id_siswa = :ids AND id_jadwal_setting = :idj");
      $this->db->bind('ids', $id_siswa);
      $this->db->bind('idj', $id_jadwal_setting);
      $cek = $this->db->single();

      if ($cek->jml == 0) {
          return [
              'ada_data' => false,
              'jadwal' => $jadwal,
              'message' => 'Rapor untuk periode ini belum tersedia. Wali kelas Anda sedang memproses nilai.'
          ];
      }

      return [
          'ada_data' => true,
          'jadwal' => $jadwal,
          'nilai_pelajaran' => $this->ambil_siswa_nilai_pelajaran($id_siswa, $id_jadwal_setting),
          'nilai_sikap' => $this->ambil_siswa_nilai_sikap($id_siswa, $id_jadwal_setting),
          'ekstrakurikuler' => $this->ambil_siswa_ekstrakurikuler($id_siswa, $id_jadwal_setting),
          'prestasi' => $this->ambil_siswa_prestasi($id_siswa, $id_jadwal_setting),
          'catatan' => $this->ambil_siswa_catatan_wali($id_siswa, $id_jadwal_setting)
      ];
  }

  // Hitung rata-rata nilai siswa
  public function hitung_rata_rata_nilai($id_siswa, $id_jadwal_setting = null)
  {
      if ($id_jadwal_setting === null) {
          $jadwal_aktif = $this->ambil_jadwal_aktif();
          if (!$jadwal_aktif) return 0;
          $id_jadwal_setting = $jadwal_aktif->id_jadwal_setting;
      }

      $sql = "SELECT AVG(nilai) as rata_rata 
              FROM nilai_pelajaran 
              WHERE id_siswa = :id_siswa 
                AND id_jadwal_setting = :id_jadwal_setting
                AND nilai IS NOT NULL";
      
      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      $this->db->bind('id_jadwal_setting', $id_jadwal_setting);
      $result = $this->db->single();
      
      return $result ? round($result->rata_rata, 2) : 0;
  }
}