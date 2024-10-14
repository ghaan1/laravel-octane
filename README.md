Berikut adalah panduan instalasi Dashboard Admin Stater Pack : 

  

#  Panduan Instalasi Dashboard Admin Stater Pack : 


Panduan ini akan membantu Anda dalam langkah-langkah instalasi proyek Laravel untuk Santrilink. Kami akan membahas proses cloning proyek, menjalankan `composer install`, pengaturan variabel lingkungan, dan langkah-langkah lainnya.

  

##  Prasyarat

  

Sebelum memulai, pastikan Anda telah menginstal hal-hal berikut di komputer Anda:

  

-  PHP >= 8.2

-  Composer

-  Git

  

##  Langkah 1: Clone Repositori

  

Pertama, clone repositori ke komputer Anda menggunakan Git.

  

```bash

git  clone  https://gitlab.com/alfalaah404/dashboard-starter-pack.git

cd  dashboard-starter-pack

```

  

##  Langkah 2: Instalasi Dependencies

  

Selanjutnya, instal dependencies proyek menggunakan Composer.

  

```bash

composer  install

```

  

##  Langkah 3: Buat File Lingkungan

  

Buat salinan file `.env.example` dan ubah namanya menjadi `.env`.

  

```bash

cp  .env.example  .env

```

  

##  Langkah 4: Generate Application Key

  

Generate kunci aplikasi. Langkah ini sangat penting untuk keamanan aplikasi Anda.

  

```bash

php  artisan  key:generate

```

  

##  Langkah 5: Atur Variabel Lingkungan

  

Buka file `.env` dan atur variabel lingkungan seperti detail koneksi database. Berikut contohnya:

  

```env

APP_NAME=Laravel

APP_ENV=local

APP_KEY=

APP_DEBUG=true

APP_TIMEZONE="Asia/Jakarta"

APP_URL=http://localhost

  

APP_LOCALE=en

APP_FALLBACK_LOCALE=en

APP_FAKER_LOCALE=en_US

  

APP_MAINTENANCE_DRIVER=file

APP_MAINTENANCE_STORE=database

  

BCRYPT_ROUNDS=12

  

LOG_CHANNEL=stack

LOG_STACK=single

LOG_DEPRECATIONS_CHANNEL=null

LOG_LEVEL=debug

  

DB_CONNECTION=mysql

# DB_HOST=127.0.0.1

# DB_PORT=3306

# DB_DATABASE=laravel

# DB_USERNAME=root

# DB_PASSWORD=

  

SESSION_DRIVER=database

SESSION_LIFETIME=120

SESSION_ENCRYPT=false

SESSION_PATH=/

SESSION_DOMAIN=null

  

BROADCAST_CONNECTION=log

FILESYSTEM_DISK=local

QUEUE_CONNECTION=database

  

CACHE_STORE=database

CACHE_PREFIX=

  

MEMCACHED_HOST=127.0.0.1

  

REDIS_CLIENT=phpredis

REDIS_HOST=127.0.0.1

REDIS_PASSWORD=null

REDIS_PORT=6379

  

MAIL_MAILER=log

MAIL_HOST=127.0.0.1

MAIL_PORT=2525

MAIL_USERNAME=null

MAIL_PASSWORD=null

MAIL_ENCRYPTION=null

MAIL_FROM_ADDRESS="hello@example.com"

MAIL_FROM_NAME="${APP_NAME}"

  

AWS_ACCESS_KEY_ID=

AWS_SECRET_ACCESS_KEY=

AWS_DEFAULT_REGION=us-east-1

AWS_BUCKET=

AWS_USE_PATH_STYLE_ENDPOINT=false

  

VITE_APP_NAME="${APP_NAME}"

```

  

<div  style="border: 2px solid red; padding: 10px; background-color: #ffe6e6;">

<strong  style="color:red;">**Pastikan untuk memasukkan nilai yang sesuai untuk setiap variabel, terutama koneksi database yang sesuai dengan pengaturan yang benar untuk environment Anda.**</strong>

</div>

  

##  Langkah 6: Jalankan Migrasi dan Seeding Database

  

Jalankan migrasi database untuk membuat tabel-tabel yang diperlukan.

  

```bash

php  artisan  migrate  --seed

```

  

Jika Anda ingin memulai dengan database yang benar-benar bersih, Anda dapat menggunakan perintah berikut:

  

```bash

php  artisan  migrate:fresh  --seed

```

  

##  Langkah 7: Buat Symlink ke Folder Publik

  

Jalankan perintah berikut untuk membuat symlink ke folder public. Langkah ini penting agar file-file yang diunggah dapat diakses secara publik.

  

```bash

php  artisan  storage:link

```

  

##  Langkah 8: Optimalkan Cache Aplikasi

  

Untuk membersihkan cache dan mengoptimalkan aplikasi Anda, jalankan perintah berikut:

  

```bash

php  artisan  optimize:clear

```

  

##  Langkah 9: Jalankan Aplikasi

  

Terakhir, jalankan server pengembangan.

  

```bash

php  artisan  serve

```

  

Aplikasi Anda sekarang dapat diakses pada [http://localhost:8000](http://localhost:8000).

  


##  Troubleshooting

  

Jika Anda mengalami masalah selama proses instalasi, pertimbangkan langkah-langkah berikut:

  

-  Periksa versi PHP dan pastikan memenuhi persyaratan minimum.

-  Pastikan semua ekstensi PHP yang diperlukan terinstal dan diaktifkan.

-  Verifikasi kredensial database di file `.env` sudah benar.

-  Periksa dokumentasi Laravel [di sini](https://laravel.com/docs) untuk panduan tambahan.

  

##  Lisensi

  

Proyek ini adalah perangkat lunak sumber tertutup yang dilisensikan di bawah lisensi pribadi. Penggunaan dan distribusi aplikasi ini harus sesuai dengan ketentuan yang telah ditetapkan oleh Santrilink. Untuk informasi lebih lanjut, silakan hubungi tim pengembang [CV Teknologi Sunan Drajat](#https://teknologisunandrajat.com/).