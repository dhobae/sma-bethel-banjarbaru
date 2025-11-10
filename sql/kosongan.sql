-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2025 at 09:37 AM
-- Server version: 8.0.30
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smabethel`
--

CREATE TABLE `absen` (
  `id` int NOT NULL,
  `nik` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `status_masuk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `from_masuk` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `jam_pulang` time NOT NULL,
  `status_pulang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `from_pulang` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `loc_masuk` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `loc_pulang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `visitid` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `visitid_pulang` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `absen_harian_siswa` (
  `id_ahs` int NOT NULL,
  `nis_ahs` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_ahs` date DEFAULT NULL,
  `status_ahs` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Hadir, Alpa, Izin, Sakit, Libur',
  `jam_masuk_ahs` time DEFAULT NULL,
  `id_libur` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas_ahs` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wali_kelas_ahs` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jadwal_setting_ahs` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `absen_izin` (
  `id_izin` int NOT NULL,
  `nik_izin` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_izin` date DEFAULT NULL,
  `kelas_izin` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang_izin` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jam_izin` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mata_pelajaran_pendek` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mata_pelajaran` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_izin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alasan_izin` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_materi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `acc` int DEFAULT NULL COMMENT '0 belum acc, 1 acc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `absen_kelas` (
  `id_absen_kelas` int NOT NULL,
  `nik_absen_kelas` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_absen_kelas` date DEFAULT NULL,
  `kelas_absen_kelas` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang_absen_kelas` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jam_absen_kelas` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mata_pelajaran` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mata_pelajaran_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `materi_pelajaran` text COLLATE utf8mb4_general_ci,
  `wali_kelas_absen` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `absen_kelas_siswa` (
  `id_aks` int NOT NULL,
  `tgl_aks` date DEFAULT NULL,
  `nis_aks` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas_aks` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wali_kelas_aks` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam1` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam1` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam2` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam2` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam3` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam3` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam4` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam4` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam5` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam5` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam6` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam6` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam7` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam7` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam8` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam8` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam9` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam9` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam10` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam10` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jam11` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_jam11` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `admin` (
  `id` int NOT NULL,
  `hak_akses` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_admin` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nip_pegawai` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `dar` (
  `id_dar` int NOT NULL,
  `nik_dar` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_dar` date DEFAULT NULL,
  `isi_dar` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `waktu_input` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `ip_address` (
  `id` int NOT NULL,
  `ip_address` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `izin` (
  `id` int NOT NULL,
  `nik` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `status_izin` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan_izin` varchar(250) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `izin_keluar_jam_kerja` (
  `id_izin_keluar` int NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keperluan` text COLLATE utf8mb4_general_ci,
  `dari_jam` time DEFAULT NULL,
  `sampai_jam` time DEFAULT NULL,
  `status_izin_keluar` int DEFAULT NULL COMMENT '0 baru, 1 acc, 2 tolak',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `izin_mengajar` (
  `id_izin` int NOT NULL,
  `nik` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_awal` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `acc` varchar(10) COLLATE utf8mb4_general_ci DEFAULT 'Belum' COMMENT 'Sudah atau Belum',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `izin_mengajar_transaksi` (
  `id_transaksi` int NOT NULL,
  `id_izin_transaksi` int DEFAULT NULL,
  `kelas` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mata_pelajaran` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_izin` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'izin, sakit, cuti, TL',
  `alasan_izin` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `materi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `izin_siswa` (
  `id_izin` int NOT NULL,
  `nis_izin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas_izin` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wali_kelas_izin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_izin` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Izin, Sakit',
  `mulai_izin` date DEFAULT NULL,
  `sampai_izin` date DEFAULT NULL,
  `tgl_dibuat_izin` date DEFAULT NULL,
  `alasan_izin` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_izin` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_izin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Menunggu ACC, Disetujui, Ditolak',
  `nik_status_izin` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jabatan` (
  `no` int NOT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `level` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jadwal` (
  `id` int NOT NULL,
  `kelas` varchar(4) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jam` int DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jadwal_lengkap` (
  `id_jadwal_lengkap` int NOT NULL,
  `hari` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_kelas` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas` varchar(3) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wali_kelas` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prodi` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp1` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru1` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp2` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru2` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp3` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru3` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp4` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru4` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp5` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru5` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp6` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru6` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp7` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru7` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp8` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru8` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp9` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru9` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp10` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru10` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mp11` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `guru11` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `validasi` int DEFAULT NULL COMMENT '0 belum, 1 sudah',
  `validasi_oleh` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_validasi` date DEFAULT NULL,
  `berlaku_jadwal_dari` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jadwal_setting` (
  `id_jadwal_setting` int NOT NULL,
  `id_tahun_ajaran` int DEFAULT NULL,
  `semester` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blok` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `berlaku_dari` date DEFAULT NULL,
  `tanggal_dirubah` date DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT '1 aktif, 0 tidak aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `kantor` (
  `id_kantor` int NOT NULL,
  `nama_kantor` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `loc_kantor` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `libur` (
  `id` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `keterangan_libur` varchar(250) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `login_attempts` (
  `id` int NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `master_jam` (
  `id` int NOT NULL,
  `berlaku_mulai` date DEFAULT NULL,
  `hari_kerja` int NOT NULL,
  `jam_kerja` decimal(3,1) NOT NULL,
  `masuk` time NOT NULL,
  `pulang` time NOT NULL,
  `wfh_masuk` time NOT NULL,
  `wfh_pulang` time NOT NULL,
  `jam_istirahat` decimal(3,1) DEFAULT NULL,
  `masuk_jumat` time NOT NULL,
  `pulang_jumat` time NOT NULL,
  `masuk_jumat_wfh` time NOT NULL,
  `pulang_jumat_wfh` time NOT NULL,
  `jam_kerja_jumat` decimal(3,1) NOT NULL,
  `jam_istirahat_jumat` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `m_pelajaran` (
  `id_pelajaran` int NOT NULL,
  `mata_pelajaran` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `singkatan` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prodi` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `m_prodi` (
  `id_prodi` int NOT NULL,
  `kode_prodi` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_prodi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ketua_prodi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_prodi` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Aktif atau Tidak',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `m_tahun_ajaran` (
  `id_tahun_ajaran` int NOT NULL,
  `tahun_ajaran` varchar(20) DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT '0 Tidak aktif, 1 Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `notif` (
  `id_notif` int NOT NULL,
  `status_notif` int DEFAULT NULL COMMENT '0 non aktif, 1 aktif',
  `icon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `text` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isi_tombol` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `warna_tombol` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `background` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `warna_title` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `warna_konten` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pegawai` (
  `id_pegawai` int NOT NULL,
  `nik` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rfid` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password__` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telegram` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mengajar` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `full_time` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jk` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `agama` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_hp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notif_wa` varchar(15) COLLATE utf8mb4_general_ci DEFAULT 'Tidak',
  `tempat_lahir` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `pendidikan` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `urutan` int DEFAULT NULL,
  `avatar` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dar` varchar(10) COLLATE utf8mb4_general_ci DEFAULT 'Tidak' COMMENT 'Ya, Tidak',
  `hapus_pegawai` int DEFAULT '0',
  `kunci` int DEFAULT NULL COMMENT '0 tidak terkunci, 1 terkunci',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pendapat` (
  `id_pendapat` int NOT NULL,
  `nik_pendapat` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pendapat` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `saran` text COLLATE utf8mb4_general_ci,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pengunjung` (
  `id` int NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `npk` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `dari` varchar(3) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `hits` int NOT NULL,
  `online` varchar(30) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `polling` (
  `setuju` int NOT NULL,
  `dengan_catatan` int NOT NULL,
  `tidak_setuju` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `send_wa` (
  `id_send_wa` int NOT NULL,
  `nik_send_wa` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `absen_datang` int DEFAULT NULL COMMENT '0 nonaktif, 1 aktif',
  `absen_pulang` int DEFAULT NULL,
  `notif_datang` int DEFAULT NULL,
  `notif_pulang` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `settingan` (
  `id` int NOT NULL,
  `home_dosen` text COLLATE utf8mb4_general_ci,
  `kontak` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `nis` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_siswa` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_masuk` year DEFAULT NULL,
  `prodi` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas_siswa` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang_siswa` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NISN` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `propinsi` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kabupaten` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kecamatan` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_hp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_wali` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_wali` text COLLATE utf8mb4_general_ci,
  `nomor_hp_wali` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_ibu` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pekerjaan_wali` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_siswa` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Aktif, Pindah atau Alumni',
  `foto_siswa` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rfid` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `siswa_hapus` (
  `id_siswa` int NOT NULL,
  `nis` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_siswa` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_masuk` year DEFAULT NULL,
  `prodi` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas_siswa` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang_siswa` varchar(1) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `NISN` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `agama` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `propinsi` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kabupaten` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kecamatan` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_hp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_wali` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_wali` text COLLATE utf8mb4_general_ci,
  `nomor_hp_wali` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_ibu` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pekerjaan_wali` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_siswa` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Aktif, Pindah atau Alumni',
  `foto_siswa` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tb_kabupaten` (
  `id_kabupaten` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_propinsi_kabupaten` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kabupaten` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tipe_kabupaten` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tb_kecamatan` (
  `id_kecamatan` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kabupaten_kecamatan` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kecamatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tb_propinsi` (
  `id_propinsi` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_propinsi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tmp_izin` (
  `id` int NOT NULL,
  `npk` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `status_izin` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan_izin` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nik_user` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_user` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- tambahan dari AI
ALTER TABLE `absen_harian_siswa` 
   ADD COLUMN `jam_pulang_ahs` TIME NULL AFTER `jam_masuk_ahs`;

CREATE TABLE `kelompok_tugas` (
  `id_kelompok_tugas` int NOT NULL AUTO_INCREMENT,
  `kode_tugas` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_pelajaran` int DEFAULT NULL,
  `mata_pelajaran` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `singkatan` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik_guru` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_guru` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ruang` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prodi` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jadwal_setting` int DEFAULT NULL,
  `jumlah_jam_perminggu` int DEFAULT NULL COMMENT 'Jumlah jam per minggu untuk mapel ini',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kelompok_tugas`),
  UNIQUE KEY `kode_tugas` (`kode_tugas`),
  KEY `id_jadwal_setting` (`id_jadwal_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `kelompok_waktu` (
  `id_kelompok_waktu` int NOT NULL AUTO_INCREMENT,
  `kode_waktu` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `hari` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `urutan_hari` int NOT NULL COMMENT '1=Senin, 2=Selasa, dst',
  `jam_ke` int NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `rentang_waktu` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_jadwal_setting` int DEFAULT NULL,
  `aktif` tinyint DEFAULT 1 COMMENT '1=aktif, 0=tidak aktif (libur/istirahat)',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_kelompok_waktu`),
  UNIQUE KEY `kode_waktu` (`kode_waktu`),
  KEY `id_jadwal_setting` (`id_jadwal_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `jadwal_generate_log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_jadwal_setting` int DEFAULT NULL,
  `tanggal_generate` datetime DEFAULT CURRENT_TIMESTAMP,
  `jumlah_generasi` int DEFAULT NULL,
  `jumlah_populasi` int DEFAULT NULL,
  `probabilitas_crossover` decimal(3,2) DEFAULT NULL,
  `probabilitas_mutasi` decimal(3,2) DEFAULT NULL,
  `fitness_terbaik` decimal(5,4) DEFAULT NULL,
  `jumlah_konflik_guru` int DEFAULT NULL,
  `jumlah_konflik_kelas` int DEFAULT NULL,
  `waktu_komputasi` int DEFAULT NULL COMMENT 'Dalam detik',
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Sukses, Gagal, Proses',
  `keterangan` text COLLATE utf8mb4_general_ci,
  `user_generate` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id_jadwal_setting` (`id_jadwal_setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `absen_harian_siswa`
  ADD PRIMARY KEY (`id_ahs`);


ALTER TABLE `absen_izin`
  ADD PRIMARY KEY (`id_izin`);


ALTER TABLE `absen_kelas`
  ADD PRIMARY KEY (`id_absen_kelas`);


ALTER TABLE `absen_kelas_siswa`
  ADD PRIMARY KEY (`id_aks`);

ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dar`
  ADD PRIMARY KEY (`id_dar`);

ALTER TABLE `ip_address`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `izin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `izin_keluar_jam_kerja`
  ADD PRIMARY KEY (`id_izin_keluar`);

ALTER TABLE `izin_mengajar`
  ADD PRIMARY KEY (`id_izin`);

ALTER TABLE `izin_mengajar_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

ALTER TABLE `izin_siswa`
  ADD PRIMARY KEY (`id_izin`);

ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`no`);

ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `jadwal_lengkap`
  ADD PRIMARY KEY (`id_jadwal_lengkap`);

ALTER TABLE `jadwal_setting`
  ADD PRIMARY KEY (`id_jadwal_setting`);

ALTER TABLE `kantor`
  ADD PRIMARY KEY (`id_kantor`);

ALTER TABLE `libur`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `master_jam`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `m_pelajaran`
  ADD PRIMARY KEY (`id_pelajaran`);


ALTER TABLE `m_prodi`
  ADD PRIMARY KEY (`id_prodi`);


ALTER TABLE `m_tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun_ajaran`);


ALTER TABLE `notif`
  ADD PRIMARY KEY (`id_notif`);


ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);


ALTER TABLE `pendapat`
  ADD PRIMARY KEY (`id_pendapat`);


ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `send_wa`
  ADD PRIMARY KEY (`id_send_wa`);


ALTER TABLE `settingan`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);


ALTER TABLE `tb_propinsi`
  ADD PRIMARY KEY (`id_propinsi`);


ALTER TABLE `tmp_izin`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

ALTER TABLE `absen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `absen_harian_siswa`
  MODIFY `id_ahs` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `absen_izin`
  MODIFY `id_izin` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `absen_kelas`
  MODIFY `id_absen_kelas` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `absen_kelas_siswa`
  MODIFY `id_aks` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `dar`
  MODIFY `id_dar` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `ip_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `izin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `izin_keluar_jam_kerja`
  MODIFY `id_izin_keluar` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `izin_mengajar`
  MODIFY `id_izin` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `izin_mengajar_transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `izin_siswa`
  MODIFY `id_izin` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `jabatan`
  MODIFY `no` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `jadwal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `jadwal_lengkap`
  MODIFY `id_jadwal_lengkap` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `jadwal_setting`
  MODIFY `id_jadwal_setting` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `kantor`
  MODIFY `id_kantor` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `libur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `login_attempts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `master_jam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `m_pelajaran`
  MODIFY `id_pelajaran` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `m_prodi`
  MODIFY `id_prodi` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `m_tahun_ajaran`
  MODIFY `id_tahun_ajaran` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `notif`
  MODIFY `id_notif` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `pendapat`
  MODIFY `id_pendapat` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `pengunjung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `send_wa`
  MODIFY `id_send_wa` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `settingan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `tmp_izin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- tambahan dari AI
ALTER TABLE `absen_harian_siswa` 
   ADD COLUMN `jam_pulang_ahs` TIME NULL AFTER `jam_masuk_ahs`;

-- keperluan absen null dulu jam pulang
ALTER TABLE `absen` CHANGE `jam_pulang` `jam_pulang` TIME NULL;
ALTER TABLE `absen` CHANGE `status_pulang` `status_pulang` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
ALTER TABLE `absen` CHANGE `from_pulang` `from_pulang` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;

