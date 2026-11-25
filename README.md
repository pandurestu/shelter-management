# SHELTER MANAGEMENT SYSTEM (DATABASE JADWAL PLOTTING SHELTER)

Sistem Informasi Manajemen dan Penjadwalan Plotting Petugas Shelter Terpadu berbasis **Laravel 12 / PHP 8.3**, **Blade**, **MySQL**, **Tailwind CSS + Bootstrap 5**, dan **Vanilla JavaScript**. Dibangun dalam satu arsitektur monolitik Laravel utuh tanpa dependensi framework SPA frontend terpisah.

---

## 📋 Fitur Utama Sistem

### 1. Halaman Publik (Home Page)
- **Top Navigation Bar**: Menu navigasi responsif, status operasional real-time, dan tombol Login Petugas/Admin.
- **Hero Section**: Banner utama dengan headline, deskripsi, quick CTA cek jadwal, dan status siaga shelter.
- **Statistik Terhubung Database**: Total Shelter Aktif, Petugas Siaga, Jadwal Terplotting, dan Jam Pengamanan dari MySQL.
- **Katalog & Filter Shelter**: Filter instan per Zona Wilayah (Pusat, Utara, Selatan, Barat, Timur), pencarian real-time nama shelter/lokasi, kapasitas penampungan, status risiko (Rendah, Sedang, Tinggi), dan nama koordinator lapangan.
- **Jadwal Plotting Terkini**: Tabel jadwal aktif hari ini dan mendatang dengan filter shift (Pagi, Siang, Malam), pencarian petugas/shelter, badge status jadwal, dan modal pop-up detail tugas.
- **Modal Interaktif Detail Shelter & Petugas**: Menampilkan informasi lengkap fasilitas, kapasitas, kontak koordinator, peta koordinat, dan detail penugasan personil.
- **Alur Kerja Operasional (SOP)**: Panduan 4 tahap verifikasi identitas, plotting terpusat, pengawasan shift, dan serah terima tugas.
- **Kontak Darurat & Hotline 24 Jam**: Informasi nomor darurat instansi, call center, dan email komando penanggulangan.
- **Footer Responsif**: Hak cipta, navigasi cepat, dan identitas instansi.

### 2. Autentikasi Admin & Petugas
- Form login modern & elegan dengan dukungan login via **Email** atau **NRP (Nomor Registrasi Petugas)**.
- Fitur demo quick-fill (1-klik tombol untuk mengisi kredensial Administrator atau Koordinator Lapangan).
- Validasi form, penanganan error ramah pengguna, pengingat sesi aman.
- Fitur Logout aman dengan pembersihan sesi dan pencatatan audit log otomatis.
- Proteksi penuh seluruh rute dashboard admin dengan auth middleware (`/login` redirect).

### 3. Dashboard Komando Admin
- **Kartu Metrik Operasional**:
  - Total Shelter (dengan indikator status aktif & kapasitas terisi).
  - Total Petugas Terdaftar (dengan persentase personil aktif siap tugas).
  - Total Jadwal Plotting (dengan akumulasi jam jaga shift).
  - Jadwal Bertugas Hari Ini (dengan count shift berjalan).
  - Jadwal Mendatang & Persiapan Pengamanan.
- **Distribusi Personil & Shelter**: Grafik batang visual interaktif (Chart.js) menampilkan penugasan per lokasi shelter.
- **Simulasi & Deteksi Konflik Jadwal Cepat**: Tool interaktif langsung di dashboard untuk mengecek ketersediaan petugas pada tanggal & rentang jam tertentu.
- **Monitoring Visual Kamera CCTV**: Matriks visual live stream/snapshot status situasi shelter utama.
- **Tabel Jadwal Utama Terintegrasi**: Kontrol pencarian, filter status, filter shift, dan aksi cepat (lihat detail, ubah, hapus).
- **Log Aktivitas Terbaru (Audit Trail)**: Riwayat aksi pengguna, perubahan jadwal, input petugas, dan shelter.
- **Tombol Siaga Darurat Cepat (Rapid Alert)**: Tombol broadcast darurat dengan modal konfirmasi dan feedback sistem.

