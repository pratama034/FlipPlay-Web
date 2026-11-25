# Dokumentasi Rencana Redesign UI/UX

## Tujuan

Dokumen ini menjadi panduan untuk memperbarui tampilan dan pengalaman pengguna website tanpa mengubah struktur halaman, urutan section, navigasi utama, maupun fungsi yang sudah berjalan.

Fokus redesign adalah membuat antarmuka lebih rapi, konsisten, mudah dibaca, responsif, dan nyaman digunakan.

## Batasan Perubahan

Perubahan yang **boleh dilakukan**:

- Mengganti palet warna.
- Mengubah font, ukuran teks, ketebalan, dan tinggi baris.
- Merapikan jarak (`margin`, `padding`, dan `gap`).
- Memperbarui bentuk komponen, seperti tombol, input, kartu, dan badge.
- Menambahkan state interaksi: `hover`, `focus`, `active`, `disabled`, dan `loading`.
- Memperbaiki tampilan pada layar mobile dan tablet.
- Menambah ikon atau ilustrasi pendukung jika tidak menggeser struktur konten.

Perubahan yang **tidak dilakukan**:

- Memindahkan atau menghapus section halaman yang sudah ada.
- Mengubah urutan konten utama.
- Mengganti alur navigasi atau fungsi bisnis.
- Menambah halaman baru tanpa kebutuhan yang jelas.
- Mengubah struktur HTML secara besar-besaran hanya demi tampilan.

## Prinsip Desain

1. **Konsisten** — elemen dengan fungsi yang sama harus memiliki gaya yang sama.
2. **Jelas** — pengguna harus dapat mengenali judul, tombol utama, informasi penting, dan status form dengan cepat.
3. **Ringkas** — hindari warna, font, ukuran, dan efek visual yang terlalu banyak.
4. **Responsif** — tampilan harus tetap nyaman dari mobile hingga desktop.
5. **Aksesibel** — teks mudah dibaca, fokus keyboard terlihat, dan warna memiliki kontras yang cukup.

## Sistem Visual yang Disarankan

### Warna

Tentukan variabel warna agar konsisten dan mudah diganti.

```css
:root {
  --color-primary: #2563eb;
  --color-primary-hover: #1d4ed8;
  --color-accent: #f59e0b;
  --color-background: #f8fafc;
  --color-surface: #ffffff;
  --color-text: #1e293b;
  --color-text-muted: #64748b;
  --color-border: #e2e8f0;
  --color-success: #16a34a;
  --color-danger: #dc2626;
}
```

Gunakan warna utama untuk aksi penting, warna aksen secara terbatas, dan warna netral untuk latar, garis, serta teks pendukung.

### Tipografi

- Gunakan maksimal dua keluarga font: satu untuk seluruh antarmuka, satu opsional untuk judul.
- Gunakan skala teks yang stabil: `h1`, `h2`, `h3`, isi, label, dan teks kecil.
- Gunakan tinggi baris sekitar `1.5` hingga `1.7` untuk teks isi.
- Hindari lebih dari tiga ketebalan font dalam satu halaman.

Contoh skala:

| Elemen | Ukuran desktop | Ukuran mobile | Ketebalan |
| --- | ---: | ---: | --- |
| Judul utama | 32–40 px | 28–32 px | 700 |
| Judul section | 24–28 px | 22–24 px | 600 |
| Isi | 16 px | 16 px | 400 |
| Label / bantuan | 12–14 px | 12–14 px | 500 |

### Spacing dan Sudut

Gunakan kelipatan `4 px` atau `8 px` untuk menjaga ritme visual:

| Kebutuhan | Nilai yang disarankan |
| --- | --- |
| Jarak rapat | 8 px |
| Jarak antar elemen | 16 px |
| Jarak antar kelompok | 24 px |
| Jarak antar section | 48–64 px |
| Radius input / tombol | 8–12 px |
| Radius kartu | 12–16 px |

## Panduan Per Komponen

