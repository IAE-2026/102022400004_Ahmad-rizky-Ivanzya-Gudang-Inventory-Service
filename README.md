# Inventory Service (Service A - Gudang Bahan Baku)
Tugas 2 Integrasi Aplikasi Enterprise (IAE)

## Identitas Mahasiswa
- **Nama:** Ahmad Rizky Ivanzya
- **NIM:** 102022400004
- **Mata Kuliah:** BBK2HAB3 - Integrasi Aplikasi Enterprise

## Deskripsi Service
Service ini bertugas untuk mengelola data komponen/bahan baku (Gudang Bahan Baku) menggunakan protokol komunikasi modern (REST API & GraphQL). Service ini dibangun mematuhi *Standard Integration Contract* (IAE-T2) sehingga siap untuk diintegrasikan dengan service milik anggota kelompok lainnya.

## Fungsionalitas Utama
Service ini memiliki fungsionalitas berikut:

1. **REST API (Minimum Viable API):**
   - `GET /api/v1/components` : Mengambil daftar seluruh komponen.
   - `GET /api/v1/components/{id}` : Mengambil data spesifik suatu komponen berdasarkan ID.
   - `POST /api/v1/components/receive` : Menambah stok untuk suatu komponen.
2. **GraphQL:**
   - Tersedia endpoint `query` untuk `components` dan `component` via GraphQL dengan kapabilitas seleksi field yang dinamis.
3. **Security:**
   - Seluruh endpoint (REST & GraphQL) dilindungi oleh Header Authentication menggunakan API Key (`X-IAE-KEY`).
4. **Interactive Documentation:**
   - Dokumentasi lengkap REST API dapat diakses melalui antarmuka interaktif Swagger UI.

## Cara Menjalankan Project (Docker)
Proyek ini sudah di-dockerize menggunakan Docker Compose. Ikuti langkah berikut untuk menjalankannya:

1. Buat file `.env` (bisa di-copy dari `.env.example`) dan pastikan konfigurasi `API_KEY` menggunakan NIM.
   ```env
   API_KEY=102022400004
   ```
2. Jalankan perintah docker compose:
   ```bash
   docker-compose up -d --build
   ```
3. Lakukan instalasi dependency dan migrasi database:
   ```bash
   docker-compose exec app composer install
   docker-compose exec app php artisan migrate --seed
   ```
4. Generate dokumentasi Swagger:
   ```bash
   docker-compose exec app php artisan l5-swagger:generate
   ```

## Akses Pengujian
- **Swagger UI:** `http://localhost:8000/docs` (juga dialihkan dari `/api/documentation`)
- **GraphQL Playground:** `http://localhost:8000/graphql-playground` (atau `/playground`)
