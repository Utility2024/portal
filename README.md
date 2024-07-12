# Web Portal

Ini adalah proyek Portal yang dibangun menggunakan Laravel dan Filament.

## Persyaratan

Sebelum Anda mulai, pastikan sistem Anda memiliki persyaratan berikut:

- PHP >= 7.4
- Composer
- MySQL atau database lain yang didukung oleh Laravel
- Node.js dan NPM (opsional, jika Anda ingin menjalankan dan mengkompilasi aset front-end)

## Instalasi

Ikuti langkah-langkah berikut untuk meng-clone dan menginstal proyek ini di mesin lokal Anda.

1. **Clone Repository**

   Clone repository ini ke mesin lokal Anda menggunakan perintah berikut:

   ```bash
   git clone https://github.com/Utility2024/portal.git
2. **Masuk ke Direktori Proyek**

    Pindah ke direktori proyek yang baru saja Anda clone:
   
    ```bash
    cd portal
    
3. **Instal Dependensi**

    Jalankan perintah berikut untuk menginstal semua dependensi PHP menggunakan Composer:

    ```bash
    composer update
    
4. **Salin File Konfigurasi .env**

    Salin file .env.example menjadi .env:

    ```bash
    cp .env.example .env
    
5. **Generate Application Key**

    Generate application key Laravel dengan perintah berikut:

    ```bash
    php artisan key:generate
    Konfigurasi Database

6. **Buka file .env dan atur konfigurasi database Anda. Sesuaikan DB_DATABASE, DB_USERNAME, dan DB_PASSWORD sesuai dengan konfigurasi database lokal Anda**

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=user_database_anda
    DB_PASSWORD=password_database_anda
    
7. **Migrasi dan Seed Database**

    Jalankan migrasi database dan seed data awal dengan perintah berikut:

    ```bash
    php artisan migrate --seed

8. **Menjalankan Server**
    Setelah semua langkah instalasi selesai, Anda bisa menjalankan server pengembangan Laravel dengan perintah berikut:
    
    ```bash
    php artisan serve
    
    Aplikasi Anda sekarang dapat diakses di http://localhost:8000
   
