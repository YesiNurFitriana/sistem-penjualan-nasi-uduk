# UduxPOS Development Skill

## 1. Identitas dan Tujuan Proyek
UduxPOS adalah aplikasi web untuk membantu operasional UMKM nasi uduk. Aplikasi menggabungkan pemesanan online, pengelolaan pesanan, produksi makanan, stok bahan baku, stok makanan matang, penjualan langsung, pembayaran tunai, dan laporan.

Tujuan utama pengembangan adalah menghasilkan aplikasi yang:
- Mudah digunakan oleh pelanggan dan pemilik usaha.
- Memiliki alur pemesanan yang jelas.
- Menjaga akurasi stok bahan baku dan makanan matang.
- Melindungi makanan yang telah dialokasikan untuk pesanan online agar tidak terjual kepada pelanggan langsung.
- Mencatat setiap perubahan stok dan transaksi.
- Dapat dijalankan secara lokal melalui localhost.

Jangan memperlakukan UduxPOS sebagai aplikasi katalog dan keranjang belanja biasa. Aturan produksi, kuota, alokasi pesanan, stok matang, dan transaksi merupakan bagian penting dari logika bisnis.

---

## 2. Teknologi yang Digunakan
Gunakan teknologi berikut:
- **Backend:** PHP dengan Laravel.
- **Database:** MySQL.
- **Frontend:** Blade, HTML, CSS, Bootstrap, dan JavaScript.
- **Lingkungan pengembangan:** Laragon atau lingkungan PHP lokal yang kompatibel.
- **Target awal:** localhost.
- **Bahasa antarmuka:** Bahasa Indonesia.

Gunakan versi Laravel dan PHP yang sudah terpasang pada proyek. Jangan melakukan upgrade versi utama atau mengganti struktur proyek tanpa alasan teknis yang jelas.

Sebelum menulis kode:
1. Periksa struktur folder proyek.
2. Periksa `composer.json` dan versi Laravel.
3. Periksa konfigurasi database pada `.env`.
4. Periksa routes, controllers, models, migrations, views, middleware, dan tests yang sudah ada.
5. Gunakan struktur dan pola kode yang sudah diterapkan jika masih sesuai.

Jangan menghapus atau menimpa pekerjaan yang sudah ada tanpa pemeriksaan terlebih dahulu.

---

## 3. Aturan Kerja AI Coding Agent
Bertindak sebagai Laravel developer yang membangun aplikasi secara bertahap dan menjaga integritas data.

Untuk setiap fitur:
1. Pahami kebutuhan dan aturan bisnisnya.
2. Periksa kode yang sudah ada.
3. Jelaskan rencana implementasi secara singkat.
4. Identifikasi perubahan database yang diperlukan.
5. Implementasikan fitur secara lengkap, termasuk validasi, otorisasi, antarmuka, dan pengujian.
6. Jalankan pemeriksaan atau tes yang tersedia.
7. Jelaskan file yang dibuat atau diubah dan cara menguji fitur tersebut.

Gunakan:
- Laravel migrations untuk perubahan struktur database.
- Eloquent ORM untuk pengelolaan model dan relasi.
- Form Request atau validasi Laravel untuk validasi input.
- Middleware dan policies untuk otorisasi.
- Blade untuk halaman aplikasi.
- Service class atau action class untuk logika bisnis yang kompleks apabila diperlukan.
- Database transactions untuk operasi yang mengubah beberapa data sekaligus.

Hindari:
- Membuat seluruh aplikasi dalam satu kode panjang yang sulit diperiksa.
- Menulis logika bisnis penting hanya di JavaScript.
- Mengandalkan nilai harga, stok, total, status, atau role dari browser.
- Menggandakan logika yang sama di banyak controller.
- Menghapus riwayat mutasi stok.
- Menampilkan pesan berhasil sebelum penyimpanan benar-benar berhasil.
- Membuat fitur tambahan yang tidak dibutuhkan tanpa persetujuan.
- Mengubah aturan bisnis yang sudah ditetapkan secara diam-diam.

Jika terdapat aturan yang belum diputuskan, dokumentasikan sebagai keputusan tertunda. Jangan mengarang kebijakan operasional atau keamanan pangan.

