## How To Install 

1. Clone this GitHub repository:
    ```sh
    git clone https://github.com/Johuttt/Apar.git
    ```
2. Install Composer:
    ```sh
    composer install
    ```
3. Konfigurasi .env:
    ```sh
    cp .env.example .env
    ```
4. Generate Key Aplikasi
    ```sh
    php artisan key:generate
    ```
5. Migrasi Database:
    ```sh
    php artisan migrate
    ```
6. Jalankan Aplikasi:
    ```sh
    php artisan serve
    ```
