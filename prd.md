# PRD UduxPOS (Product Requirements Document)

## 1. Ringkasan Produk
UduxPOS adalah aplikasi web untuk mendukung operasional usaha mikro, kecil, dan menengah (UMKM) yang menjual nasi uduk dan berbagai makanan pendamping. Aplikasi ini dirancang untuk membantu proses pemesanan pelanggan, penjualan langsung, pengelolaan produksi, pencatatan stok bahan baku, pengelolaan stok makanan matang, dan pembuatan laporan penjualan.

UduxPOS memiliki dua jenis pengguna, yaitu **Pelanggan** dan **Admin**. 
- **Pelanggan:** Melihat menu, melakukan pemesanan untuk tanggal pengambilan tertentu, serta memantau status pesanan.
- **Admin:** Mengelola menu, menerima pesanan, mengatur kuota, mencatat produksi, mengelola persediaan, melayani penjualan langsung, menerima pembayaran, dan melihat laporan.

Prinsip utama sistem adalah membedakan stok bahan baku, stok makanan matang, kuota pemesanan, alokasi pesanan online, dan transaksi penjualan agar pencatatan persediaan akurat dan pesanan online yang telah dikonfirmasi tidak terjual kepada pelanggan yang datang langsung.

---

## 2. Latar Belakang dan Permasalahan
Pencatatan manual pada usaha nasi uduk sering memicu masalah berikut:
1. Pesanan pelanggan berisiko terlewat atau tercatat lebih dari satu kali.
2. Pemilik usaha kesulitan mengetahui jumlah pesanan berdasarkan tanggal pengambilan.
3. Makanan untuk pesanan online berisiko terjual ke pelanggan yang datang langsung.
4. Stok bahan baku dan makanan matang sulit dipantau secara akurat.
5. Sisa makanan, makanan kedaluwarsa, dan penggunaan bahan di luar penjualan sulit ditelusuri.
6. Laporan penjualan berisiko tidak sesuai dengan transaksi yang benar-benar diselesaikan dan dibayar.

---

## 3. Tujuan Produk
1. Mempermudah pelanggan melihat menu dan memesan untuk tanggal pengambilan tertentu.
2. Membantu admin mengelola pesanan, kuota menu, dan jadwal persiapan.
3. Mencegah makanan alokasi pesanan online terjual melalui penjualan langsung.
4. Mencatat pengurangan bahan baku berdasarkan proses produksi nyata.
5. Memisahkan stok bahan baku, stok makanan matang, dan alokasi pesanan.
6. Memfasilitasi transaksi penjualan langsung dan pencatatan pembayaran tunai.
7. Menyediakan laporan penjualan, mutasi stok, produksi, dan sisa makanan yang dapat ditelusuri.

---

## 4. Ruang Lingkup Produk

### 4.1 Fitur yang Dikembangkan (Versi Pertama)
1. Registrasi dan login pelanggan.
2. Login admin dengan hak akses khusus.
3. Katalog menu, kategori, harga, dan ketersediaan menu.
4. Keranjang belanja dan pemesanan makanan.
5. Pemilihan tanggal serta waktu pengambilan pesanan.
6. Riwayat dan status pesanan pelanggan.
7. Pengelolaan pesanan, kuota, dan jadwal persiapan oleh admin.
8. Pengelolaan menu, kategori, resep, dan bahan baku.
9. Pencatatan produksi makanan dan pengurangan bahan baku.
10. Pencatatan stok makanan matang, makanan terjual, sisa, dan terbuang.
11. Pencatatan alokasi makanan untuk pesanan online.
12. Penjualan langsung melalui fitur kasir admin.
13. Pembayaran tunai saat pengambilan pesanan.
14. Laporan penjualan dan mutasi persediaan.

### 4.2 Fitur yang Tidak Dikembangkan (Versi Pertama)
- Pembayaran via *payment gateway*, QRIS, kartu, atau transfer otomatis.
- Layanan pengantaran dan integrasi ojek online.
- Aplikasi native Android atau iOS.
- Mode kasir offline.
- Program loyalitas pelanggan & pengelolaan banyak cabang.
- Mode gelap & domain/hosting publik (fase awal localhost).

### 4.3 Platform dan Teknologi
- **Backend:** PHP dengan framework Laravel.
- **Database:** MySQL.
- **Frontend:** HTML, CSS, Bootstrap, dan JavaScript.
- **Environment:** Laragon / PHP local (localhost).

---

## 5. Aturan Bisnis