---

## 4. Pengguna dan Hak Akses
UduxPOS hanya memiliki dua peran:

### Pelanggan
Pelanggan dapat:
- Melihat katalog tanpa login.
- Mendaftar dan login.
- Memilih menu, jumlah porsi, dan tanggal pengambilan.
- Melakukan pemesanan setelah login.
- Melihat riwayat dan status pesanannya.
- Membatalkan pesanan apabila memenuhi aturan pembatalan.

*Pelanggan tidak boleh mengakses halaman admin atau melihat dan mengubah pesanan pelanggan lain.*

### Admin
Admin dapat:
- Mengelola menu dan kategori.
- Mengelola bahan baku dan resep.
- Mengatur kuota dan jadwal persiapan.
- Mengonfirmasi atau menolak pesanan.
- Mencatat produksi.
- Mengelola stok makanan matang dan sisa makanan.
- Mengelola alokasi pesanan online.
- Melayani penjualan langsung melalui fitur kasir.
- Mencatat pembayaran tunai.
- Melihat laporan.

*Tidak ada role kasir terpisah. Seluruh fungsi kasir dijalankan oleh Admin.*

Semua pembatasan akses harus diperiksa di server. Menyembunyikan tombol atau menu saja tidak cukup.

---

## 5. Identitas Visual dan UI/UX
Gunakan desain sederhana, modern, bersih, dan mudah dipahami.

Panduan desain:
- Warna utama hijau tua.
- Gunakan putih, krem, atau warna netral sebagai pendukung.
- Tipografi mudah dibaca.
- Layout responsif untuk komputer dan ponsel.
- Navigasi jelas dan konsisten.
- Gunakan istilah Bahasa Indonesia yang mudah dipahami.
- Hindari animasi berlebihan, dekorasi yang tidak diperlukan, dan dashboard yang terlalu ramai.
- Sediakan placeholder apabila foto menu belum tersedia.
- Tampilkan pesan validasi, status kosong, dan pesan kesalahan dengan jelas.
- Jangan mengandalkan warna saja untuk membedakan status.

Antarmuka pelanggan harus sederhana karena pengguna dapat memiliki tingkat pemahaman teknologi yang berbeda-beda.  
Antarmuka admin harus mengutamakan kejelasan informasi pesanan, kuota, stok matang, alokasi, dan kebutuhan produksi.

---

## 6. Jadwal Operasional
Ketentuan awal:
- Jam pengambilan makanan: pukul 05.00–07.00.
- Makanan untuk pesanan sarapan ditargetkan siap pukul 19.00 pada hari sebelumnya.
- Waktu mulai persiapan ditentukan oleh admin.
- Pukul 16.00 hanya contoh, bukan waktu yang boleh ditanamkan secara permanen di kode.
- Pelanggan dapat memesan pada malam hari untuk pengambilan pagi berikutnya sesuai ketersediaan dan kuota.

Simpan pengaturan persiapan di database agar dapat diubah sesuai kebutuhan usaha.  
Gunakan zona waktu operasional yang konsisten, yaitu `Asia/Jakarta`, untuk pengolahan waktu bisnis. Jangan mengandalkan zona waktu komputer tanpa konfigurasi yang jelas.

---

## 7. Konsep Stok yang Wajib Dipisahkan
Jangan menyatukan seluruh jenis stok menjadi satu angka.

### 7.1 Stok Bahan Baku
Jumlah bahan yang tersedia sebelum atau selama proses produksi, misalnya beras, santan, sayuran, ayam, dan bumbu.

### 7.2 Stok Makanan Matang
Jumlah makanan yang benar-benar sudah diproduksi, tersedia secara fisik, dan masih layak dijual.  
*Pesanan yang baru masuk tidak menambah stok makanan matang.*

### 7.3 Kuota Pemesanan
Batas maksimal porsi yang boleh dipesan untuk suatu menu pada tanggal pengambilan tertentu.  
*Kuota bukan stok fisik dan bukan jumlah makanan yang sudah diproduksi.*

### 7.4 Alokasi Pesanan Online
Jumlah porsi yang dicadangkan untuk pesanan online yang sudah dikonfirmasi.  
Alokasi melindungi pesanan pelanggan, tetapi tidak menciptakan stok makanan matang baru.

