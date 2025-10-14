<?php
class SchedulerService
{
    private $db;
    private $populationSize = 50;
    private $maxGenerations = 100;
    private $mutationRate = 0.1;
    private $crossoverRate = 0.8;
    private $eliteSize = 5;

    // Data dari database
    private $teachers = [];
    private $subjects = [];
    private $classes = [];
    private $prodi = [];
    private $waliKelas = [];

    public function __construct($db)
    {
        $this->db = $db;
        $this->loadDataFromDatabase();
    }

    private function loadDataFromDatabase()
    {
        error_log("SchedulerService: Memuat data dari database...");

        // Load data guru
        $this->db->query("SELECT * FROM pegawai WHERE mengajar = 'Ya' AND hapus_pegawai = 0");
        $teachers = $this->db->resultSet();
        foreach ($teachers as $teacher) {
            $this->teachers[$teacher->nik] = $teacher;
        }
        error_log("SchedulerService: " . count($this->teachers) . " guru dimuat.");

        // Load data mata pelajaran
        $this->db->query("SELECT * FROM m_pelajaran");
        $subjects = $this->db->resultSet();
        foreach ($subjects as $subject) {
            $this->subjects[$subject->id_pelajaran] = $subject;
        }
        error_log("SchedulerService: " . count($this->subjects) . " mata pelajaran dimuat.");

        // Load data prodi
        $this->db->query("SELECT * FROM m_prodi WHERE status_prodi = 'Aktif'");
        $prodi = $this->db->resultSet();
        foreach ($prodi as $p) {
            $this->prodi[$p->kode_prodi] = $p;
        }
        error_log("SchedulerService: " . count($this->prodi) . " prodi dimuat.");

        // Load data kelas dari tabel jadwal
        $this->db->query("SELECT DISTINCT kelas, ruang FROM jadwal WHERE kelas IS NOT NULL ORDER BY kelas");
        $classes = $this->db->resultSet();
        foreach ($classes as $class) {
            $this->classes[] = $class;
        }
        error_log("SchedulerService: " . count($this->classes) . " kelas dimuat dari tabel jadwal.");

        // Load data wali kelas dari jadwal_lengkap (jika ada)
        $this->db->query("SELECT DISTINCT kelas, wali_kelas FROM jadwal_lengkap WHERE kelas IS NOT NULL AND wali_kelas IS NOT NULL");
        $waliKelasData = $this->db->resultSet();
        foreach ($waliKelasData as $wk) {
            $this->waliKelas[$wk->kelas] = $wk->wali_kelas;
        }
        error_log("SchedulerService: " . count($this->waliKelas) . " data wali kelas dimuat.");
    }

    public function generateSchedule()
    {
        error_log("SchedulerService: generateSchedule() dimulai.");

        if (empty($this->teachers) || empty($this->subjects) || empty($this->classes)) {
            error_log("SchedulerService: ERROR - Data guru, mata pelajaran, atau kelas kosong. Tidak bisa melanjutkan.");
            return [];
        }

        // Inisialisasi populasi
        $population = $this->initializePopulation();
        error_log("SchedulerService: Populasi awal diinisialisasi dengan " . count($population) . " individu.");

        // Evolusi
        for ($generation = 0; $generation < $this->maxGenerations; $generation++) {
            // Evaluasi fitness
            $fitnessScores = [];
            foreach ($population as $index => $chromosome) {
                $fitness = $this->calculateFitness($chromosome);
                $fitnessScores[] = $fitness;

                // Log fitness terbaik di generasi ini
                if ($fitness > 0.9 && $generation % 10 == 0) {
                    error_log("SchedulerService: Generasi " . $generation . " - Individu " . $index . " Fitness: " . number_format($fitness, 4));
                }
            }

            // Sorting berdasarkan fitness
            array_multisort($fitnessScores, SORT_DESC, $population);

            // Log setiap 10 generasi
            if ($generation % 10 == 0) {
                error_log("SchedulerService: Generasi " . $generation . " - Fitness Terbaik: " . number_format($fitnessScores[0], 4));
            }

            // Cek apakah sudah menemukan solusi sempurna
            if ($fitnessScores[0] >= 0.99) {
                error_log("SchedulerService: Solusi optimal ditemukan di generasi " . $generation);
                break;
            }

            // Buat generasi baru
            $newPopulation = [];

            // Elitisme - simpan individu terbaik
            for ($i = 0; $i < $this->eliteSize; $i++) {
                $newPopulation[] = $population[$i];
            }

            // Seleksi dan reproduksi
            while (count($newPopulation) < $this->populationSize) {
                $parent1 = $this->selection($population, $fitnessScores);
                $parent2 = $this->selection($population, $fitnessScores);

                if (rand(0, 100) / 100 < $this->crossoverRate) {
                    $offspring = $this->crossover($parent1, $parent2);
                } else {
                    $offspring = $parent1;
                }

                if (rand(0, 100) / 100 < $this->mutationRate) {
                    $offspring = $this->mutate($offspring);
                }

                $newPopulation[] = $offspring;
            }

            $population = $newPopulation;
        }

        // Kembalikan jadwal terbaik
        $bestSchedule = $population[0];
        error_log("SchedulerService: Evolusi selesai. Mendekode kromosom terbaik...");
        return $this->decodeChromosome($bestSchedule);
    }

