# Laporan Progres Aplikasi FlipPlay

## Ringkasan

FlipPlay adalah prototipe aplikasi hiburan digital berbasis web. Antarmuka menawarkan satu tempat untuk melihat layanan anime, drama, manga, dan light novel, serta halaman paket berlangganan. Proyek saat ini sudah berada pada tahap **prototipe front-end interaktif**; belum menjadi layanan streaming atau sistem langganan yang siap digunakan secara nyata.

## Fitur yang Sudah Dibuat

- Halaman beranda dengan navigasi ke bagian Beranda, Layanan, Kontak, dan Premium.
- Tampilan responsif dengan Tailwind CSS dan menu navigasi untuk layar kecil.
- Bagian pengenalan layanan Anime, Drama, Manga, dan Light Novel.
- Katalog The Vibe Grid untuk anime, film/series drama, manga, dan light novel, dilengkapi pencarian, filter kategori, tema, dan Aura.
- Halaman Premium dengan tiga pilihan paket: Biasa, Pro, dan Premium.
- Formulir checkout yang meminta nama, email, dan metode pembayaran.
- Interaksi pemilihan paket yang menampilkan paket dan harga terpilih.
- Validasi dasar formulir checkout serta pesan status setelah simulasi dikirim.
- Formulir kontak yang menampilkan notifikasi saat tombol kirim ditekan.

## Status Tiap Bagian

| Bagian                       | Status                    | Catatan                                                                       |
| ---------------------------- | ------------------------- | ----------------------------------------------------------------------------- |
| Antarmuka beranda            | Selesai untuk demo        | Berisi hero, navigasi, daftar layanan, kontak, dan footer.                    |
| Katalog The Vibe Grid        | Berfungsi dengan fallback | Anime menggunakan Jikan API saat tersedia; drama, manga, light novel, dan fallback anime adalah data contoh lokal. |
| Halaman Premium              | Selesai untuk demo        | Paket dan alur pemilihan tersedia di `node_modules/src/premium.html`.         |
| Desain responsif             | Diimplementasikan         | Menggunakan kelas Tailwind dan menu mobile berbasis JavaScript.               |
| Pemilihan paket              | Berfungsi di sisi browser | Nama dan harga paket ditampilkan pada formulir checkout.                      |
| Pengiriman formulir kontak   | Simulasi                  | Tombol hanya memunculkan alert; pesan tidak dikirim atau disimpan.            |
| Pembayaran                   | Simulasi                  | Tidak ada transaksi, tagihan, atau integrasi payment gateway.                 |
| Streaming dan membaca konten | Belum diimplementasikan   | Belum ada pemutar video, pembaca manga/novel, atau katalog konten sebenarnya. |
| Akun dan penyimpanan data    | Belum diimplementasikan   | Belum terlihat autentikasi, backend, atau database pada proyek ini.           |

## Berkas Aplikasi

- `node_modules/src/index.html`: halaman utama FlipPlay.
- `node_modules/src/script.js`: interaksi halaman, katalog anime, pencarian, dan filter Aura.
- `node_modules/src/premium.html`: halaman pilihan paket dan simulasi checkout.
- `node_modules/src/main.css`: sumber konfigurasi Tailwind CSS dan warna tema.
- `node_modules/src/output.css`: stylesheet hasil build yang digunakan halaman.
- `dev-server.js`: server development statis untuk menyajikan halaman FlipPlay.
- `node_modules/src/Asta.jpg` dan `node_modules/src/Soundtrack #1 (2022) _ 사운드트랙#1.jpg`: aset gambar untuk kartu Anime dan Drama.

Kartu Manga dan Light Novel saat ini masih menggunakan blok warna dan teks placeholder, bukan gambar konten.

## Menjalankan Proyek

Jalankan perintah berikut dari folder proyek:

```sh
npm run dev
```

Buka `http://127.0.0.1:4173` di browser. Untuk membangun ulang stylesheet Tailwind setelah mengubah HTML atau CSS, jalankan:

```sh
npm run build:css
```

The Vibe Grid memuat anime dari Jikan API saat tersedia, serta menampilkan contoh katalog drama, manga, dan light novel yang didefinisikan lokal di `node_modules/src/script.js`. Jika Jikan tidak dapat dijangkau, katalog anime contoh lokal juga ditampilkan. Data contoh bukan API live dan tidak otomatis diperbarui. Tombol **Coba ambil data Jikan lagi** mencoba kembali mengambil data anime terbaru.

Filter kategori dan tema bekerja bersama pencarian judul; filter Aura Action, Drama, dan Comedy juga dapat digabungkan dengan filter lainnya. Jikan API adalah sumber metadata anime. Supabase bukan pengganti langsung untuk Jikan: Supabase menyediakan database dan layanan backend, sehingga berguna bila katalog perlu disimpan atau dikelola sendiri, tetapi datanya tetap harus diisi atau disinkronkan dari sumber metadata yang sesuai.

## Tahap Pengerjaan Saat Ini

1. **Konsep dan tampilan:** sudah dibuat untuk beranda dan halaman Premium.
2. **Interaksi front-end:** sebagian sudah dibuat untuk menu mobile, katalog anime, pemilihan paket, validasi formulir, dan pesan simulasi.
3. **Layanan nyata:** belum dimulai atau belum tersedia di berkas proyek yang diperiksa. Backend, database, akun pengguna, katalog konten, pengiriman pesan, dan pembayaran sungguhan masih diperlukan.

## Langkah Lanjutan yang Disarankan

1. Pindahkan berkas aplikasi keluar dari `node_modules` ke folder proyek seperti `src/`; `node_modules` sebaiknya hanya berisi dependensi terpasang.
2. Tentukan backend dan database untuk akun, katalog, paket, dan penyimpanan pesan.
3. Integrasikan layanan pembayaran dalam lingkungan uji sebelum menerima transaksi nyata.
4. Tambahkan konten berlisensi dan implementasi pemutar atau pembaca konten.
5. Uji tampilan dan interaksi pada perangkat desktop maupun mobile.

## Kesimpulan

FlipPlay telah memiliki fondasi visual dan alur demo untuk promosi layanan serta pemilihan paket. Progresnya paling tepat disebut **front-end prototipe**, belum aplikasi produksi: fungsi inti seperti streaming, akun, penyimpanan data, pengiriman kontak, dan pembayaran nyata belum tersedia.