### 7.5 Stok Tersedia untuk Penjualan Langsung
Jumlah makanan matang yang boleh dijual kepada pelanggan yang datang langsung setelah memperhitungkan alokasi online dan makanan yang tidak layak jual.

Secara konseptual:
$$\text{stok\_penjualan\_langsung} = \text{stok\_matang\_layak\_jual} - \text{alokasi\_online\_yang\_belum\_dipenuhi}$$

Pastikan implementasi mempertimbangkan batch produksi, tanggal pengambilan, masa kelayakan, dan alokasi agar satu porsi tidak dihitung atau dijual dua kali.

---

## 8. Aturan Produksi dan Bahan Baku
Bahan baku hanya dikurangi ketika produksi benar-benar dicatat.

Alur produksi:
1. Admin memilih menu yang diproduksi.
2. Admin memasukkan jumlah porsi yang dihasilkan.
3. Sistem membaca resep per porsi.
4. Sistem menghitung kebutuhan setiap bahan baku.
5. Sistem memeriksa ketersediaan bahan.
6. Admin mengonfirmasi pencatatan produksi.
7. Sistem mengurangi bahan baku sesuai resep.
8. Sistem menambahkan hasil produksi ke stok makanan matang.
9. Sistem mencatat mutasi bahan baku dan makanan matang.

Aturan wajib:
- Konfirmasi pesanan tidak mengurangi bahan baku.
- Penjualan langsung tidak mengurangi bahan baku.
- Penyelesaian pesanan online tidak mengurangi bahan baku untuk kedua kalinya.
- Penggunaan bahan di luar produksi harus dicatat sebagai mutasi terpisah.
- Setiap mutasi mencatat jenis, jumlah, waktu, pelaksana, dan alasan jika diperlukan.
- Stok makanan matang tidak boleh negatif.
- Stok bahan baku yang tidak mencukupi harus memunculkan peringatan.
- Pengurangan yang menyebabkan stok bahan baku negatif hanya dapat dilakukan setelah konfirmasi admin dan alasan tercatat.

Pencatatan produksi dan seluruh perubahan stok yang terkait harus berada dalam satu transaksi database. Jika salah satu proses gagal, batalkan seluruh perubahan.  
Cegah pencatatan produksi yang sama menerapkan pengurangan bahan baku lebih dari satu kali.

---

## 9. Aturan Kuota Pemesanan
Kuota diatur berdasarkan kombinasi menu dan tanggal pengambilan.

Ketentuan:
- Kuota awal nasi uduk adalah 20 bungkus per tanggal pengambilan.
- Kuota menu lain ditentukan oleh admin.
- Kuota dihitung berdasarkan jumlah porsi.
- Pesanan dengan status **Menunggu Konfirmasi**, **Dikonfirmasi**, **Sedang Disiapkan**, **Siap Diambil**, dan **Selesai** dihitung sebagai penggunaan kuota.
- Pesanan **Ditolak** dan pesanan **Dibatalkan** secara sah tidak menggunakan kuota.
- Sistem memeriksa kuota saat pelanggan mengirimkan pesanan.
- Sistem memeriksa kembali kuota saat admin mengonfirmasi pesanan.
- Jika kuota penuh, tampilkan “Pesanan penuh”.
- Jika kuota belum ditentukan untuk suatu tanggal, tampilkan “Belum tersedia”.
- Jika admin mencoba menurunkan kuota di bawah pesanan yang sudah terikat, tampilkan peringatan dan jangan membatalkan pesanan otomatis.

Gunakan transaksi database, penguncian baris, atau mekanisme atomik yang sesuai untuk mencegah pemesanan bersamaan melampaui kuota.

---

