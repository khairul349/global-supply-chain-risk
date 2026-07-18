# Global Supply Chain Risk Intelligence Platform (SupplyGuard)

SupplyGuard adalah platform intelijen risiko logistik global tingkat perusahaan (enterprise) secara real-time. Platform ini memungkinkan organisasi untuk memantau kerentanan rantai pasok, peristiwa geopolitik, gangguan cuaca, dan volatilitas ekonomi di seluruh wilayah hukum yang dilacak. Dibangun dengan UI **Dark Glassmorphism** yang modern, SupplyGuard menawarkan indeks risiko prediktif, peta spasial interaktif, dan analitik data dinamis.

---

## 🚀 Key Features

### 1. Main Control Panel
- **Executive Dashboard**: Pusat kontrol terpadu yang menampilkan tingkat ancaman global, peringatan aktif, bagan risiko interaktif, dan peringatan berita real-time.
- **Country Intelligence**: Profil terperinci untuk negara-negara yang dilacak, memuat skor risiko yang dihitung secara khusus, cuaca lokal saat ini, dan indikator PDB.
- **Weather Threat Center**: Pemantauan risiko badai real-time, suhu, kecepatan angin, dan curah hujan di seluruh koridor logistik.
- **Economic Watch**: Pelacakan dinamis indikator ekonomi global termasuk tingkat inflasi, kesehatan keuangan, dan pertumbuhan PDB.
- **Currency Intelligence**: Nilai tukar mata uang asing terkini relatif terhadap mata uang dasar untuk memitigasi risiko transaksi keuangan.
- **Ports & Maritime Traffic**: Kepadatan pelabuhan langsung, pemantauan kapal aktif, dan penilaian risiko pelabuhan berbasis lokasi.
- **News & Geopolitical Alerts**: Pengikis sentimen berita algoritmik yang menyoroti peristiwa negatif, positif, atau netral yang berdampak pada rute pasokan.

### 2. Risk Analytics Module
- **Risk Score Engine**: Indeks risiko yang dihitung secara otomatis berdasarkan bobot komposit keparahan cuaca, sentimen berita, inflasi, dan stabilitas mata uang.
- **Watchlist Manager**: Daftar pantau kustom yang memungkinkan manajer risiko untuk menandai dan memantau secara ketat titik-titik kritis.
- **Side-by-Side Comparison**: Alat analitik komparatif untuk mengevaluasi skor risiko dan tingkat ancaman antara beberapa rute pasokan.
- **Interactive Global Map**: Peta dunia Leaflet.js interaktif dengan lebar penuh yang menampilkan:
  - Penanda tingkat ancaman negara berkode warna (🔴 Tinggi, 🟡 Sedang, 🟢 Rendah).
  - Perencana Rute Dinamis dengan perhitungan jarak dan animasi rute untuk mode transportasi Maritim, Udara, dan Darat.
  - Tooltip nama negara yang persisten.

### 3. Notification Center
- Mesin notifikasi jajak pendapat (polling) real-time yang memicu peringatan Toast dan push Desktop untuk notifikasi kritis.
- Panel dropdown yang sepenuhnya interaktif mencakup pencarian, pemfilteran kata kunci, dan klasifikasi kategori pesan (Risiko, Cuaca, Berita, Ekonomi).
- Perintah Tandai Telah Dibaca, Baca Semua, dan hapus tunggal/massal yang disimpan secara lokal untuk privasi maksimum.

### 4. User Profile & Preferences
- **View Profile**: Menampilkan unggahan avatar, metadata tanggal bergabung, statistik Konten yang Dikontribusikan, dan Lini Masa Aktivitas.
- **Edit Profile**: Pembaruan inline untuk Nama Lengkap, Nama Pengguna (Username), Telepon, Lokasi, Zona Waktu, dan Bio dengan pratinjau file langsung.
- **Security & Account Settings**: Pembaruan kata sandi dengan indikator kekuatan kata sandi, sakelar tampilkan/sembunyikan, dan preferensi notifikasi desktop/email kustom.
- **Activity Log**: Log audit lokal yang menyimpan setiap tindakan pengguna, lengkap dengan pencarian filter query, paginasi sisi klien, dan ekspor CSV.

### 5. Administrator Panel
- **User Management**: Kontrol CRUD lengkap untuk akun sistem (Nama lengkap, username, validasi kata sandi, penetapan peran antara Admin dan User, serta pengalihan status aktif/nonaktif).
- **Article Management**: Pengeditan konten tingkat lanjut yang berisi:
  - Integrasi Editor Teks Kaya (Rich Text Editor) Quill.js.
  - Pembuat slug URL otomatis secara real-time.
  - Kolom deskripsi Meta SEO dan kata kunci.
  - Status Draf vs. Diterbitkan (Published) dan tag Unggulan (Featured).

---

## 🛠 Technology Stack

- **Backend Framework**: Laravel 11.x (PHP 8.2+)
- **Database**: MySQL / MariaDB (Eloquent ORM)
- **Frontend Architecture**: Tailwind CSS (utilitas dasbor kustom), Bootstrap 5, Vanilla CSS
- **Interactive Maps**: Leaflet.js & OpenStreetMap
- **Data Visualizations**: Chart.js
- **Rich Text Editor**: Quill.js

---

## 📋 Installation & Setup

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- XAMPP / WampServer (untuk server database MySQL)
- Node.js & NPM (opsional, untuk kompilasi aset)

### Steps

1. **Clone the Repository**
   ```bash
   cd C:/xampp/htdocs
   git clone <repository-url> global-supply-chain-risk
   cd global-supply-chain-risk
   ```

2. **Install Composer Dependencies**
   ```bash
   composer install
   ```

3. **Configure Environment Variables**
   Salin file contoh env dan perbarui kredensial database Anda:
   ```bash
   cp .env.example .env
   ```
   Konfigurasikan blok database di `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=global_supply_chain_risk
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Encryption Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Database Migrations & Seeders**
   Buat skema database dan isi dengan data awal negara, pelabuhan, cuaca, dan indikator ekonomi:
   ```bash
   php artisan migrate --seed
   ```

6. **Run Development Server**
   Mulai server pengembangan lokal Laravel:
   ```bash
   php artisan serve
   ```
   Buka `http://127.0.0.1:8000` di browser web Anda.

---

## 🔒 Security & Middleware
- **Auth Guard**: Semua rute kecuali `/login` and `/register` dilindungi di bawah middleware `auth`.
- **Admin Guard**: Sumber daya admin (Manajemen Pengguna dan Artikel) dilindungi di bawah middleware `admin`. Setiap upaya tidak sah oleh pengguna biasa akan diblokir dengan layar kesalahan `403 Forbidden`.