### 4. Manajemen Data Shelter (CRUD Lengkap)
- **Tambah Shelter**: Kode shelter unik, nama, zona wilayah, alamat lengkap, koordinat geografis (latitude/longitude), kapasitas daya tampung, nomor telepon posko, nama koordinator, tingkat risiko bencana, dan status aktif/pemeliharaan.
- **Daftar Shelter**: Tabel modern dengan pagination, pencarian nama/alamat/koordinator, filter zona wilayah, dan filter status operasional.
- **Detail Shelter**: Rekapitulasi spesifikasi fisik posko, profil koordinator, log pemeliharaan, serta riwayat plotting petugas yang ditugaskan ke shelter terkait.
- **Edit & Hapus Shelter**: Form update data dan modal konfirmasi hapus data yang aman dari accidental clicks.

### 5. Manajemen Data Petugas (CRUD Lengkap)
- **Tambah Petugas**: NRP unik (Nomor Registrasi Petugas), nama lengkap, jabatan (Komandan Posko, Koordinator Lapangan, Petugas Medis, Logistik, Keamanan, Relawan), penempatan shelter default, nomor HP/WhatsApp, email resmi, alamat domisili, keahlian khusus, dan status aktif/cuti/siaga.
- **Daftar Petugas**: Filter berdasarkan status, jabatan, dan penempatan shelter; pencarian multi-kolom instan.
- **Detail Petugas**: Kartu identitas personil resmi, rekapitulasi jam terbang shift, riwayat plotting penjagaan, dan informasi kontak darurat.
- **Edit & Hapus Petugas**: Update berkala data personil dengan proteksi integritas relasi jadwal.

### 6. Manajemen Jadwal Plotting (Fitur Inti)
- **Tambah Jadwal Plotting**:
  - Dropdown dinamis Shelter dan Petugas aktif.
  - Pemilihan tanggal jaga dengan **pendeteksian hari otomatis** menggunakan algoritma kalender bahasa Indonesia (*Senin, Selasa, Rabu, Kamis, Jumat, Sabtu, Minggu*).
  - Pemilihan shift standar: **Pagi (07:00 - 15:00)**, **Siang (15:00 - 23:00)**, **Malam (23:00 - 07:00)** atau kustom jam mulai & selesai.
  - **Sistem Deteksi Bentrok Jadwal Ketat (Strict Conflict Detector)**:
    - Memvalidasi agar satu petugas **tidak dapat dijadwalkan pada dua tempat berbeda dalam rentang tanggal dan jam yang tumpang tindih**.
    - Mengembalikan notifikasi error spesifik mencantumkan nama shelter dan shift bentrok jika terjadi tumpang tindih.
    - Dilengkapi API validasi AJAX realtime (`/admin/schedules/check-conflict`) saat pengguna memilih tanggal, petugas, dan jam di form.
- **Daftar Jadwal**: Filter tanggal periode, filter shelter, filter shift, filter status (Terjadwal, Berjalan, Selesai, Dibatalkan), dan pagination.
- **Detail Jadwal**: Informasi rinci plotting, status posko, catatan serah terima, dan checklist kelengkapan dinas.
- **Edit & Hapus**: Pembaruan status penugasan (contoh: dari *Terjadwal* ke *Berjalan* atau *Selesai*).

### 7. Kalender Penjagaan Interaktif
- Visualisasi kalender komando terintegrasi (FullCalendar):
  - **Tampilan Bulanan (Month View)**.
  - **Tampilan Mingguan (Week View)**.
  - **Tampilan Harian (Day View)**.
  - **Tampilan Agenda List**.
- Penandaan warna unik per shelter (*Forest Green, Deep Emerald, Teal, Cyan, Amber, Rose*).
- Klik jadwal untuk membuka modal pop-up detail lengkap petugas dan jam tugas.
- Navigasi cepat bulan sebelumnya, bulan berikutnya, dan tombol *Hari Ini*.