## 10. Aturan Alokasi Pesanan Online
1. Ketika pesanan diajukan, sistem memeriksa menu, tanggal, dan kuota.
2. Ketika admin mengonfirmasi pesanan, sistem memeriksa kuota kembali.
3. Setelah konfirmasi berhasil, sistem mencatat alokasi sesuai jumlah porsi pada detail pesanan.
4. Alokasi harus dapat dibedakan dari stok fisik makanan matang.
5. Jika makanan belum diproduksi, sistem menampilkan kebutuhan produksi yang belum terpenuhi.
6. Penjualan langsung hanya boleh menggunakan stok matang yang tersedia setelah dikurangi alokasi yang belum dipenuhi.
7. Ketika pesanan online benar-benar diserahkan dan status menjadi **Selesai**, sistem mengurangi stok matang sesuai jumlah yang diserahkan dan menutup alokasi.
8. Ketika pesanan ditolak atau dibatalkan secara sah, sistem melepaskan alokasi dan mengembalikan kuota.
9. Pelepasan alokasi tidak boleh menambah stok fisik makanan matang.
10. Setiap alokasi, pelepasan, dan penyelesaian alokasi harus memiliki riwayat.

Gunakan tabel `alokasi_pesanan` atau struktur setara yang menyimpan detail pesanan, jumlah porsi, status, waktu alokasi, waktu pelepasan, dan waktu penutupan.  
Semua validasi harus dilakukan di server. Jangan menerima jumlah stok atau alokasi yang dikirim dari browser sebagai sumber kebenaran.

---

## 11. Status Pesanan
Alur status utama:  
`Menunggu Konfirmasi` → `Dikonfirmasi` → `Sedang Disiapkan` → `Siap Diambil` → `Selesai`

Status alternatif:
- `Ditolak`
- `Dibatalkan`

Simpan waktu setiap perubahan status dan identitas pengguna yang melakukan perubahan.

Ketentuan:
- Penolakan oleh admin wajib memiliki alasan.
- Pembatalan khusus oleh admin wajib memiliki alasan.
- Perubahan status harus mengikuti transisi yang diizinkan.
- Pelanggan hanya boleh mengakses pesanan miliknya sendiri.
- Perubahan status harus divalidasi di server.
- Riwayat status tidak boleh dihapus melalui antarmuka aplikasi.

Status pesanan harus dipisahkan dari status pembayaran. Pesanan yang dikonfirmasi belum tentu sudah dibayar.

---

## 12. Aturan Pembatalan
- Pesanan sarapan untuk keesokan hari tidak dapat dibatalkan oleh pelanggan melalui aplikasi setelah dikonfirmasi admin.
- Pesanan untuk tanggal yang lebih jauh dapat dibatalkan sebelum waktu mulai persiapan yang tercatat.
- Pesanan yang masih menunggu konfirmasi dapat dibatalkan selama persiapan belum dimulai.
- Setelah persiapan dimulai, pembatalan pelanggan ditolak.
- Pembatalan khusus oleh admin membutuhkan alasan dan riwayat audit.
- Pembatalan yang sah melepaskan alokasi dan kuota.
- Bahan baku yang sudah digunakan untuk produksi tidak boleh otomatis dikembalikan ke stok.

Validasi pembatalan harus memperhitungkan status pesanan, tanggal pengambilan, waktu lokal, dan pengaturan persiapan. Jangan hanya mengandalkan tombol pembatalan yang disembunyikan di UI.  
Kebijakan pelanggan yang tidak mengambil pesanan dan batas waktu konfirmasi admin belum ditetapkan. Jangan mengimplementasikan kebijakan otomatis untuk keduanya sebelum ada keputusan pemilik usaha.

---

## 13. Stok Makanan Matang, Sisa, dan Kedaluwarsa
Setiap perubahan stok matang harus tercatat.  
Jenis mutasi dapat meliputi:
- Produksi.
- Penjualan langsung.
- Penyerahan pesanan online.
- Sisa makanan yang masih layak.
- Makanan terbuang.
- Makanan kedaluwarsa.
- Penyesuaian stok manual.

Ketentuan:
- Nasi yang tersisa tidak boleh dijual kembali dan harus dicatat sebagai makanan terbuang.
- Ayam bacem, ayam rica-rica, dan ayam kuah kuning hanya dapat dijual kembali jika masih layak dan memenuhi batas penyimpanan yang disetujui pemilik usaha.
- Batas awal ayam kuah kuning adalah maksimal dua hari.
- Batas penyimpanan ayam bacem dan ayam rica-rica belum ditentukan. Jangan mengarang batas keamanan pangan. Nonaktifkan penjualan kembali untuk item tersebut sampai batasnya disetujui.
- Makanan kedaluwarsa atau tidak layak jual harus dikecualikan dari penjualan.
- Penyesuaian stok manual wajib menyimpan stok sebelum perubahan, stok sesudah perubahan, waktu, pelaksana, dan alasan.
- Riwayat mutasi tidak boleh dihapus melalui aplikasi.