    /**
     * Membuat populasi awal dengan memperhatikan hard constraint
     */
    private function initializePopulation()
    {
        $population = [];
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        for ($i = 0; $i < $this->populationSize; $i++) {
            $chromosome = [];
            
            // Track guru yang sudah mengajar per hari per jam
            $teacherSlots = [];

            foreach ($this->classes as $class) {
                foreach ($hariList as $hari) {
                    $scheduleEntry = [
                        'hari' => $hari,
                        'kelas' => $class->kelas,
                        'ruang' => $class->ruang,
                        'wali_kelas' => $this->waliKelas[$class->kelas] ?? '',
                        'prodi' => $this->getProdiForKelas($class->kelas),
                        'jam_ke' => [],
                    ];

                    // Untuk setiap jam ke (1-11)
                    for ($jam = 1; $jam <= 11; $jam++) {
                        // Skip untuk hari Jumat jam 8-11
                        if ($hari == 'Jumat' && $jam >= 8) {
                            continue;
                        }

                        // Pilih mata pelajaran acak
                        $subjectId = array_rand($this->subjects);
                        
                        // Pilih guru yang BELUM mengajar di jam ini
                        $teacherId = $this->getAvailableTeacherForSlot($hari, $jam, $teacherSlots);

                        if ($teacherId) {
                            // Tandai guru sudah mengajar di slot ini
                            if (!isset($teacherSlots[$hari][$jam])) {
                                $teacherSlots[$hari][$jam] = [];
                            }
                            $teacherSlots[$hari][$jam][$teacherId] = true;

                            $scheduleEntry['jam_ke'][$jam] = [
                                'mata_pelajaran' => $subjectId,
                                'guru' => $teacherId,
                            ];
                        } else {
                            // Jika tidak ada guru tersedia, biarkan kosong
                            $scheduleEntry['jam_ke'][$jam] = [
                                'mata_pelajaran' => null,
                                'guru' => null,
                            ];
                        }
                    }

                    $chromosome[] = $scheduleEntry;
                }
            }

            $population[] = $chromosome;
        }

        return $population;
    }

    /**
     * Mendapatkan guru yang tersedia untuk slot waktu tertentu
     */
    private function getAvailableTeacherForSlot($hari, $jam, &$teacherSlots)
    {
        if (empty($this->teachers)) {
            return null;
        }

        // Dapatkan daftar guru yang belum mengajar di slot ini
        $availableTeachers = [];
        foreach (array_keys($this->teachers) as $teacherId) {
            // Cek apakah guru sudah mengajar di slot ini
            if (!isset($teacherSlots[$hari][$jam][$teacherId])) {
                $availableTeachers[] = $teacherId;
            }
        }

        // Jika ada guru tersedia, pilih secara acak
        if (!empty($availableTeachers)) {
            return $availableTeachers[array_rand($availableTeachers)];
        }

        // Jika tidak ada guru tersedia, kembalikan null
        return null;
    }

    private function getProdiForKelas($kelas)
    {
        $tingkat = substr($kelas, 0, 2);

        if ($tingkat == 'X') {
            return (rand(0, 1) == 0) ? 'TJAT' : 'TKJ';
        } else if ($tingkat == 'XI' || $tingkat == 'XII') {
            $prodiKeys = array_keys($this->prodi);
            return $prodiKeys[array_rand($prodiKeys)];
        }

        return 'TJAT';
    }

    private function getRandomTeacherForSubject($subjectId)
    {
        if (empty($this->teachers)) {
            return null;
        }

        $teacherIds = array_keys($this->teachers);
        return $teacherIds[array_rand($teacherIds)];
    }

