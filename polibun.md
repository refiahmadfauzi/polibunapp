Halo! Saya sudah melihat file PDF yang Anda unggah. Gambar *mindmap* di dalamnya cukup buram sehingga teks detail pada kotak-kotak kecilnya tidak terbaca oleh saya. Namun, saya bisa menangkap tiga modul utama dari arsitektur aplikasi Anda: **RBAC / Root Admin**, **Accounting**, dan **Doctor & Bidan**.

Saya juga melihat ada tautan Whimsical di dokumen tersebut. Karena Antigravity (atau AI *coding assistant* sejenis) membutuhkan instruksi yang spesifik mengenai *database* dan antarmuka, Anda perlu menambahkan detail dari bagan tersebut ke dalam *prompt*.

Berikut adalah *template prompt* terstruktur yang bisa Anda salin, lengkapi, dan gunakan di Antigravity untuk membangun aplikasi menggunakan Laravel Filament:

---

**Prompt untuk Antigravity:**

> "Tolong buatkan kode dasar untuk aplikasi *web-based* bernama 'Polibun App' menggunakan **Laravel 11** dan **Filament PHP v3**.
> Aplikasi ini adalah sistem manajemen klinik/poliklinik yang terdiri dari 3 modul utama. Tolong buatkan *Migration*, *Model* (dengan relasinya), dan *Filament Resource* lengkap (List, Create, Edit, View) untuk entitas-entitas berikut:
> **1. Modul Root Admin & RBAC (Role-Based Access Control):**
> * Instal dan konfigurasikan *package* `spatie/laravel-permission` yang terintegrasi dengan Filament plugin (seperti `filament/shield`).
> * Buatkan manajemen untuk entitas: **User**, **Role**, dan **Permission**.
> 
> 
> **2. Modul Doctor & Bidan (Layanan Medis):**
> * Buatkan entitas untuk: **[Tuliskan daftar kotak hijau di *mindmap* Anda di sini. Contoh: Pasien, Dokter, Bidan, Jadwal Praktik, Rekam Medis / Pemeriksaan]**.
> * Buatkan relasi antar modelnya (misalnya: Rekam Medis *belongsTo* Pasien dan Dokter).
> 
> 
> **3. Modul Accounting (Keuangan):**
> * Buatkan entitas untuk: **[Tuliskan daftar kotak biru di *mindmap* Anda di sini. Contoh: Kategori Transaksi, Pemasukan, Pengeluaran, Invoice, Tagihan Pasien]**.
> * Buatkan Filament *Widget* sederhana di *Dashboard* untuk menampilkan ringkasan Pemasukan dan Pengeluaran.
> 
> 
> **Instruksi Tambahan:**
> * Gunakan *Form Builder* Filament yang rapi (gunakan *Grid*, *Section*) untuk setiap form *Create/Edit*.
> * Gunakan *Table Builder* dengan fitur *Search*, *Filter*, dan *Pagination* pada setiap halaman *List*.
> * Terapkan *Group Navigation* di menu samping (Sidebar) berdasarkan 3 modul di atas."
> 
> 

---

**Tips Tambahan:**
Karena gambar di PDF sangat buram, sangat disarankan Anda membuka *link* Whimsical Anda  dan menyalin nama-nama tabel/menu dari sana untuk menggantikan bagian di dalam kurung siku `[...]` pada *prompt* di atas. AI pembuat kode akan bekerja jauh lebih akurat jika ia tahu persis nama-nama tabel yang Anda butuhkan.

Apakah Anda memiliki daftar teks atau tabel detail dari bagian **Doctor & Bidan** agar saya bisa membantu meracik *prompt* relasi *database*-nya menjadi lebih spesifik?