---

## 14. Pembayaran dan Penjualan
Versi pertama hanya mendukung pembayaran tunai saat pengambilan.

Ketentuan:
- Pelanggan dapat memesan tanpa membayar di awal.
- Konfirmasi pesanan bukan bukti pembayaran.
- Admin mencatat pembayaran setelah menerima uang.
- Sistem menghitung total pembayaran dan uang kembalian.
- Status pembayaran dipisahkan dari status pesanan.
- Pesanan belum dibayar tidak dihitung sebagai penjualan terealisasi.
- Penjualan langsung mengurangi stok makanan matang yang tersedia.
- Penjualan langsung tidak mengurangi bahan baku.
- Penyelesaian pesanan online mengurangi stok matang sesuai jumlah yang diserahkan, bukan jumlah yang sekadar dipesan.
- Hindari pengurangan stok ganda ketika transaksi dicoba ulang.

QRIS, transfer otomatis, payment gateway, dan pengantaran tidak termasuk versi pertama.

---

## 15. Rekomendasi Struktur Database
Sesuaikan nama tabel dengan konvensi proyek yang sudah ada. Struktur berikut adalah konsep yang perlu tercakup:

| Tabel | Kegunaan |
| :--- | :--- |
| `users` | Akun pelanggan dan admin serta role. |
| `kategori_menu` | Kategori makanan. |
| `menu` | Nama, harga, kategori, foto, status, dan ketentuan penjualan kembali. |
| `bahan` | Bahan baku, satuan, stok, dan batas minimum. |
| `resep` | Kebutuhan bahan baku per porsi menu. |
| `pesanan` | Pemilik pesanan, tanggal pengambilan, status, dan waktu terkait. |
| `detail_pesanan` | Menu, jumlah, snapshot harga, dan subtotal. |
| `pengaturan_persiapan` | Waktu persiapan berdasarkan tanggal pengambilan. |
| `kuota_menu` | Kuota menu per tanggal. |
| `alokasi_pesanan` | Jumlah porsi yang dialokasikan dan statusnya. |
| `produksi` | Jumlah porsi yang diproduksi, pelaksana, dan waktu. |
| `stok_makanan_matang` | Stok matang, asal produksi, tanggal produksi, dan batas kelayakan. |
| `mutasi_stok_makanan_matang` | Mutasi produksi, penjualan, sisa, terbuang, kedaluwarsa, dan penyesuaian. |
| `mutasi_stok_bahan` | Penambahan, pemakaian produksi, penggunaan lain, dan penyesuaian bahan. |
| `transaksi` | Sumber transaksi, total, status pembayaran, dan informasi tunai. |
| `riwayat_status_pesanan` | Riwayat perubahan status dan alasan. |

Gunakan:
- Primary key dan foreign key yang sesuai.
- Index pada kolom yang sering digunakan untuk pencarian.
- Unique constraint untuk kombinasi data yang tidak boleh duplikat.
- Tipe decimal yang sesuai untuk nilai uang.
- Tanggal dan waktu yang sesuai untuk jadwal operasional.
- Snapshot harga pada detail pesanan agar perubahan harga menu tidak mengubah pesanan lama.

Rancang ERD dan relasi sebelum membangun logika bisnis yang kompleks.

---

