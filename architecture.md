# UduxPOS — System Architecture

## 1. Document Overview
- **Project Name:** UduxPOS
- **Application Type:** Web-based Ordering and Point of Sale (POS) System
- **Business Domain:** UMKM nasi uduk
- **Architecture Style:** Modular Monolith
- **Backend:** PHP dengan Laravel
- **Frontend:** Laravel Blade, HTML, CSS, Bootstrap, JavaScript
- **Database:** MySQL
- **Deployment Target:** Localhost untuk rilis pertama
- **Primary Language:** Bahasa Indonesia

### 1.1 Purpose
Dokumen ini menjelaskan arsitektur teknis UduxPOS sebagai acuan pengembangan aplikasi. Arsitektur harus mendukung:
- Pemesanan makanan online.
- Pengelolaan menu dan resep.
- Pengelolaan bahan baku.
- Pencatatan produksi.
- Pengelolaan stok makanan matang.
- Pengelolaan alokasi pesanan online.
- Penjualan langsung melalui POS.
- Pembayaran tunai saat pengambilan.
- Laporan penjualan dan persediaan.

Arsitektur dirancang agar mudah dipahami, diuji, dan dikembangkan oleh mahasiswa yang sedang mempelajari Laravel.

---

## 2. Architecture Principles

### 2.1 Modular Monolith
UduxPOS menggunakan pendekatan *modular monolith*. Seluruh modul berjalan dalam satu aplikasi Laravel dan menggunakan satu database MySQL, tetapi tanggung jawab masing-masing modul dipisahkan secara logis.
- Sesuai dengan skala UMKM.
- Lebih sederhana daripada *microservices*.
- Mudah dijalankan secara lokal.
- Mendukung transaksi database untuk menjaga konsistensi stok dan pesanan.
- Tidak membutuhkan infrastruktur tambahan pada versi pertama.

### 2.2 Single Source of Truth
Database menjadi sumber data utama untuk harga, status pesanan, stok, kuota, alokasi, dan pembayaran. Nilai yang dikirim dari browser tidak boleh langsung dipercaya untuk menentukan harga, total transaksi, stok, kuota, hak akses, atau status.

### 2.3 Data Integrity First
Ketepatan pencatatan stok lebih penting daripada sekadar mempercepat proses transaksi. Operasi yang mengubah beberapa data terkait harus menjaga konsistensi penuh (atomik).

### 2.4 Auditability
Mutasi stok dan perubahan status penting harus memiliki riwayat yang dapat ditelusuri. Jangan menghapus riwayat mutasi untuk memperbaiki kesalahan; gunakan transaksi koreksi atau penyesuaian yang disertai alasan.

---

## 3. High-Level System Architecture

```mermaid
flowchart TD
    Customer[Customer Browser]
    Admin[Admin Browser]
    Web[Laravel Web Application]
    Auth[Authentication and Authorization]
    Catalog[Menu and Catalog Module]
    Orders[Order Management Module]
    Inventory[Inventory Module]
    Production[Production Module]
    POS[Direct Sales POS Module]
    Payment[Payment Recording Module]
    Reports[Reporting Module]
    DB[(MySQL Database)]

    Customer --> Web
    Admin --> Web

    Web --> Auth
    Web --> Catalog
    Web --> Orders
    Web --> Inventory
    Web --> Production
    Web --> POS
    Web --> Payment
    Web --> Reports

    Auth --> DB
    Catalog --> DB
    Orders --> DB
    Inventory --> DB
    Production --> DB
    POS --> DB
    Payment --> DB
    Reports --> DB