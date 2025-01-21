Proyek ini dibuat dalam rangka memenuhi Tugas Mata Kuliah **Pemrograman Web dan Mobile**. 

Proyek ini merupakan kolaborasi antara saya dan seorang teman, menggunakan *framework* **Flask** dan *bahasa pemrograman* **Dart**. 

## Database
Proyek ini menggunakan database dengan nama `db_quickshop.sql`. Untuk menjalankan proyek ini, Anda perlu mengimpor file SQL yang telah disediakan ke dalam sistem database Anda. 

## Cara Menggunakan
1. Unduh atau klon repositori ini.
2. Pastikan Anda memiliki server lokal seperti XAMPP atau MAMP yang mendukung PHP dan MySQL.

**Penjelasan Terkait klon repository dan penempatan file-file API**
Setelah Anda mengklon repositori, pastikan untuk menempatkan folder branch API ke dalam direktori htdocs jika Anda menggunakan XAMPP sebagai server lokal. Hal ini memastikan bahwa file API dapat diakses melalui server lokal Anda.
Langkah-langkah:
a. Klon repositori ini ke komputer Anda.
b. Buka direktori hasil kloning, lalu pindahkan folder branch API ke dalam direktori htdocs milik XAMPP (biasanya berada di C:\xampp\htdocs).
c. Jalankan XAMPP dan aktifkan modul Apache serta MySQL.
d. Akses file API melalui URL sesuai perangkat (contoh: http://localhost/[nama_folder_API] di Chrome atau http://10.0.2.2/[nama_folder_API] di Android Virtual Device).

3. Impor file SQL yang disediakan di folder database **pada branch API** (`db_quickshop.sql`) ke dalam database Anda.
4. Ubah konfigurasi koneksi database sesuai dengan pengaturan server lokal Anda di file konfigurasi PHP.
5. Proyek ini bisa dijalankan melalui **chrome**, **Android virtual device**, dan **Device android anda**.

Untuk menjalankan proyek ini, pastikan Anda menggunakan URL yang sesuai dengan perangkat yang digunakan untuk terhubung dengan file API:
- Android Virtual Device: Gunakan URL http://10.0.2.2 agar emulator dapat menyambung dengan file API.
- Browser Chrome: Gunakan URL http://localhost untuk menyambungkan aplikasi dengan file API di server lokal.
- Perangkat Android Fisik: Gunakan alamat IP dari perangkat Anda sendiri (contoh: http://192.168.x.x) agar aplikasi dapat terhubung dengan file API.

Pastikan Anda mengganti URL ini pada bagian konfigurasi http di dalam kode aplikasi sesuai kebutuhan.

Kami berharap proyek ini dapat menjadi referensi dan inspirasi bagi Anda dalam mengembangkan aplikasi mobile!

---

Terima kasih telah mengunjungi repositori ini.