## 16. Keamanan dan Integritas Data
Pastikan:
- Password menggunakan hashing Laravel.
- Query database menggunakan Eloquent atau parameter binding.
- Validasi dilakukan di server.
- Output yang berasal dari pengguna di-escape dengan benar.
- CSRF protection aktif.
- Hak akses diperiksa di server.
- Pelanggan tidak dapat membaca atau mengubah pesanan pelanggan lain.
- Harga dan total dihitung ulang di server.
- Stok, kuota, alokasi, role, dan status tidak dipercaya dari browser.
- Operasi yang mengubah banyak tabel menggunakan transaksi database.
- Transaksi bersamaan tidak dapat menjual stok atau kuota secara berlebihan.
- Pengiriman form berulang tidak mengakibatkan penjualan atau pengurangan stok ganda.
- Perubahan stok dan status memiliki riwayat audit.
- Kegagalan operasi membatalkan perubahan terkait.
- File `.env` tidak di-commit ke Git.
- `.env.example` tidak berisi password atau kredensial asli.

---

## 17. Kebutuhan Fungsional Utama

### Autentikasi
- Pelanggan dapat registrasi dan login.
- Admin dapat login dan mengakses dashboard.
- Role membatasi akses halaman dan tindakan.
- Password disimpan secara aman.

### Menu dan Resep
- Admin dapat mengelola menu dan kategori.
- Admin dapat mengatur harga, foto, dan status menu.
- Admin dapat mengelola resep per porsi.
- Katalog menampilkan ketersediaan berdasarkan tanggal.

### Pemesanan
- Pelanggan dapat melakukan checkout setelah login.
- Sistem memeriksa kuota.
- Admin dapat mengonfirmasi atau menolak pesanan.
- Sistem mencatat riwayat status.
- Sistem menerapkan aturan pembatalan.
- Sistem mengelola alokasi pesanan online.

### Produksi dan Persediaan
- Admin dapat mencatat bahan masuk.
- Admin dapat mencatat produksi.
- Sistem mengurangi bahan baku sesuai resep.
- Sistem menambah stok matang sesuai produksi.
- Sistem mencatat mutasi stok dan penggunaan non-penjualan.
- Sistem mencatat sisa makanan dan kedaluwarsa.

### Kasir dan Pembayaran
- Admin dapat melakukan penjualan langsung.
- Sistem hanya menjual stok matang yang tersedia untuk penjualan langsung.
- Sistem menghitung total dan kembalian.
- Admin mencatat pembayaran tunai.
- Sistem memisahkan transaksi belum lunas dari penjualan terealisasi.

### Laporan
- Laporan penjualan berdasarkan periode.
- Laporan penjualan online dan langsung.
- Laporan mutasi bahan baku dan makanan matang.
- Laporan makanan terbuang dan penyesuaian stok.
- Informasi pesanan belum dibayar dipisahkan dari penjualan terealisasi.

---

## 18. Pengujian Wajib
Buat automated tests untuk logika bisnis penting jika memungkinkan, lalu lakukan pengujian end-to-end.

Skenario minimal:
1. Pengunjung dapat melihat katalog tanpa login.
2. Pelanggan harus login untuk memesan.
3. Pelanggan tidak dapat mengakses pesanan pengguna lain.
4. Kuota 20 dengan 17 porsi terpakai menolak permintaan baru sebanyak 4 porsi.
5. Kuota penuh menampilkan “Pesanan penuh”.
6. Tanggal tanpa kuota menampilkan “Belum tersedia”.
7. Dua pemesanan bersamaan tidak dapat melampaui kuota.
8. Konfirmasi pesanan membuat alokasi.
9. Penjualan langsung tidak dapat menggunakan porsi yang dialokasikan.
10. Produksi mengurangi bahan baku sesuai resep.
11. Produksi menambah stok matang sesuai jumlah yang dicatat.
12. Produksi yang sama tidak dapat mengurangi bahan dua kali.
13. Penjualan langsung mengurangi stok matang, bukan bahan baku.
14. Pesanan online yang diselesaikan mengurangi stok matang satu kali.
15. Stok matang tidak pernah negatif.
16. Penolakan atau pembatalan melepaskan kuota dan alokasi tanpa menciptakan stok fisik.
17. Pesanan sarapan keesokan hari yang sudah dikonfirmasi tidak dapat dibatalkan pelanggan.
18. Pembatalan setelah persiapan dimulai ditolak oleh server.
19. Pesanan belum dibayar tidak masuk penjualan terealisasi.
20. Pembayaran hanya tercatat setelah uang diterima.
21. Sisa nasi dicatat sebagai makanan terbuang.
22. Makanan kedaluwarsa tidak dapat dijual.
23. Penyesuaian stok mencatat nilai sebelum dan sesudah, waktu, pelaksana, dan alasan.
24. Kegagalan database membatalkan seluruh perubahan dalam transaksi.
25. Dua transaksi kasir yang berebut porsi terakhir tidak dapat sama-sama menghabiskan porsi tersebut.