### 8. Laporan & Ekspor Data
- Rekapitulasi laporan multi-dimensi:
  - Laporan Jadwal Plotting (berdasarkan rentang tanggal, shelter, shift, dan status).
  - Laporan Personil Petugas (total jam dinas, status kesiapan, penempatan posko).
  - Laporan Kapasitas & Status Shelter (utilisasi daya tampung, zonasi, status fasilitas).
- **Cetak Laporan Resmi (Print View)**: Template cetak bersih ramah printer & PDF browser dengan kop dinas resmi, ringkasan metrik, tabel lengkap, dan tanda tangan komandan posko.
- **Ekspor Excel (CSV dengan UTF-8 BOM)**: File CSV siap buka di Microsoft Excel tanpa masalah karakter huruf rusak.

### 9. Pengaturan Sistem
- **Profil Admin**: Update nama, email, nomor kontak dinas, dan foto profil.
- **Keamanan Akun**: Form ganti password dengan validasi password lama dan konfirmasi password baru.
- **Konfigurasi Website**: Pengaturan nama instansi, status kesiagaan darurat nasional/daerah, nomor hotline call center, email posko darurat, alamat markas komando, dan catatan pengumuman publik.

### 10. Audit Log & Jejak Aktivitas
- Pencatatan otomatis setiap aksi penting di sistem (Login, Logout, Tambah/Ubah/Hapus Shelter, Petugas, Plotting Jadwal, Broadcast Darurat).
- Mencantumkan pengguna, alamat IP, timestamp waktu, serta detail parameter perubahan.

---

## 🛠️ Spesifikasi Teknologi

| Komponen | Spesifikasi / Library |
|---|---|
| **Backend Framework** | Laravel 12 (PHP 8.2 – 8.3) |
| **Arsitektur** | Laravel Monolithic MVC (Controller, Form Request, Eloquent Model, Blade Views) |
| **Database** | MySQL 8.x / MariaDB (Driver PDO MySQL) |
| **Frontend Layout** | Blade Templating Engine |
| **CSS System** | Tailwind CSS CDN + Bootstrap 5.3 Framework + Custom Design Tokens |
| **Icon & Typography** | Google Material Symbols Outlined, FontAwesome 6, Plus Jakarta Sans, Inter Font |
| **Interaktivitas UI** | Vanilla JavaScript, Chart.js 4.4, FullCalendar 6.1, Bootstrap Modals & Toasts |
| **Palet Warna** | Forest Green (`#14532d`), Deep Forest (`#052e16`), Emerald (`#15803d`), Mint Subtle (`#f0fdf4`), Surface Border (`#bbf7d0`) |

---

## 🗄️ Struktur Database MySQL

