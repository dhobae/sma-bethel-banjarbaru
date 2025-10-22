-- user
INSERT INTO `users` (`id_user`, `nik_user`, `username`, `nama_user`, `password`, `role`, `created_at`, `updated_at`) VALUES 
('1', 'admin', 'admin', 'Administrator', '$2y$10$/IK7WOEf2mhNgnjOCQWZUeycV1R0nUwVqZBL4FHB1ehT4TIAkMubW', 'admin', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('2', '2637739641300022', '2637739641300022', 'Kurniah Amalia, S.PAK', '$2y$10$/IK7WOEf2mhNgnjOCQWZUeycV1R0nUwVqZBL4FHB1ehT4TIAkMubW', 'pegawai', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- pegawai
INSERT INTO `pegawai` (`id_pegawai`, `nik`, `username`, `rfid`, `password__`, `telegram`, `nama`, `kode`, `jabatan`, `mengajar`, `full_time`, `jk`, `agama`, `nomor_hp`, `notif_wa`, `tempat_lahir`, `tgl_lahir`, `alamat`, `pendidikan`, `email`, `first_name`, `absen`, `urutan`, `avatar`, `dar`, `hapus_pegawai`, `kunci`, `created_at`, `updated_at`) VALUES 
('1', '11223399', '11223399', NULL, '$2y$10$/IK7WOEf2mhNgnjOCQWZUeycV1R0nUwVqZBL4FHB1ehT4TIAkMubW', NULL, 'Kurniah Amalia, S.PAK ', NULL, 'GURU', 'Ya', 'Full Time', 'Perempuan', '-', '085750667547', 'Tidak', '-', NULL, '-', 'S1', '-', 'Kurniah Amalia', 'Aktif', '1', NULL, 'Tidak', '0', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);z