---

## 19. Urutan Implementasi
Bangun aplikasi secara bertahap dengan urutan berikut:

- **Tahap 1: Fondasi**
  - Periksa proyek Laravel dan konfigurasi MySQL.
  - Siapkan autentikasi dan role.
  - Buat migration dan model dasar.
  - Buat CRUD kategori, menu, bahan, dan resep.
  - Buat katalog menu.
- **Tahap 2: Produksi dan stok**
  - Buat pencatatan stok awal dan bahan masuk.
  - Buat mutasi bahan baku.
  - Buat pencatatan produksi.
  - Buat pengurangan bahan berdasarkan resep.
  - Buat stok makanan matang dan riwayat mutasinya.
- **Tahap 3: Pemesanan**
  - Buat keranjang dan checkout.
  - Buat kuota menu per tanggal.
  - Buat status dan riwayat pesanan.
  - Buat konfirmasi dan penolakan.
  - Buat alokasi pesanan online.
  - Buat pembatalan dan pengaturan persiapan.
- **Tahap 4: Kasir dan pembayaran**
  - Buat transaksi penjualan langsung.
  - Buat validasi stok tersedia untuk penjualan langsung.
  - Buat pembayaran tunai dan uang kembalian.
  - Buat penyelesaian pesanan online.
  - Pastikan tidak ada pengurangan stok ganda.
- **Tahap 5: Sisa makanan dan laporan**
  - Buat pencatatan sisa makanan.
  - Buat aturan kelayakan dan kedaluwarsa.
  - Buat penyesuaian stok.
  - Buat laporan penjualan dan mutasi stok.
- **Tahap 6: Pengujian dan dokumentasi**
  - Jalankan semua tes.
  - Uji skenario transaksi bersamaan.
  - Perbaiki bug dan inkonsistensi.
  - Buat README untuk instalasi dan penggunaan.
  - Pastikan aplikasi dapat dijalankan secara lokal tanpa langkah manual yang tidak terdokumentasi.

*Jangan melanjutkan ke tahap berikutnya sebelum tahap yang sedang dikerjakan sudah dapat diuji.*

---

## 20. Definition of Done
Versi pertama UduxPOS dinyatakan selesai jika:
- Aplikasi berjalan di localhost dan terhubung ke MySQL.
- Pelanggan dapat mendaftar, login, melihat menu, memesan, dan melihat riwayat.
- Admin dapat mengelola menu, resep, kuota, persiapan, produksi, persediaan, pesanan, penjualan langsung, dan pembayaran.
- Alokasi pesanan online melindungi pesanan yang telah dikonfirmasi dari penjualan langsung.
- Bahan baku hanya berkurang saat produksi dicatat.
- Stok matang tidak dapat bernilai negatif.
- Mutasi stok dan perubahan status dapat ditelusuri.
- Pesanan belum dibayar tidak masuk penjualan terealisasi.
- Pengujian utama berhasil.
- README menjelaskan konfigurasi, migrasi database, seeding, dan cara menjalankan aplikasi.

---

## 21. Instruksi Awal untuk Memulai Pengerjaan
Saat mulai bekerja pada repository UduxPOS:
1. Periksa struktur proyek dan versi Laravel.
2. Jangan langsung membuat ulang proyek.
3. Buat ringkasan kondisi proyek saat ini.
4. Bandingkan implementasi yang ada dengan skill ini.
5. Susun daftar pekerjaan berdasarkan prioritas.
6. Mulai dari fondasi yang belum tersedia.
7. Berikan perubahan dalam bagian kecil yang dapat diuji.
8. Setelah setiap bagian, jelaskan file yang berubah, perintah yang perlu dijalankan, dan cara memeriksa hasilnya.
9. Jangan mengklaim fitur selesai sebelum implementasi dan pengujiannya benar-benar dilakukan.