### Navigasi

- Pertahankan posisi dan item navigasi yang sekarang.
- Jadikan halaman aktif mudah dikenali melalui warna, garis bawah, atau font yang lebih tegas.
- Pastikan item dapat digunakan dengan keyboard dan memiliki state `focus`.

### Tombol

- Bedakan tombol utama, sekunder, dan tindakan berisiko.
- Tombol utama menggunakan warna `primary`; tombol sekunder menggunakan outline atau latar netral.
- Gunakan tinggi tombol yang konsisten, idealnya minimal `40–44 px`.
- Jangan gunakan lebih dari satu tombol utama yang bersaing dalam satu area.

### Form dan Input

- Letakkan label di atas input agar mudah dipindai.
- Gunakan placeholder sebagai contoh, bukan pengganti label.
- Tampilkan pesan error tepat di bawah input terkait.
- Bedakan state normal, focus, valid, error, dan disabled secara jelas.

### Kartu dan Daftar Konten

- Pertahankan posisi kartu atau daftar yang ada.
- Gunakan latar putih, border halus, radius konsisten, dan bayangan ringan bila diperlukan.
- Beri ruang internal yang cukup agar isi tidak terasa padat.
- Pastikan judul, metadata, dan aksi memiliki urutan visual yang jelas.

### Gambar dan Ikon

- Gunakan rasio gambar yang konsisten pada jenis konten yang sama.
- Pilih satu gaya ikon saja: outline atau solid.
- Tambahkan `alt` pada gambar informatif.
- Jangan gunakan gambar dekoratif yang mengurangi keterbacaan konten.

## State Interaksi yang Wajib

Setiap elemen interaktif perlu memiliki state berikut:

| State | Tujuan |
| --- | --- |
| Normal | Tampilan awal elemen |
| Hover | Memberi respons saat pointer diarahkan |
| Focus | Menunjukkan elemen aktif saat memakai keyboard |
| Active | Menunjukkan aksi sedang ditekan / dipilih |
| Disabled | Menjelaskan bahwa aksi belum tersedia |
| Loading | Mencegah klik berulang saat proses berjalan |
| Error | Menjelaskan masalah dan cara memperbaikinya |

## Prioritas Implementasi

1. Audit setiap halaman dan catat warna, font, ukuran, spacing, dan komponen yang belum konsisten.
2. Buat variabel warna, tipografi, spacing, border, dan shadow di stylesheet utama.
3. Terapkan sistem visual terlebih dahulu pada tombol, input, dan navigasi.
4. Rapikan kartu, tabel, daftar, dan section tanpa mengubah posisi maupun urutannya.
5. Uji responsif pada lebar sekitar 360 px, 768 px, 1024 px, dan 1440 px.
6. Uji alur utama: navigasi, pengisian form, validasi, tombol aksi, dan tampilan error.
7. Periksa kontras warna dan penggunaan keyboard sebelum desain dianggap selesai.

## Checklist Sebelum Selesai

- [ ] Struktur dan urutan section tidak berubah.
- [ ] Semua tombol sejenis terlihat dan berperilaku konsisten.
- [ ] Semua input memiliki label dan pesan error yang jelas.
- [ ] Teks tetap terbaca dengan nyaman di mobile.
- [ ] Tidak ada warna teks yang sulit dibaca di atas latar belakangnya.
- [ ] Fokus keyboard terlihat pada tombol, link, dan input.
- [ ] Tampilan desktop, tablet, dan mobile telah diperiksa.
- [ ] Fungsi yang sudah ada tetap berjalan setelah perubahan CSS/UI.

## Catatan Pengembangan Berikutnya

Mulailah dari perubahan visual yang paling berdampak: warna, tipografi, spacing, dan komponen dasar. Setelah itu, uji dengan pengguna atau teman sekelas untuk menemukan bagian yang membingungkan. Catat temuan tersebut dan perbaiki secara bertahap, bukan dengan mengubah seluruh tampilan sekaligus.
