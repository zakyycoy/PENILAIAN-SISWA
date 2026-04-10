# 📚 Sistem Manajemen Nilai Sekolah

Aplikasi web untuk mengelola data siswa, guru, dan nilai di sekolah.

## 📋 Fitur

- ✅ **Dashboard** - Ringkasan statistik data
- ✅ **Kelola Siswa** - Tambah, Edit, Hapus data siswa
- ✅ **Kelola Guru** - Tambah, Edit, Hapus data guru
- ✅ **Input Nilai** - Catat nilai siswa per mata pelajaran
- ✅ **Laporan & Statistik** - Analisis nilai, rata-rata, dan ranking

## 🛠️ Teknologi

- **Backend**: PHP 8.x
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3
- **Server**: Apache (XAMPP)

## 📁 Struktur Folder

```
PSTS/
├── index.php              # Halaman utama & dashboard
├── config.php             # Konfigurasi database
├── database_dump.sql      # File SQL dump
├── assets/
│   └── style.css         # Styling CSS
└── pages/
    ├── siswa.php         # Manajemen siswa
    ├── guru.php          # Manajemen guru
    ├── nilai.php         # Input nilai
    └── laporan.php       # Laporan & statistik
```

## 🚀 Instalasi & Cara Menggunakan

### 1. Setup Database
```sql
-- Database sudah dibuat di file database_dump.sql
-- Import file tersebut ke MySQL
```

### 2. Akses Aplikasi
- Buka browser: `http://localhost/PSTS/`
- MySQL harus running di XAMPP

### 3. Navigasi Menu
- **Dashboard** - Lihat ringkasan statistik
- **Kelola Siswa** - Manajemen data siswa
- **Kelola Guru** - Manajemen data guru
- **Input Nilai** - Catat nilai siswa
- **Laporan** - Lihat analisis dan statistik

## 📊 Database Tabel

### guru
- id (Primary Key)
- nip (Nomor Induk Pegawai)
- nama
- jk (Jenis Kelamin)
- tempat_lahir
- tanggal_lahir
- telepon
- foto

### siswa
- id (Primary Key)
- nis (Nomor Induk Siswa)
- nama
- jk (Jenis Kelamin)
- tempat_lahir
- tanggal_lahir
- kelas_id (Foreign Key)
- foto

### mapel
- id (Primary Key)
- mapel (Nama Mata Pelajaran)
- sks (Satuan Kredit Semester)

### kelas
- id (Primary Key)
- kelas (Nama Kelas)
- kapasitas
- terisi (Jumlah Siswa)

### nilai
- id (Primary Key)
- siswa_id (Foreign Key)
- mapel_id (Foreign Key)
- guru_id (Foreign Key)
- nilai

### guru_kelas (Relasi)
- id (Primary Key)
- guru_id (Foreign Key)
- kelas_id (Foreign Key)

### guru_mapel (Relasi)
- id (Primary Key)
- guru_id (Foreign Key)
- mapel_id (Foreign Key)

## 🎯 Fitur Detail

### Dashboard
- Menampilkan total siswa, guru, mapel, dan nilai
- Ringkasan cepat status aplikasi

### Kelola Siswa
- Form input: NIS, Nama, JK, Tempat Lahir, Tanggal Lahir, Kelas
- Tabel daftar siswa dengan aksi Edit/Hapus
- Update data siswa yang sudah ada

### Kelola Guru
- Form input: NIP, Nama, JK, Tempat Lahir, Tanggal Lahir, Telepon
- Tabel daftar guru dengan aksi Edit/Hapus
- Update data guru yang sudah ada

### Input Nilai
- Pilih Siswa, Mata Pelajaran, Guru, dan Nilai (0-100)
- Tabel daftar nilai dengan aksi Edit/Hapus
- Update nilai yang sudah diinput

### Laporan & Statistik
- **Statistik Umum**: Total siswa, guru, mapel, nilai
- **Rata-rata Per Siswa**: Dengan grade otomatis (A-E)
- **Statistik Per Mapel**: Jumlah nilai dan rata-rata
- **Nilai Tertinggi**: Per mata pelajaran

## 💾 Data Sample

Aplikasi sudah dilengkapi dengan data sample:
- **2 Guru**: Muhidin, Nasuha P
- **6 Siswa**: Sudah tersebar di berbagai kelas
- **6 Mapel**: Matematika, English, TIK, Web Programming, Bahasa Indonesia, Sejarah
- **5 Kelas**: X Unggulan & X IPS

## 🔐 Catatan Keamanan

Untuk produksi, tambahkan:
- ✨ Autentikasi/Login
- ✨ Input validation lebih ketat
- ✨ CSRF protection
- ✨ SQL injection prevention (sudah ada escape dasar)
- ✨ Session management yang lebih baik

## 📝 Lisensi

Free to use for educational purposes.

## 👨‍💻 Dibuat Dengan

Copilot Assistant - 2026