1. **`users`**: Data admin & koordinator posko (`id`, `name`, `email`, `password`, `phone`, `role`, `avatar`, timestamps).
2. **`shelters`**: Posko shelter pengungsian (`id`, `code`, `name`, `zone`, `address`, `latitude`, `longitude`, `capacity`, `phone`, `coordinator_name`, `status`, `risk_level`, `facilities`, timestamps).
3. **`officers`**: Personil petugas jaga (`id`, `nrp`, `name`, `position`, `shelter_id`, `phone`, `email`, `address`, `status`, `specialty`, timestamps).
4. **`schedules`**: Jadwal plotting shift (`id`, `shelter_id`, `officer_id`, `date`, `day_name`, `shift`, `start_time`, `end_time`, `notes`, `status`, timestamps).
5. **`activity_logs`**: Rekam jejak audit keamanan (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, timestamps).
6. **`settings`**: Variabel konfigurasi website dinamis (`id`, `key`, `value`, `group`, timestamps).

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### 1. Prasyarat Sistem
- PHP versi 8.2 atau 8.3 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`).
- Composer versi 2.x.
- MySQL Server 8.x / MariaDB (misalnya via Laragon atau XAMPP).

### 2. Konfigurasi Environment (`.env`)
Pastikan file `.env` di folder project telah mengarah ke server MySQL Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shelter_management
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Seeding Database
Jalankan migrasi database dan pengisian data operasional awal:
```bash
php artisan migrate:fresh --seed
```
*Seeder akan otomatis mengisi data 24 Posko Shelter di berbagai zona, 18 Personil Petugas dengan spesialisasi beragam, 28 Jadwal Plotting aktif (hari ini, kemarin, dan mendatang), data pengaturan posko, dan akun administrator.*

### 4. Menjalankan Server Lokal
Jalankan development server Laravel bawaan:
```bash
php artisan serve
```
Buka browser dan akses alamat:
```
http://127.0.0.1:8000
```

---

## 🔐 Kredensial Akun Bawaan

| Role | Email Login | Alternatif NRP | Password Default | Hak Akses |
|---|---|---|---|---|
| **Super Administrator** | `admin@shelter.id` | `ADM-001` | `password` | Seluruh Modul Sistem & Pengaturan |
| **Koordinator Posko** | `budi.santoso@shelter.id` | `NRP-1001` | `password` | Manajemen Lapangan & Monitoring Jadwal |

---

## 🧪 Pengujian Unit & Fitur (PHPUnit)

Proyek ini telah dilengkapi dengan 13 skenario Feature Test otomatis untuk memastikan kestabilan seluruh modul utama:
```bash
vendor/bin/phpunit
```
*Mencakup verifikasi akses Home publik, autentikasi admin, validasi gagal login, CRUD shelter, CRUD petugas, pencegahan bentrok jadwal plotting ganda, ekspor laporan Excel CSV, dan pembaruan pengaturan profil.*

---

## 📂 Struktur Direktori Proyek

```
shelter-management/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── ActivityLogController.php   # Audit log aktivitas
│   │       ├── AuthController.php          # Login, logout, proteksi rute
│   │       ├── CalendarController.php      # Kalender bulanan/mingguan
│   │       ├── DashboardController.php     # Ringkasan analitik & CCTV
│   │       ├── HomeController.php          # Halaman depan publik & filter
│   │       ├── OfficerController.php       # Manajemen data petugas
│   │       ├── ReportController.php        # Laporan, cetak print, ekspor CSV
│   │       ├── ScheduleController.php      # Manajemen jadwal & deteksi bentrok
│   │       ├── SettingController.php       # Profil, password, info website
│   │       └── ShelterController.php       # Manajemen data shelter
│   └── Models/
│       ├── ActivityLog.php
│       ├── Officer.php
│       ├── Schedule.php
│       ├── Setting.php
│       ├── Shelter.php
│       └── User.php
├── database/
│   ├── migrations/                         # Skema tabel MySQL terstruktur
│   └── seeders/
│       └── DatabaseSeeder.php              # Seeder data realistis
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── activity_logs/index.blade.php
│       │   ├── calendar/index.blade.php
│       │   ├── dashboard.blade.php
│       │   ├── officers/ (index, create, edit, show)
│       │   ├── reports/ (index, print)
│       │   ├── schedules/ (index, create, edit, show)
│       │   ├── settings/index.blade.php
│       │   └── shelters/ (index, create, edit, show)
│       ├── auth/
│       │   └── login.blade.php
│       ├── layouts/
│       │   └── app.blade.php               # Sidebar komando, navbar, toast feedback
│       └── home.blade.php                  # Halaman publik interaktif premium
├── routes/
│   └── web.php                             # 37 rute terdaftar dengan named route
└── tests/
    └── Feature/
        ├── ExampleTest.php
        └── ShelterManagementTest.php       # 13 test cases otomatis lulus 100%
```

---
*Dibuat untuk Sistem Manajemen Posko Bencana & Pengendalian Plotting Penjagaan Shelter Terpadu.*