    /**
     * Menghitung fitness dengan penalti yang lebih berat untuk pelanggaran hard constraint
     */
    private function calculateFitness($chromosome)
    {
        $totalSlots = 0;
        $hardConflicts = 0;  // Konflik hard constraint
        $softViolations = 0; // Pelanggaran soft constraint (jika ada)

        // HARD CONSTRAINT 1: Cek konflik guru (tidak boleh mengajar di 2 tempat pada waktu yang sama)
        $teacherSchedule = [];
        foreach ($chromosome as $daySchedule) {
            $hari = $daySchedule['hari'];
            foreach ($daySchedule['jam_ke'] as $jam => $jamSchedule) {
                if (empty($jamSchedule['guru'])) {
                    continue;
                }

                $totalSlots++;
                $teacherId = $jamSchedule['guru'];

                // Cek apakah guru sudah mengajar di waktu yang sama
                if (isset($teacherSchedule[$hari][$jam][$teacherId])) {
                    $hardConflicts++;
                    error_log("KONFLIK GURU: Guru $teacherId mengajar di 2 tempat pada $hari jam ke-$jam");
                } else {
                    $teacherSchedule[$hari][$jam][$teacherId] = true;
                }
            }
        }

        // HARD CONSTRAINT 2: Cek konflik kelas (tidak boleh ada 2 pelajaran di waktu yang sama)
        $classSchedule = [];
        foreach ($chromosome as $daySchedule) {
            $hari = $daySchedule['hari'];
            $kelas = $daySchedule['kelas'];
            foreach ($daySchedule['jam_ke'] as $jam => $jamSchedule) {
                if (empty($jamSchedule['mata_pelajaran'])) {
                    continue;
                }

                // Cek apakah kelas sudah memiliki pelajaran di waktu yang sama
                if (isset($classSchedule[$hari][$jam][$kelas])) {
                    $hardConflicts++;
                    error_log("KONFLIK KELAS: Kelas $kelas memiliki 2 pelajaran pada $hari jam ke-$jam");
                } else {
                    $classSchedule[$hari][$jam][$kelas] = true;
                }
            }
        }

        // Hitung fitness dengan penalti berat untuk hard constraint
        if ($totalSlots == 0) {
            error_log("ERROR: Total slots = 0");
            return 0;
        }

        // Penalti: setiap hard conflict mengurangi fitness secara signifikan
        $penalty = ($hardConflicts * 2.0) / $totalSlots; // Penalti 2x lipat
        $fitness = 1.0 - $penalty;

        return max(0, $fitness);
    }

    private function selection($population, $fitnessScores)
    {
        $tournamentSize = 5;
        $bestIndex = -1;
        $bestFitness = -1;

        for ($i = 0; $i < $tournamentSize; $i++) {
            $randomIndex = array_rand($population);
            if ($fitnessScores[$randomIndex] > $bestFitness) {
                $bestFitness = $fitnessScores[$randomIndex];
                $bestIndex = $randomIndex;
            }
        }

        return $population[$bestIndex];
    }

    private function crossover($parent1, $parent2)
    {
        $crossoverPoint = array_rand($parent1);
        $offspring = [];

        for ($i = 0; $i < count($parent1); $i++) {
            if ($i < $crossoverPoint) {
                $offspring[] = $parent1[$i];
            } else {
                $offspring[] = $parent2[$i];
            }
        }

        return $offspring;
    }

    /**
     * Mutasi dengan memperhatikan hard constraint
     */
    private function mutate($chromosome)
    {
        // Pilih hari secara acak
        $dayIndex = array_rand($chromosome);
        $daySchedule = $chromosome[$dayIndex];
        $hari = $daySchedule['hari'];

        // Pilih jam secara acak
        if (!empty($daySchedule['jam_ke'])) {
            $jamIndex = array_rand($daySchedule['jam_ke']);

            // Pastikan ada mata pelajaran di jam ini
            if (!empty($daySchedule['jam_ke'][$jamIndex]['mata_pelajaran'])) {
                // Buat tracking guru yang sudah mengajar di jam ini
                $teachersInSlot = [];
                foreach ($chromosome as $ds) {
                    if ($ds['hari'] == $hari && isset($ds['jam_ke'][$jamIndex]['guru'])) {
                        $teachersInSlot[$ds['jam_ke'][$jamIndex]['guru']] = true;
                    }
                }

                // Cari guru yang belum mengajar di jam ini
                $availableTeachers = [];
                foreach (array_keys($this->teachers) as $teacherId) {
                    if (!isset($teachersInSlot[$teacherId])) {
                        $availableTeachers[] = $teacherId;
                    }
                }

                // Pilih guru baru dari yang tersedia
                if (!empty($availableTeachers)) {
                    $newTeacherId = $availableTeachers[array_rand($availableTeachers)];
                    $chromosome[$dayIndex]['jam_ke'][$jamIndex]['guru'] = $newTeacherId;
                }
            }
        }

        return $chromosome;
    }