### 5.1 Pengguna dan Pemesanan
- **Pelanggan:** Melihat katalog (tanpa login), wajib login untuk memesan, memilih porsi/tanggal/waktu, melihat riwayat, dan membatalkan pesanan sesuai aturan.
- **Admin:** Mengelola menu/resep/bahan/kuota/persiapan, konfirmasi/tolak pesanan, catat produksi, kelola stok matang & alokasi, kasir penjualan langsung, catat pembayaran, akses laporan. *(Tidak ada role kasir terpisah).*

### 5.2 Stok Makanan Matang dan Alokasi Pesanan Online
Sistem menggunakan tiga informasi utama:
1. **Stok fisik makanan matang:** Makanan diproduksi & layak jual.
2. **Alokasi pesanan online:** Porsi dicadangkan untuk pesanan online terkonfirmasi.
3. **Stok tersedia untuk penjualan langsung:**
   $$\text{Stok Tersedia} = \text{Stok Fisik Matang} - \text{Alokasi Online Belum Dipenuhi} - \text{Makanan Tidak Layak Jual}$$

### 5.3 Pembayaran
- Metode pembayaran: **Tunai saat pengambilan**.
- Pesanan dikonfirmasi belum tentu lunas. Admin mencatat pembayaran setelah uang diterima. Pesanan belum dibayar tidak masuk ke pendapatan penjualan terealisasi.

### 5.4 Kuota Pemesanan
- Batas maksimal porsi per menu per tanggal pengambilan.
- Kuota awal nasi uduk: **20 bungkus/tanggal**.
- Status pesanan (*Menunggu Konfirmasi, Dikonfirmasi, Sedang Disiapkan, Siap Diambil, Selesai*) menghitung penggunaan kuota. Pesanan ditolak/dibatalkan mengembalikan kuota.

### 5.5 Jadwal Operasional dan Persiapan
- Jam pengambilan: **05.00–07.00**.
- Target siap sarapan: **19.00 hari sebelumnya**.
- Waktu mulai persiapan diatur dinamis oleh admin melalui database.

### 5.6 Status Pesanan & Pembatalan
- **Alur Utama:** `Menunggu Konfirmasi` → `Dikonfirmasi` → `Sedang Disiapkan` → `Siap Diambil` → `Selesai` (Alternatif: `Ditolak`, `Dibatalkan`).
- Pembatalan oleh pelanggan dinonaktifkan setelah persiapan dimulai atau untuk pesanan sarapan keesokan hari yang sudah dikonfirmasi.

### 5.7 Produksi dan Pengurangan Bahan Baku
- Bahan baku **hanya dikurangi saat produksi dicatat** (berdasarkan resep per porsi).
- Konfirmasi pesanan atau penjualan langsung tidak mengurangi bahan baku.

### 5.8 Sisa Makanan dan Kedaluwarsa
- Nasi sisa dicatat sebagai **makanan terbuang** (tidak boleh dijual kembali).
- Lauk (seperti ayam kuah kuning maksimal 2 hari, dll.) dipertimbangkan jika masih layak sesuai aturan penyimpanan.

---

## 6. Kebutuhan Fungsional (Functional Requirements)

| ID | Kebutuhan | Prioritas |
| :--- | :--- | :--- |
| **FR-AUTH-01** | Pelanggan dapat mendaftar dan login. | P1 |
| **FR-AUTH-02** | Admin memiliki halaman login dengan hak akses khusus. | P1 |
| **FR-AUTH-03** | Sistem membatasi halaman berdasarkan peran pengguna. | P1 |
| **FR-AUTH-04** | Kata sandi disimpan dalam bentuk hash. | P1 |
| **FR-MNU-01** | Admin dapat mengelola menu, kategori, dan status menu. | P1 |
| **FR-MNU-02** | Admin dapat menentukan resep dan kebutuhan bahan per porsi. | P1 |
| **FR-ORD-01** | Pelanggan memilih menu, porsi, tanggal, dan waktu pengambilan. | P2 |
| **FR-ORD-03** | Admin dapat mengonfirmasi atau menolak pesanan (wajib alasan). | P2 |
| **FR-ORD-08** | Admin dapat mengatur kuota per menu dan tanggal. | P2 |
| **FR-ORD-12** | Sistem membuat alokasi ketika pesanan dikonfirmasi. | P2 |
| **FR-KSR-01** | Admin dapat mencatat penjualan langsung (POS). | P2 |
| **FR-PAY-01** | Admin dapat mencatat pembayaran tunai setelah uang diterima. | P2 |
| **FR-STK-01** | Admin mencatat stok awal & penambahan bahan baku. | P1 |
| **FR-STK-07** | Admin mencatat jumlah makanan yang diproduksi. | P1 |
| **FR-STK-10** | Stok makanan matang tidak boleh bernilai negatif. | P1 |
| **FR-RPT-01** | Sistem menampilkan laporan penjualan berdasarkan periode. | P3 |

---

