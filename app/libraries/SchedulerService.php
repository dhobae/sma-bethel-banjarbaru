<?php
class SchedulerService
{
    private $db;
    private $populationSize = 50;
    private $maxGenerations = 100;
    private $mutationRate = 0.15;
    private $crossoverRate = 0.8;
    private $eliteSize = 5;

    // Data dari database
    private $teachers = [];
    private $subjects = [];
    private $classes = [];
    private $waliKelas = [];
    
    // CSP Domain
    private $timeSlots = [];
    private $teacherLoad = []; // Tracking beban mengajar guru

    public function __construct($db)
    {
        $this->db = $db;
        $this->loadDataFromDatabase();
        $this->initializeTimeSlots();
    }

    private function loadDataFromDatabase()
    {
        error_log("SchedulerService: Memuat data dari database...");

        // Load data guru
        $this->db->query("SELECT * FROM pegawai WHERE mengajar = 'Ya' AND hapus_pegawai = 0 AND jabatan = 'Guru'");
        $teachers = $this->db->resultSet();
        foreach ($teachers as $teacher) {
            $this->teachers[$teacher->nik] = $teacher;
            $this->teacherLoad[$teacher->nik] = 0; // Inisialisasi beban mengajar
        }
        error_log("SchedulerService: " . count($this->teachers) . " guru dimuat.");

        // Load data mata pelajaran
        $this->db->query("SELECT * FROM m_pelajaran");
        $subjects = $this->db->resultSet();
        foreach ($subjects as $subject) {
            $this->subjects[$subject->id_pelajaran] = $subject;
        }
        error_log("SchedulerService: " . count($this->subjects) . " mata pelajaran dimuat.");

        // Load data kelas dari tabel jadwal
        $this->db->query("SELECT DISTINCT kelas, ruang FROM jadwal WHERE kelas IS NOT NULL ORDER BY kelas");
        $classes = $this->db->resultSet();
        foreach ($classes as $class) {
            $this->classes[] = $class;
        }
        error_log("SchedulerService: " . count($this->classes) . " kelas dimuat dari tabel jadwal.");

        // Load data wali kelas
        // $this->db->query("SELECT DISTINCT kelas, wali_kelas FROM jadwal_lengkap WHERE kelas IS NOT NULL AND wali_kelas IS NOT NULL");
        // $waliKelasData = $this->db->resultSet();
        // foreach ($waliKelasData as $wk) {
        //     $this->waliKelas[$wk->kelas] = $wk->wali_kelas;
        // }
        // error_log("SchedulerService: " . count($this->waliKelas) . " data wali kelas dimuat.");

         // Load data wali kelas - assign secara acak dari guru yang tersedia
         $this->db->query("SELECT nik FROM pegawai WHERE jabatan = 'Guru' AND mengajar = 'Ya' AND hapus_pegawai = 0");
         $guruList = $this->db->resultSet();
         
        if (!empty($guruList)) {
            $guruNikList = array_map(function($guru) {
                return $guru->nik;
            }, $guruList);
             
            // Shuffle untuk randomisasi
            shuffle($guruNikList);
             
            // Assign wali kelas untuk setiap kelas secara acak
            $guruIndex = 0;
            foreach ($this->classes as $class) {
                $this->waliKelas[$class->kelas] = $guruNikList[$guruIndex % count($guruNikList)];
                $guruIndex++;
            }
             
            error_log("SchedulerService: " . count($this->waliKelas) . " wali kelas di-assign secara acak dari " . count($guruNikList) . " guru.");
        } else {
            error_log("SchedulerService: WARNING - Tidak ada guru dengan jabatan 'Guru' yang tersedia untuk wali kelas.");
        }
    }

    private function initializeTimeSlots()
    {
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        
        foreach ($hariList as $hari) {
            // Semua hari termasuk Jumat memiliki 10 jam pelajaran (1-10)
            for ($jam = 1; $jam <= 10; $jam++) {
                $this->timeSlots[] = [
                    'hari' => $hari,
                    'jam' => $jam
                ];
            }
        }
        
        error_log("SchedulerService: " . count($this->timeSlots) . " slot waktu tersedia.");
    }

