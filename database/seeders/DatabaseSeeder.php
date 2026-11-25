<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Officer;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Shelter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Admin User (Hanya akun resmi ini)
        $admin = User::firstOrCreate(
            ['email' => 'admin@shelter.com'],
            [
                'name' => 'Administrator Taman Safari',
                'phone' => '0812-3456-7890',
                'role' => 'super_admin',
                'avatar' => 'https://lh3.googleusercontent.com/aida/ALJJyrB_4SeJN0hBVsUaQZSaPUtqD_UZdZaDySOnP-ks0pSur7WKVQ4HpFveXs56hl57Pk3cXbkml94LwFis0JLihaqdQp0M13iiTU6ObS9Eqd4CyxaVt6iG4jwZtoXOraiCuR_nzIbkGA8BWaA65PoesTJVxG_9WnJ3XegKsZr9ESUDLom-pjL9CKFkO7hrZXXmJWYikNTorGIHOSc4MT-HHSm_11plupnLgnh5BBPi7Vim',
                'password' => Hash::make('TamanSafari2026'),
            ]
        );
        $admin->password = Hash::make('TamanSafari2026');
        $admin->save();

        // Hapus akun selain admin@shelter.com jika ada
        User::where('id', '!=', $admin->id)->delete();

        // 2. Settings
        $settings = [
            'site_name' => 'Shelter Management System',
            'site_tagline' => 'PENJAGAAN SATWA & BENCANA TERPADU',
            'hotline_toll_free' => '1500 - 8989',
            'hotline_office' => '+62 21 555-8910',
            'emergency_radio' => '144.520 MHz (Kanal Darurat)',
            'coordination_email' => 'posko@shelter-system.go.id',
            'coordination_unit' => 'Satgas Penjagaan Wilayah',
            'command_center_address' => 'Gedung Pusat Operasi Wilayah, Jl. Konservasi No. 45 Jakarta',
            'operational_status' => 'Level 1 Siaga Operasional',
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 3. Shelters (10 Posko Konservasi & Shelter Resmi Taman Safari Indonesia)
        $sheltersData = [
            [
                'code' => 'SH-01',
                'name' => 'Baby Zoo',
                'zone' => 'Zona Barat',
                'address' => 'Area Konservasi Bayi Satwa & Nursery Tropis',
                'coordinator_name' => 'drh. Fitri Handayani',
                'coordinator_phone' => '0811-2233-4401',
                'capacity' => 180,
                'current_occupancy' => 140,
                'guard_quota' => 6,
                'risk_level' => 'sedang',
                'status' => 'siaga_penuh',
                'image_url' => '/images/shelters/baby-zoo.jpg',
                'description' => 'kandang bayi hewan seperti singa, harimau, orangutan, termasuk singa putih dan harimau putih',
            ],
            [
                'code' => 'SH-02',
                'name' => 'Australia Outback',
                'zone' => 'Zona Selatan',
                'address' => 'Sektor Padang Savana Australasia Blok S-1',
                'coordinator_name' => 'Letnan Budi Santoso',
                'coordinator_phone' => '0811-2233-4402',
                'capacity' => 250,
                'current_occupancy' => 210,
                'guard_quota' => 6,
                'risk_level' => 'sedang',
                'status' => 'siaga_penuh',
                'image_url' => '/images/shelters/australia-outback.jpg',
                'description' => 'kandang kanguru, lemur ekor cincin, serta berbagai jenis macan seperti jaguar dan puma',
            ],
            [
                'code' => 'SH-03',
                'name' => 'Bird of Prey',
                'zone' => 'Zona Utara',
                'address' => 'Puncak Bukit Konservasi Sayap Langit Blok U-2',
                'coordinator_name' => 'Serma Hendra Gunawan',
                'coordinator_phone' => '0811-2233-4403',
                'capacity' => 180,
                'current_occupancy' => 135,
                'guard_quota' => 5,
                'risk_level' => 'sedang',
                'status' => 'rutin',
                'image_url' => '/images/shelters/bird-of-prey.jpg',
                'description' => 'kandang burung pemangsa seperti elang jawa',
            ],
            [
                'code' => 'SH-04',
                'name' => 'Taman Buaya',
                'zone' => 'Zona Timur',
                'address' => 'Kawasan Danau & Laguna Sektor Rawa Timur',
                'coordinator_name' => 'Serma Dedi Pratama',
                'coordinator_phone' => '0811-2233-4404',
                'capacity' => 220,
                'current_occupancy' => 195,
                'guard_quota' => 6,
                'risk_level' => 'tinggi',
                'status' => 'siaga_penuh',
                'image_url' => '/images/shelters/taman-buaya.jpg',
                'description' => 'berbagai jenis buaya dan binturong',
            ],
            [
                'code' => 'SH-05',
                'name' => 'Komodo Dragon Island',
                'zone' => 'Zona Timur',
                'address' => 'Pulau Pasir Hangat & Parit Perlindungan Sektor Timur',
                'coordinator_name' => 'Kapten Marinir Syafruddin',
                'coordinator_phone' => '0811-2233-4405',
                'capacity' => 210,
                'current_occupancy' => 180,
                'guard_quota' => 6,
                'risk_level' => 'tinggi',
                'status' => 'siaga_penuh',
                'image_url' => '/images/shelters/komodo-dragon.jpg',
                'description' => 'kandang komodo dengan lingkungan yang disesuaikan habitat aslinya',
            ],
            [
                'code' => 'SH-06',
                'name' => 'Kampung Papua',
                'zone' => 'Zona Selatan',
                'address' => 'Zona Lembah Melanesia & Hutan Asli Blok P-4',
                'coordinator_name' => 'Aiptu Suwandi',
                'coordinator_phone' => '0811-2233-4406',
                'capacity' => 200,
                'current_occupancy' => 165,
                'guard_quota' => 6,
                'risk_level' => 'sedang',
                'status' => 'rutin',
                'image_url' => '/images/shelters/kampung-papua.jpg',
                'description' => 'kandang hewan Papua seperti kasuari, kura-kura, dan kanguru pohon',
            ],
            [
                'code' => 'SH-07',
                'name' => 'Bahtera Penguin',
                'zone' => 'Zona Utara',
                'address' => 'Gedung Konservasi Akuatik Kutub & Subtropis',
                'coordinator_name' => 'Lettu Darmawan Syah',
                'coordinator_phone' => '0811-2233-4407',
                'capacity' => 160,
                'current_occupancy' => 130,
                'guard_quota' => 5,
                'risk_level' => 'rendah',
                'status' => 'rutin',
                'image_url' => '/images/shelters/bahtera-penguin.jpg',
                'description' => 'kandang penguin, awalnya digunakan untuk beruang kutub',
            ],
            [
                'code' => 'SH-08',
                'name' => 'Primate Center',
                'zone' => 'Zona Barat',
                'address' => 'Kanopi Hutan Hujan & Kepulauan Primata Tropis',
                'coordinator_name' => 'Kapten Aris Wibowo',
                'coordinator_phone' => '0811-2233-4408',
                'capacity' => 320,
                'current_occupancy' => 280,
                'guard_quota' => 7,
                'risk_level' => 'sedang',
                'status' => 'siaga_penuh',
                'image_url' => '/images/shelters/primate-center.jpg',
                'description' => 'kandang primata langka seperti orangutan, simpanse, owa, dan lutung',
            ],
            [
                'code' => 'SH-09',
                'name' => 'Lorong Reptil & Satwa Malam',
                'zone' => 'Zona Timur',
                'address' => 'Kawasan Gua Nokturnal & Terarium Terpadu Sayap Timur',
                'coordinator_name' => 'Serka Irwan Mansyur',
                'coordinator_phone' => '0811-2233-4409',
                'capacity' => 190,
                'current_occupancy' => 150,
                'guard_quota' => 5,
                'risk_level' => 'tinggi',
                'status' => 'siaga_penuh',
                'image_url' => '/images/shelters/lorong-reptil.jpg',
                'description' => 'kandang reptil, ikan arapaima, musang, kelelawar, burung hantu, dan satwa nokturnal lainnya',
            ],
            [
                'code' => 'SH-10',
                'name' => 'Istana Panda',
                'zone' => 'Zona Utara',
                'address' => 'Kawasan Dataran Tinggi Khusus Puncak 1.800 mdpl',
                'coordinator_name' => 'Prof. drh. Maya Indrawati',
                'coordinator_phone' => '0811-2233-4410',
                'capacity' => 300,
                'current_occupancy' => 260,
                'guard_quota' => 6,
                'risk_level' => 'sedang',
                'status' => 'siaga_penuh',
                'image_url' => '/images/shelters/istana-panda.jpg',
                'description' => 'kandang panda Cai Tao dan Hu Chun di area khusus di ketinggian 1.800 mdpl',
            ],
        ];

        $shelterModels = [];
        foreach ($sheltersData as $s) {
            $shelterModels[$s['code']] = Shelter::create($s);
        }

        // 4. Officers (Seeding realistic officers with portrait images)
        $officersData = [
            [
                'nrp' => '84091211',
                'name' => 'Bripka Joko Prasetyo',
                'phone' => '0812-8899-0011',
                'email' => 'joko.prasetyo@shelter.id',
                'address' => 'Jl. Melati No. 14, Jakarta',
                'position' => 'Komandan Regu',
                'shelter_id' => $shelterModels['SH-05']->id,
                'status' => 'Aktif',
                'avatar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBlIKAWRveO33FTok8ACcX1J3QDsoIK94TrLx8tGU8AuRsAtGUg4QUMKHLL941XHRzvYz5OuaXVXlvyESlpOB4BiGqitdyv7O1bOA2kOVscOQ8jc32mMcntgRGYYkkdZe5zDqvZvJwMiOJbqogjmUKkF8h9c-9IwV2TBZvAbYYmI5sHJCsnoBuVpkmmU0yBpjm4TeOOVBqIBfUVKJj-ByxxhPxhiYDB2XNl1gEFHB-i',
            ],
            [
                'nrp' => '87044122',
                'name' => 'Serma Hendra Gunawan',
                'phone' => '0812-8899-0012',
                'email' => 'hendra.gunawan@shelter.id',
                'address' => 'Jl. Kenanga Blok C No. 5, Bogor',
                'position' => 'Komandan Regu',
                'shelter_id' => $shelterModels['SH-01']->id,
                'status' => 'Aktif',
                'avatar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDgAfexsg-MguOcnOXV9g2SmICT2r135oU3X8zBqaf9tr5leCcg55yTslye3JGtvR8tkNZknNQ93b9MWdktPw1xPdpsC_LUmtJbG-lrOd6rl6KKlrFaVRyYrtM7DwyzYy-6sQ11tCMIZ_XW9kHgzFfC2elndloas323EefGyN2r6by1gr74q3N_YViRPtJ6uu320cwLaK1ejGMtRc6Bj2VTrBSlCMlFOkQ01TfzaOAQ',
            ],
            [
                'nrp' => '92051233',
                'name' => 'drh. Ratna Lestari',
                'phone' => '0812-8899-0013',
                'email' => 'ratna.lestari@shelter.id',
                'address' => 'Perum Dosen Konservasi No. 8, Depok',
                'position' => 'Medis Satwa',
                'shelter_id' => $shelterModels['SH-02']->id,
                'status' => 'Aktif',
                'avatar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBtgxTJ3tub3X3ytFlE_uDjrtpP2plsIqbpSDg58c3s09PeH8YYuvpVwXg1mbtGm5K_8Fsn7LKB5lWEu7bxY5lcrNRr6xeiUVuWU2KRqI7wb4pVjLQ7rgD2kaEO3xLHmWSpUgHL860xjPveZHeXZO6HCA5FBKy9uGmwhsDVSDj7e7g7EIggIh-Gwdj_gjFwtfcfQccJy2q4cWWZaewhl7pKFnzA-BaI3IN6ZQYQt2vQ',
            ],
            [
                'nrp' => '91028744',
                'name' => 'Koptu Dedi Sulaeman',
                'phone' => '0812-8899-0014',
                'email' => 'dedi.sulaeman@shelter.id',
                'address' => 'Asrama Satgas Blok B-3, Jakarta Timur',
                'position' => 'Security Pos',
                'shelter_id' => $shelterModels['SH-03']->id,
                'status' => 'Aktif',
                'avatar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBRc6GiGc-3DqtO8OXUy-0HhAsGzn2JJ_o6bGcFIV5Snp-SwlPH4749eJEXRvIDT8_8sU3b_bNpfAiXs2W-jBY-hLUz-DDuqkgMy5-1vQqZNbJewC93dOoYwNyLAiuKuX_gWEaSuntR9hLEsMpr3TSv1W3RzRuWLEhaZY0rPGdiepalZg0fqD7DtdCwdlzE7UUV4lr34NqksLDHm_ZrDuDBvNSpGqOsMH-xxIy00rNB',
            ],
            [
                'nrp' => '93081955',
                'name' => 'Agus Supriyadi, S.Hut',
                'phone' => '0812-8899-0015',
                'email' => 'agus.supriyadi@shelter.id',
                'address' => 'Jl. Flamboyan Indah No. 21, Tangerang',
                'position' => 'Ranger Sektor',
                'shelter_id' => $shelterModels['SH-06']->id,
                'status' => 'Aktif',
                'avatar_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDW3lPwuv363j2UkhQpIgU6GfALraKiNAk50S3Ep-OV9mtzolaONZiInNNXEO0sut3hkp5ZpZ4qexzo3fxpUw2GgUafGdh5rVs_ZjdrrK0VZmwF8tu6HkGdlHfj_sl6xo08XF1J2puDGFr4SnNC6RXQ_pqeacOna-fULraUYVHZWefD2Bk8JuNPf_A4WBMI4Sy1v3pYXEfYq2MbYxVhgUayUpovEGyKLJ0-nZORx1ct',
            ],
            [
                'nrp' => '82010488',
                'name' => 'Aipda M. Rizky',
                'phone' => '0812-8899-0016',
                'email' => 'm.rizky@shelter.id',
                'address' => 'Jl. Cempaka Putih No. 9, Jakarta',
                'position' => 'Komandan Regu',
                'shelter_id' => $shelterModels['SH-06']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '88062130',
                'name' => 'Brigadir Ilham Maulana',
                'phone' => '0812-8899-0017',
                'email' => 'ilham.maulana@shelter.id',
                'address' => 'Jl. Anggrek No. 18, Jakarta Selatan',
                'position' => 'Anggota Patroli',
                'shelter_id' => $shelterModels['SH-02']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '92080311',
                'name' => 'Briptu Surya Darmawan',
                'phone' => '0812-8899-0018',
                'email' => 'surya.darmawan@shelter.id',
                'address' => 'Jl. Tanjung Duren No. 3, Jakarta Barat',
                'position' => 'Anggota Patroli',
                'shelter_id' => $shelterModels['SH-02']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '79100812',
                'name' => 'Serka Bambang Irawan',
                'phone' => '0812-8899-0019',
                'email' => 'bambang.irawan@shelter.id',
                'address' => 'Kompleks Marinir Blok D-2, Cilandak',
                'position' => 'Komandan Regu',
                'shelter_id' => $shelterModels['SH-05']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '85031420',
                'name' => 'Bripka Wahyu Setiawan',
                'phone' => '0812-8899-0020',
                'email' => 'wahyu.setiawan@shelter.id',
                'address' => 'Jl. Merpati Putih No. 10, Bekasi',
                'position' => 'Anggota Patroli',
                'shelter_id' => $shelterModels['SH-04']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '94021105',
                'name' => 'drh. Annisa Safitri',
                'phone' => '0812-8899-0021',
                'email' => 'annisa.safitri@shelter.id',
                'address' => 'Perum Harmoni Hijau No. 12, Bogor',
                'position' => 'Medis Satwa',
                'shelter_id' => $shelterModels['SH-09']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '95071832',
                'name' => 'Pratu Fajar Ramadhan',
                'phone' => '0812-8899-0022',
                'email' => 'fajar.ramadhan@shelter.id',
                'address' => 'Jl. Kemuning Raya No. 4, Tangerang Selatan',
                'position' => 'Anggota Patroli',
                'shelter_id' => $shelterModels['SH-01']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '89110419',
                'name' => 'Kopda Rian Hidayatullah',
                'phone' => '0812-8899-0023',
                'email' => 'rian.hidayat@shelter.id',
                'address' => 'Jl. Dahlia No. 7, Jakarta Utara',
                'position' => 'Security Pos',
                'shelter_id' => $shelterModels['SH-07']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '93122048',
                'name' => 'Briptu Gilang Pratama',
                'phone' => '0812-8899-0024',
                'email' => 'gilang.pratama@shelter.id',
                'address' => 'Jl. Garuda No. 31, Jakarta Pusat',
                'position' => 'Anggota Patroli',
                'shelter_id' => $shelterModels['SH-08']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '86090950',
                'name' => 'Sertu Dani Firmansyah',
                'phone' => '0812-8899-0025',
                'email' => 'dani.firmansyah@shelter.id',
                'address' => 'Jl. Pisang Batu No. 15, Depok',
                'position' => 'Ranger Sektor',
                'shelter_id' => $shelterModels['SH-10']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
            [
                'nrp' => '90051677',
                'name' => 'Bripda Tommy Kurniawan',
                'phone' => '0812-8899-0026',
                'email' => 'tommy.kurniawan@shelter.id',
                'address' => 'Jl. Sukajadi No. 44, Bandung',
                'position' => 'Anggota Patroli',
                'shelter_id' => $shelterModels['SH-03']->id,
                'status' => 'Siaga',
                'avatar_url' => null,
            ],
            [
                'nrp' => '83112999',
                'name' => 'Aipda Heri Kuswanto',
                'phone' => '0812-8899-0027',
                'email' => 'heri.kuswanto@shelter.id',
                'address' => 'Jl. Pahlawan No. 2, Bekasi',
                'position' => 'Komandan Regu',
                'shelter_id' => $shelterModels['SH-09']->id,
                'status' => 'Cuti',
                'avatar_url' => null,
            ],
            [
                'nrp' => '96040810',
                'name' => 'Serda Bagas Wicaksono',
                'phone' => '0812-8899-0028',
                'email' => 'bagas.wicaksono@shelter.id',
                'address' => 'Jl. Seroja No. 99, Bogor',
                'position' => 'Ranger Sektor',
                'shelter_id' => $shelterModels['SH-10']->id,
                'status' => 'Aktif',
                'avatar_url' => null,
            ],
        ];

        $officerModels = [];
        foreach ($officersData as $off) {
            $officerModels[$off['nrp']] = Officer::create($off);
        }

        // 5. Schedules (Today, Past, Upcoming)
        $today = Carbon::today();
        $daysIndo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        // Today schedules matching the prompt's table!
        $todaySchedules = [
            [
                'shelter_id' => $shelterModels['SH-05']->id, // Shelter Pandu A
                'officer_id' => $officerModels['84091211']->id, // Bripka Joko Prasetyo
                'shift' => 'Pagi',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'status' => 'Sedang Bertugas',
                'notes' => 'Patroli perimeter kandang luar & pemberian pakan pagi.',
            ],
            [
                'shelter_id' => $shelterModels['SH-06']->id, // Shelter Pandu B
                'officer_id' => $officerModels['82010488']->id, // Aipda M. Rizky
                'shift' => 'Pagi',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'status' => 'Sedang Bertugas',
                'notes' => 'Pemeriksaan pompa sirkulasi dan tanggul penahan.',
            ],
            [
                'shelter_id' => $shelterModels['SH-01']->id, // Shelter Harimau A
                'officer_id' => $officerModels['87044122']->id, // Serma Hendra Gunawan
                'shift' => 'Pagi',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'status' => 'Sedang Bertugas',
                'notes' => 'Pemeriksaan sensor gerak perimeter air dan gerbang isolasi hidrolik.',
            ],
            [
                'shelter_id' => $shelterModels['SH-02']->id, // Shelter Panda B
                'officer_id' => $officerModels['92051233']->id, // drh. Ratna Lestari
                'shift' => 'Siang',
                'start_time' => '15:00:00',
                'end_time' => '23:00:00',
                'status' => 'Siaga Shift',
                'notes' => 'Monitoring asupan bambu segar & cek temperatur ruangan anak panda.',
            ],
            [
                'shelter_id' => $shelterModels['SH-02']->id, // Shelter Panda B
                'officer_id' => $officerModels['88062130']->id, // Brigadir Ilham Maulana
                'shift' => 'Siang',
                'start_time' => '15:00:00',
                'end_time' => '23:00:00',
                'status' => 'Siaga Shift',
                'notes' => 'Pengamanan anjungan kaca kunjungan tamu VVIP.',
            ],
            [
                'shelter_id' => $shelterModels['SH-02']->id, // Shelter Panda B
                'officer_id' => $officerModels['92080311']->id, // Briptu Surya Darmawan
                'shift' => 'Siang',
                'start_time' => '15:00:00',
                'end_time' => '23:00:00',
                'status' => 'Siaga Shift',
                'notes' => 'Pemeriksaan suplai pakan cadangan dan logistik medis.',
            ],
            [
                'shelter_id' => $shelterModels['SH-03']->id, // Shelter Aviary A
                'officer_id' => $officerModels['91028744']->id, // Koptu Dedi Sulaeman
                'shift' => 'Malam',
                'start_time' => '23:00:00',
                'end_time' => '07:00:00',
                'status' => 'Terjadwal',
                'notes' => 'Pencegahan predator nokturnal & inspeksi jaring perimeter aviary.',
            ],
            [
                'shelter_id' => $shelterModels['SH-05']->id, // Shelter Pandu A
                'officer_id' => $officerModels['79100812']->id, // Serka Bambang Irawan
                'shift' => 'Malam',
                'start_time' => '23:00:00',
                'end_time' => '07:00:00',
                'status' => 'Terjadwal',
                'notes' => 'Patroli perimeter malam hari dengan penerangan sorot dan lampu senter inframerah.',
            ],
            [
                'shelter_id' => $shelterModels['SH-04']->id, // Shelter Fauna B
                'officer_id' => $officerModels['85031420']->id, // Bripka Wahyu Setiawan
                'shift' => 'Pagi',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'status' => 'Sedang Bertugas',
                'notes' => 'Pemeriksaan pagar tegangan rendah dan tangki minum mamalia besar.',
            ],
            [
                'shelter_id' => $shelterModels['SH-09']->id, // Karantina Medis
                'officer_id' => $officerModels['94021105']->id, // drh. Annisa Safitri
                'shift' => 'Siang',
                'start_time' => '15:00:00',
                'end_time' => '23:00:00',
                'status' => 'Siaga Shift',
                'notes' => 'Observasi harian satwa pasca operasi pemulihan.',
            ],
        ];

        foreach ($todaySchedules as $ts) {
            Schedule::create([
                'shelter_id' => $ts['shelter_id'],
                'officer_id' => $ts['officer_id'],
                'date' => $today->format('Y-m-d'),
                'day' => $daysIndo[$today->format('l')] ?? 'Senin',
                'shift' => $ts['shift'],
                'start_time' => $ts['start_time'],
                'end_time' => $ts['end_time'],
                'status' => $ts['status'],
                'notes' => $ts['notes'],
                'created_by' => $admin->id,
            ]);
        }

        // Past schedules (Yesterday)
        $yesterday = $today->copy()->subDay();
        $pastSchedules = [
            [
                'shelter_id' => $shelterModels['SH-06']->id,
                'officer_id' => $officerModels['93081955']->id, // Agus Supriyadi
                'shift' => 'Pagi',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'status' => 'Selesai Shift',
                'notes' => 'Laporan log serah terima pos tuntas diserahkan ke Danru.',
            ],
            [
                'shelter_id' => $shelterModels['SH-01']->id,
                'officer_id' => $officerModels['95071832']->id, // Pratu Fajar
                'shift' => 'Siang',
                'start_time' => '15:00:00',
                'end_time' => '23:00:00',
                'status' => 'Selesai Shift',
                'notes' => 'Pergantian shift malam berlangsung tepat waktu.',
            ],
            [
                'shelter_id' => $shelterModels['SH-07']->id,
                'officer_id' => $officerModels['89110419']->id, // Kopda Rian
                'shift' => 'Malam',
                'start_time' => '23:00:00',
                'end_time' => '07:00:00',
                'status' => 'Selesai Shift',
                'notes' => 'Kondisi kanopi pulau orangutan terpantau aman.',
            ],
        ];

        foreach ($pastSchedules as $ps) {
            Schedule::create([
                'shelter_id' => $ps['shelter_id'],
                'officer_id' => $ps['officer_id'],
                'date' => $yesterday->format('Y-m-d'),
                'day' => $daysIndo[$yesterday->format('l')] ?? 'Minggu',
                'shift' => $ps['shift'],
                'start_time' => $ps['start_time'],
                'end_time' => $ps['end_time'],
                'status' => $ps['status'],
                'notes' => $ps['notes'],
                'created_by' => $admin->id,
            ]);
        }

        // Upcoming schedules (Next 5 days)
        for ($i = 1; $i <= 5; $i++) {
            $futureDate = $today->copy()->addDays($i);
            $dayName = $daysIndo[$futureDate->format('l')] ?? 'Senin';

            Schedule::create([
                'shelter_id' => $shelterModels['SH-01']->id,
                'officer_id' => $officerModels['87044122']->id,
                'date' => $futureDate->format('Y-m-d'),
                'day' => $dayName,
                'shift' => ($i % 2 == 0) ? 'Siang' : 'Pagi',
                'start_time' => ($i % 2 == 0) ? '15:00:00' : '07:00:00',
                'end_time' => ($i % 2 == 0) ? '23:00:00' : '15:00:00',
                'status' => 'Terjadwal',
                'notes' => 'Rencana patroli berkala regu satwa sektor '.$dayName,
                'created_by' => $admin->id,
            ]);

            Schedule::create([
                'shelter_id' => $shelterModels['SH-02']->id,
                'officer_id' => $officerModels['84091211']->id,
                'date' => $futureDate->format('Y-m-d'),
                'day' => $dayName,
                'shift' => ($i % 2 == 0) ? 'Pagi' : 'Siang',
                'start_time' => ($i % 2 == 0) ? '07:00:00' : '15:00:00',
                'end_time' => ($i % 2 == 0) ? '15:00:00' : '23:00:00',
                'status' => 'Terjadwal',
                'notes' => 'Penugasan koordinasi kesiapan posko harian.',
                'created_by' => $admin->id,
            ]);

            Schedule::create([
                'shelter_id' => $shelterModels['SH-03']->id,
                'officer_id' => $officerModels['93081955']->id,
                'date' => $futureDate->format('Y-m-d'),
                'day' => $dayName,
                'shift' => 'Malam',
                'start_time' => '23:00:00',
                'end_time' => '07:00:00',
                'status' => 'Terjadwal',
                'notes' => 'Piket rotasi malam aviary tropis.',
                'created_by' => $admin->id,
            ]);
        }

        // 6. Activity Logs (Realtime Activity Feed)
        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => 'Bripka Joko Prasetyo',
            'action' => 'LOGIN',
            'module' => 'Autentikasi',
            'description' => 'Check-in biometric berhasil di Terminal Pos Utara. Kondisi pagar pembatas dilaporkan aman terkendali.',
            'ip_address' => '127.0.0.1',
            'created_at' => Carbon::now()->subMinutes(10),
        ]);

        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => 'Super Administrator',
            'action' => 'CREATE',
            'module' => 'Jadwal',
            'description' => 'Admin menambahkan plotting baru untuk Shelter Panda B (Shift Siang) penugasan drh. Ratna Lestari divalidasi sistem: 0 bentrok.',
            'ip_address' => '127.0.0.1',
            'created_at' => Carbon::now()->subMinutes(25),
        ]);

        ActivityLog::create([
            'user_id' => $admin->id,
            'user_name' => 'Serma Hendra Gunawan',
            'action' => 'UPDATE',
            'module' => 'Shelter',
            'description' => 'Serma Hendra G. mengunggah laporan patroli perimeter Shelter Harimau A disertai pengecekan parit air terjun.',
            'ip_address' => '127.0.0.1',
            'created_at' => Carbon::now()->subHour(),
        ]);

        ActivityLog::create([
            'user_id' => null,
            'user_name' => 'Sistem Otomatis',
            'action' => 'BACKUP',
            'module' => 'Sistem',
            'description' => 'Backup database otomatis & sinkronisasi snapshot 148 catatan riwayat roster berhasil diselesaikan.',
            'ip_address' => '127.0.0.1',
            'created_at' => Carbon::now()->subHours(2),
        ]);
    }
}