## 7. Kebutuhan Nonfungsional
- **Keamanan:** Hashing password, parameter binding/ORM, validasi server, escaping output, CSRF protection, HTTPS untuk production.
- **Integritas Data:** Penggunaan *database transactions* untuk operasi multi-tabel, pencegahan kuota/stok negatif, audit trail mutasi stok.
- **Usability:** Antarmuka responsif (komputer, tablet, ponsel), bahasa Indonesia, formulir & pesan kesalahan yang intuitif.
- **Kinerja:** Waktu muat halaman utama maksimal 3 detik pada jaringan normal.

---

## 8. Entitas dan Struktur Data
Entitas utama dalam database:
- `pengguna` (Customer & Admin)
- `kategori_menu` & `menu`
- `bahan` & `resep`
- `pesanan` & `detail_pesanan`
- `pengaturan_persiapan` & `kuota_menu`
- `alokasi_pesanan`
- `produksi`
- `stok_makanan_matang`
- `mutasi_stok_makanan_matang` & `mutasi_stok_bahan`
- `transaksi`
- `riwayat_status_pesanan`

---

## 9. Alur Operasional Sistem (Ringkas)
1. **Pemesanan Online:** Katalog → Pilih Menu/Tanggal → Validasi Kuota → Checkout (Menunggu Konfirmasi) → Konfirmasi Admin (Alokasi Dibuat) → Produksi (Kurangi Bahan, Tambah Stok Matang) → Siap Diambil → Bayar Tunai & Selesai (Kurangi Stok Matang & Tutup Alokasi).
2. **Penjualan Langsung (POS):** Kasir → Cek Stok Tersedia (setelah dikurangi alokasi online) → Hitung Total → Bayar Tunai → Transaksi Selesai & Kurangi Stok Matang.
3. **Produksi:** Pilih Menu & Jumlah Porsi → Hitung Resep → Validasi Bahan → Kurangi Bahan Baku & Tambah Stok Matang dalam satu Transaksi Database.

---

## 10. Rencana Implementasi
- **Tahap 1 — Fondasi Sistem:** Setup Laravel, DB, Auth, Menu, Kategori, Resep, Bahan, Katalog, Stok Awal, Produksi & Stok Matang.
- **Tahap 2 — Pemesanan Online:** Keranjang, Checkout, Riwayat, Kuota, Pengaturan Persiapan, Alokasi, Validasi Pembatalan.
- **Tahap 3 — Kasir dan Pembayaran:** Penjualan langsung POS, kembalian, pencatatan pembayaran tunai, sisa makanan/kedaluwarsa, penyesuaian stok.
- **Tahap 4 — Laporan dan Pengujian:** Laporan penjualan, mutasi stok, uji skenario fungsional & konkurensi (transaksi bersamaan).
- **Tahap 5 — Penerapan:** Deployment lokal (localhost), perbaikan bug, dokumentasi penggunaan (README).

---

## 11. Kriteria Penerimaan (Acceptance Criteria) - Ringkasan Skenario Utama
1. Produksi 20 porsi ayam bacem $\rightarrow$ Bahan berkurang sesuai resep, stok matang bertambah 20.
2. Penjualan melebihi kuota $\rightarrow$ Ditolak sistem / tampil status *Pesanan Penuh*.
3. Pesanan online dikonfirmasi $\rightarrow$ Alokasi tercatat & dilindungi dari penjualan langsung.
4. Pesanan selesai $\rightarrow$ Stok matang berkurang & alokasi ditutup.
5. Pesanan belum dibayar $\rightarrow$ Tidak masuk laporan penjualan terealisasi.
6. Transaksi bersamaan (konkurensi) $\rightarrow$ Sistem mengunci dan mencegah kelebihan kuota/stok.

---

## 12. Risiko dan Hal yang Perlu Diputuskan
1. Batas waktu penyimpanan & penjualan kembali lauk (ayam bacem, rica-rica) sesuai keamanan pangan.
2. Kebijakan jika pelanggan tidak mengambil pesanan (no-show).
3. Batas waktu konfirmasi admin untuk pesanan pending.
4. Penanganan kekurangan stok bahan baku saat produksi.

---

## 13. Definisi Selesai (Definition of Done)
- Aplikasi berjalan di localhost & terhubung ke MySQL.
- Pelanggan dapat registrasi, login, pesan, dan lihat riwayat.
- Admin dapat kelola menu, resep, bahan, kuota, produksi, stok matang, kasir, dan pembayaran.
- Alokasi online melindungi pesanan dari penjualan langsung.
- Bahan baku hanya berkurang saat produksi dicatat.
- Stok matang tidak bernilai negatif, mutasi tercatat, pesanan belum dibayar tidak masuk penjualan terealisasi, serta seluruh skenario pengujian utama berhasil.