    public function generateSchedule()
    {
        error_log("SchedulerService: generateSchedule() dimulai dengan CSP + GA Hybrid.");

        if (empty($this->teachers) || empty($this->subjects) || empty($this->classes)) {
            error_log("SchedulerService: ERROR - Data guru, mata pelajaran, atau kelas kosong.");
            return [];
        }

        // Fase 1: CSP - Generate jadwal yang memenuhi hard constraint
        error_log("SchedulerService: Fase 1 - Menerapkan CSP untuk hard constraint...");
        $baseSchedule = $this->generateCSPSchedule();
        
        if (empty($baseSchedule)) {
            error_log("SchedulerService: ERROR - CSP gagal menghasilkan jadwal valid.");
            return [];
        }

        // Fase 2: GA - Optimasi untuk soft constraint (keseimbangan beban guru)
        error_log("SchedulerService: Fase 2 - Optimasi dengan GA untuk soft constraint...");
        $population = $this->initializePopulationFromCSP($baseSchedule);
        
        // Evolusi untuk mencari distribusi beban guru yang optimal
        for ($generation = 0; $generation < $this->maxGenerations; $generation++) {
            $fitnessScores = [];
            foreach ($population as $index => $chromosome) {
                $fitness = $this->calculateFitness($chromosome);
                $fitnessScores[] = $fitness;
            }

            array_multisort($fitnessScores, SORT_DESC, $population);

            if ($generation % 10 == 0) {
                $loadBalance = $this->calculateLoadBalance($population[0]);
                error_log("SchedulerService: Gen " . $generation . " - Fitness: " . 
                         number_format($fitnessScores[0], 4) . " - Load Balance: " . 
                         number_format($loadBalance, 4));
            }

            // Jika sudah optimal (fitness > 0.95 dan load balance baik)
            if ($fitnessScores[0] >= 0.95) {
                error_log("SchedulerService: Solusi optimal ditemukan di generasi " . $generation);
                break;
            }

            // Buat generasi baru
            $newPopulation = [];
            
            // Elitisme
            for ($i = 0; $i < $this->eliteSize; $i++) {
                $newPopulation[] = $population[$i];
            }

            // Reproduksi
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

        $bestSchedule = $population[0];
        error_log("SchedulerService: Evolusi selesai. Mendekode kromosom terbaik...");
        
        return $this->decodeChromosome($bestSchedule);
    }

    /**
     * CSP: Generate jadwal yang memenuhi HARD CONSTRAINT
     * - Guru tidak boleh mengajar di 2 tempat pada waktu yang sama
     * - Kelas tidak boleh ada 2 pelajaran pada waktu yang sama
     */
    private function generateCSPSchedule()
    {
        $schedule = [];
        $teacherAssignments = []; // hari => jam => [teacherId => true]
        $classAssignments = [];   // hari => jam => [kelas => true]

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        foreach ($this->classes as $class) {
            foreach ($hariList as $hari) {
                $scheduleEntry = [
                    'hari' => $hari,
                    'kelas' => $class->kelas,
                    'ruang' => $class->ruang,
                    'wali_kelas' => $this->waliKelas[$class->kelas] ?? '',
                    'prodi' => 'SMABETHEL',
                    'jam_ke' => [],
                ];

                // Semua hari memiliki 10 jam pelajaran
                for ($jam = 1; $jam <= 10; $jam++) {
                    // Pilih mata pelajaran acak
                    $subjectId = array_rand($this->subjects);
                    
                    // CSP: Cari guru yang TERSEDIA di slot ini
                    $teacherId = $this->getAvailableTeacher($hari, $jam, $teacherAssignments);

                    if ($teacherId) {
                        // Assign guru ke slot ini
                        if (!isset($teacherAssignments[$hari][$jam])) {
                            $teacherAssignments[$hari][$jam] = [];
                        }
                        $teacherAssignments[$hari][$jam][$teacherId] = true;

                        // Mark kelas sudah terisi
                        if (!isset($classAssignments[$hari][$jam])) {
                            $classAssignments[$hari][$jam] = [];
                        }
                        $classAssignments[$hari][$jam][$class->kelas] = true;

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
                        error_log("CSP WARNING: Tidak ada guru tersedia untuk $hari jam ke-$jam");
                    }
                }

                $schedule[] = $scheduleEntry;
            }
        }

        return $schedule;
    }

    /**
     * CSP Helper: Dapatkan guru yang tersedia (belum mengajar di slot ini)
     */
    private function getAvailableTeacher($hari, $jam, &$teacherAssignments)
    {
        if (empty($this->teachers)) {
            return null;
        }

        $availableTeachers = [];
        foreach (array_keys($this->teachers) as $teacherId) {
            // Cek apakah guru sudah mengajar di slot ini
            if (!isset($teacherAssignments[$hari][$jam][$teacherId])) {
                $availableTeachers[] = $teacherId;
            }
        }

        if (!empty($availableTeachers)) {
            return $availableTeachers[array_rand($availableTeachers)];
        }

        return null;
    }

    /**
     * Inisialisasi populasi dari hasil CSP dengan variasi untuk GA
     */
    private function initializePopulationFromCSP($baseSchedule)
    {
        $population = [];
        
        // Individu pertama adalah hasil CSP original
        $population[] = $baseSchedule;

        // Buat variasi dari base schedule
        for ($i = 1; $i < $this->populationSize; $i++) {
            $variant = $this->createVariant($baseSchedule);
            $population[] = $variant;
        }

        return $population;
    }

    /**
     * Buat varian jadwal dengan mempertahankan hard constraint
     */
    private function createVariant($schedule)
    {
        $variant = json_decode(json_encode($schedule), true); // Deep copy
        
        // Lakukan beberapa swap guru antar slot yang berbeda
        $swapCount = rand(5, 15);
        
        for ($i = 0; $i < $swapCount; $i++) {
            // Pilih 2 entry jadwal secara acak
            $idx1 = array_rand($variant);
            $idx2 = array_rand($variant);
            
            if ($idx1 == $idx2) continue;
            
            $entry1 = &$variant[$idx1];
            $entry2 = &$variant[$idx2];
            
            // Pilih jam secara acak
            if (!empty($entry1['jam_ke']) && !empty($entry2['jam_ke'])) {
                $jamList1 = array_keys($entry1['jam_ke']);
                $jamList2 = array_keys($entry2['jam_ke']);
                
                if (!empty($jamList1) && !empty($jamList2)) {
                    $jam1 = $jamList1[array_rand($jamList1)];
                    $jam2 = $jamList2[array_rand($jamList2)];
                    
                    // Pastikan tidak di hari dan jam yang sama (hard constraint)
                    if ($entry1['hari'] != $entry2['hari'] || $jam1 != $jam2) {
                        // Swap guru
                        if (isset($entry1['jam_ke'][$jam1]['guru']) && 
                            isset($entry2['jam_ke'][$jam2]['guru'])) {
                            $temp = $entry1['jam_ke'][$jam1]['guru'];
                            $entry1['jam_ke'][$jam1]['guru'] = $entry2['jam_ke'][$jam2]['guru'];
                            $entry2['jam_ke'][$jam2]['guru'] = $temp;
                        }
                    }
                }
            }
        }
        
        return $variant;
    }

    /**
     * Calculate fitness berdasarkan:
     * 1. Hard constraint (CSP sudah handle, tapi tetap cek)
     * 2. Soft constraint: Keseimbangan beban mengajar guru
     */
    private function calculateFitness($chromosome)
    {
        $totalSlots = 0;
        $hardConflicts = 0;
        
        // Reset teacher load
        $teacherLoad = [];
        foreach (array_keys($this->teachers) as $teacherId) {
            $teacherLoad[$teacherId] = 0;
        }

        // Check hard constraints
        $teacherSchedule = [];
        $classSchedule = [];

        foreach ($chromosome as $daySchedule) {
            $hari = $daySchedule['hari'];
            $kelas = $daySchedule['kelas'];
            
            foreach ($daySchedule['jam_ke'] as $jam => $jamSchedule) {
                if (empty($jamSchedule['guru']) || empty($jamSchedule['mata_pelajaran'])) {
                    continue;
                }

                $totalSlots++;
                $teacherId = $jamSchedule['guru'];

                // Count teacher load
                if (isset($teacherLoad[$teacherId])) {
                    $teacherLoad[$teacherId]++;
                }

                // Hard constraint 1: Teacher conflict
                if (isset($teacherSchedule[$hari][$jam][$teacherId])) {
                    $hardConflicts++;
                } else {
                    $teacherSchedule[$hari][$jam][$teacherId] = true;
                }

                // Hard constraint 2: Class conflict
                if (isset($classSchedule[$hari][$jam][$kelas])) {
                    $hardConflicts++;
                } else {
                    $classSchedule[$hari][$jam][$kelas] = true;
                }
            }
        }

        if ($totalSlots == 0) {
            return 0;
        }

        // Penalti hard constraint
        $hardPenalty = ($hardConflicts * 3.0) / $totalSlots;

        // Soft constraint: Load balance (standar deviasi beban guru)
        $loadBalanceScore = $this->calculateLoadBalance($chromosome);

        // Fitness = (1 - hard_penalty) * load_balance_score
        $fitness = (1.0 - $hardPenalty) * $loadBalanceScore;

        return max(0, $fitness);
    }

    /**
     * Hitung keseimbangan beban mengajar (semakin seimbang semakin baik)
     */
    private function calculateLoadBalance($chromosome)
    {
        // Hitung beban setiap guru
        $teacherLoad = [];
        foreach (array_keys($this->teachers) as $teacherId) {
            $teacherLoad[$teacherId] = 0;
        }

        foreach ($chromosome as $daySchedule) {
            foreach ($daySchedule['jam_ke'] as $jam => $jamSchedule) {
                if (!empty($jamSchedule['guru'])) {
                    $teacherId = $jamSchedule['guru'];
                    if (isset($teacherLoad[$teacherId])) {
                        $teacherLoad[$teacherId]++;
                    }
                }
            }
        }

        // Hitung mean dan standar deviasi
        $loads = array_values($teacherLoad);
        $mean = array_sum($loads) / count($loads);
        
        $variance = 0;
        foreach ($loads as $load) {
            $variance += pow($load - $mean, 2);
        }
        $variance /= count($loads);
        $stdDev = sqrt($variance);

        // Normalisasi: semakin kecil stdDev, semakin baik (score tinggi)
        // Gunakan fungsi sigmoid untuk normalisasi ke [0,1]
        $balanceScore = 1.0 / (1.0 + $stdDev);

        return $balanceScore;
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
        $crossoverPoint = rand(1, count($parent1) - 1);
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
     * Mutasi: Tukar guru antar slot dengan mempertahankan hard constraint
     */
    private function mutate($chromosome)
    {
        // Pilih 2 entry secara acak
        $idx1 = array_rand($chromosome);
        $idx2 = array_rand($chromosome);

        if ($idx1 == $idx2) {
            return $chromosome;
        }

        $entry1 = &$chromosome[$idx1];
        $entry2 = &$chromosome[$idx2];

        // Pilih jam secara acak
        if (!empty($entry1['jam_ke']) && !empty($entry2['jam_ke'])) {
            $jamList1 = array_keys($entry1['jam_ke']);
            $jamList2 = array_keys($entry2['jam_ke']);

            if (!empty($jamList1) && !empty($jamList2)) {
                $jam1 = $jamList1[array_rand($jamList1)];
                $jam2 = $jamList2[array_rand($jamList2)];

                // Pastikan tidak melanggar hard constraint (hari-jam berbeda)
                if ($entry1['hari'] != $entry2['hari'] || $jam1 != $jam2) {
                    if (isset($entry1['jam_ke'][$jam1]['guru']) && 
                        isset($entry2['jam_ke'][$jam2]['guru'])) {
                        
                        // Swap guru
                        $temp = $entry1['jam_ke'][$jam1]['guru'];
                        $entry1['jam_ke'][$jam1]['guru'] = $entry2['jam_ke'][$jam2]['guru'];
                        $entry2['jam_ke'][$jam2]['guru'] = $temp;
                    }
                }
            }
        }

        return $chromosome;
    }

    private function decodeChromosome($chromosome)
    {
        return $chromosome; // Sudah dalam format yang benar
    }

    public function saveScheduleToDatabase($schedule, $berlakuJadwalDari)
    {
        error_log("SchedulerService: saveScheduleToDatabase() dimulai.");

        if (empty($schedule)) {
            error_log("SchedulerService: ERROR - Jadwal kosong.");
            return false;
        }

        // // Hapus jadwal lama
        // $this->db->query("DELETE FROM jadwal_lengkap WHERE berlaku_jadwal_dari = :berlaku_jadwal_dari");
        // $this->db->bind(':berlaku_jadwal_dari', $berlakuJadwalDari);
        // $this->db->execute();

        $waliKelasTersedia = []; // untuk menampung wali_kelas unik
        $insertCount = 0;
        foreach ($schedule as $daySchedule) {
            $kode_kelas = $daySchedule['kelas'] . $daySchedule['ruang'];
            
            // error_log("daftar wali kelas id :" . $daySchedule['wali_kelas']);

            $waliKelasId = $daySchedule['wali_kelas'];

            // Simpan hanya jika belum ada dalam array
            if (!in_array($waliKelasId, $waliKelasTersedia)) {
                $waliKelasTersedia[] = $waliKelasId;
               
                error_log("daftar wali kelas id :" . $waliKelasId);
            }

            $data = [
                'hari' => $daySchedule['hari'],
                'kode_kelas' => $kode_kelas,
                'kelas' => substr($daySchedule['kelas'], 0, 3),
                'ruang' => $daySchedule['ruang'],
                'wali_kelas' => $daySchedule['wali_kelas'],
                'prodi' => 'SMABETHEL',
                'validasi' => 1,
                'validasi_oleh' => 1700024,
                'tanggal_validasi' => date('Y-m-d'),
                'berlaku_jadwal_dari' => $berlakuJadwalDari,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Isi mp1-mp10 dan guru1-guru10 (sekarang 10 jam untuk semua hari)
            for ($jam = 1; $jam <= 10; $jam++) {
                $mpField = 'mp' . $jam;
                $guruField = 'guru' . $jam;

                if (isset($daySchedule['jam_ke'][$jam]) && is_array($daySchedule['jam_ke'][$jam])) {
                    $data[$mpField] = $daySchedule['jam_ke'][$jam]['mata_pelajaran'] ?? null;
                    $data[$guruField] = $daySchedule['jam_ke'][$jam]['guru'] ?? null;
                } else {
                    $data[$mpField] = null;
                    $data[$guruField] = null;
                }
            }

            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));
            $query = "INSERT INTO jadwal_lengkap ($columns) VALUES ($placeholders)";

            $this->db->query($query);

            $i = 1;
            foreach ($data as $value) {
                $this->db->bind($i, $value);
                $i++;
            }

            if ($this->db->execute()) {
                $insertCount++;
            }
        }

        error_log("Wali kelas tersedia: " . implode(", ", $waliKelasTersedia));

        // Setelah semua data jadwal disimpan dan wali_kelas terkumpul unik
        if (!empty($waliKelasTersedia)) {
            // Ubah array menjadi string dipisahkan koma
            $nipPegawaiString = implode(",", $waliKelasTersedia);

            // Query update tabel admin id = 3 (wali_kelas)
            $updateQuery = "UPDATE admin SET nip_pegawai = :nip_pegawai WHERE id = 3 AND hak_akses = 'wali_kelas'";
            $this->db->query($updateQuery);
            $this->db->bind(':nip_pegawai', $nipPegawaiString);

            if ($this->db->execute()) {
                error_log("UPDATE admin berhasil: $nipPegawaiString");
            } else {
                error_log("Gagal update admin wali_kelas");
            }
        }

        error_log("SchedulerService: " . $insertCount . " baris berhasil disimpan.");

        return $insertCount > 0;
    }
}