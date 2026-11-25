# FlipPlay REST API — Modul 4 (Laravel 12)

Backend REST API untuk platform katalog hiburan digital **FlipPlay** (Anime & Manga) menggunakan **Laravel 12**, **Eloquent ORM (Many-to-Many)**, **Form Request Validation**, dan **API Resources**.

## Persiapan & Menjalankan Proyek

```bash
cd flipplay-api
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Server akan berjalan di `http://127.0.0.1:8000`.

## Daftar Endpoint REST API

### 1. Media CRUD (`/api/media`)
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/media` | Daftar seluruh media (mendukung `?search=` & pagination 10 item) |
| `GET` | `/api/media/{media}` | Detail satu media beserta relasi `users` yang menyimpannya |
| `POST` | `/api/media` | Tambah media baru (`201 Created`, validasi `StoreMediaRequest`) |
| `PATCH` / `PUT` | `/api/media/{media}` | Update sebagian/seluruh data media |
| `DELETE` | `/api/media/{media}` | Hapus data media dari katalog |

### 2. Custom Action Koleksi User (`/api/users/{user}/collection`)
| Method | Endpoint | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/users/{user}/collection` | Menampilkan profil user beserta daftar koleksi medianya |
| `POST` | `/api/users/{user}/collection` | Menambahkan `media_id` ke koleksi user (`409 Conflict` jika duplikat) |
| `DELETE` | `/api/users/{user}/collection/{media}` | Menghapus media dari koleksi user (`404 Not Found` jika tidak ada) |

## Pengujian Otomatis & Postman
- **Automated Feature Test (PHPUnit):**
  ```bash
  php artisan test
  ```
- **Koleksi Postman:**
  Impor file `postman/FlipPlay-API.postman_collection.json` ke dalam aplikasi Postman untuk menguji seluruh skenario **Happy Path** dan **Failure Path** (`422`, `409`, `404`).