    private function decodeChromosome($chromosome)
    {
        $schedule = [];
        foreach ($chromosome as $daySchedule) {
            $scheduleEntry = [
                'hari' => $daySchedule['hari'],
                'kelas' => $daySchedule['kelas'],
                'ruang' => $daySchedule['ruang'],
                'wali_kelas' => $daySchedule['wali_kelas'],
                'prodi' => $daySchedule['prodi'],
                'jam_ke' => [],
            ];

            foreach ($daySchedule['jam_ke'] as $jam => $jamSchedule) {
                $scheduleEntry['jam_ke'][$jam] = $jamSchedule;
            }

            $schedule[] = $scheduleEntry;
        }

        return $schedule;
    }

    public function saveScheduleToDatabase($schedule, $berlakuJadwalDari)
    {
        error_log("SchedulerService: saveScheduleToDatabase() dimulai.");

        if (empty($schedule)) {
            error_log("SchedulerService: ERROR - Jadwal yang akan disimpan kosong.");
            return false;
        }

        // Hapus jadwal lama untuk tanggal berlaku yang sama
        $this->db->query("DELETE FROM jadwal_lengkap WHERE berlaku_jadwal_dari = :berlaku_jadwal_dari");
        $this->db->bind(':berlaku_jadwal_dari', $berlakuJadwalDari);
        $this->db->execute();
        error_log("SchedulerService: Jadwal lama untuk tanggal " . $berlakuJadwalDari . " telah dihapus.");

        $insertCount = 0;
        foreach ($schedule as $daySchedule) {
            $kode_kelas = $daySchedule['kelas'] . $daySchedule['ruang'];

            $data = [
                'hari' => $daySchedule['hari'],
                'kode_kelas' => $kode_kelas,
                'kelas' => substr($daySchedule['kelas'], 0, 3),
                'ruang' => $daySchedule['ruang'],
                'wali_kelas' => $daySchedule['wali_kelas'],
                'prodi' => $daySchedule['prodi'],
                'validasi' => 1,
                'validasi_oleh' => 1700024,
                'tanggal_validasi' => '2025-10-14',
                'berlaku_jadwal_dari' => $berlakuJadwalDari,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Isi mp1-mp11 dan guru1-guru11
            foreach ($daySchedule['jam_ke'] as $jam => $jamSchedule) {
                $mpField = 'mp' . $jam;
                $guruField = 'guru' . $jam;

                if (is_array($jamSchedule)) {
                    $data[$mpField] = $jamSchedule['mata_pelajaran'] ?? null;
                    $data[$guruField] = $jamSchedule['guru'] ?? null;
                } else {
                    $data[$mpField] = null;
                    $data[$guruField] = null;
                }
            }

            // Build query
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));
            $query = "INSERT INTO jadwal_lengkap ($columns) VALUES ($placeholders)";

            $this->db->query($query);

            $i = 1;
            foreach ($data as $value) {
                $this->db->bind($i, $value);
                $i++;
            }

            $result = $this->db->execute();
            if ($result) {
                $insertCount++;
            } else {
                error_log("SchedulerService: ERROR - Gagal mengeksekusi query untuk kelas " . $daySchedule['kelas'] . " hari " . $daySchedule['hari']);
            }
        }

        error_log("SchedulerService: Selesai menyimpan. " . $insertCount . " baris berhasil ditambahkan.");

        // Verifikasi
        $this->db->query("SELECT COUNT(*) as count FROM jadwal_lengkap WHERE berlaku_jadwal_dari = :berlaku_jadwal_dari");
        $this->db->bind(':berlaku_jadwal_dari', $berlakuJadwalDari);
        $result = $this->db->single();
        error_log("SchedulerService: Verifikasi - Total jadwal di database untuk tanggal " . $berlakuJadwalDari . ": " . $result->count);

        return $insertCount > 0;
    }
}