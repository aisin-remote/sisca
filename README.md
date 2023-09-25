## How To Install 

1. Clone this GitHub repository:
    ```sh
    git clone https://github.com/Johuttt/Apar.git
    ```
2. Install Composer:
    ```sh
    composer install
    ```
3. Configuration .env:
    ```sh
    cp .env.example .env
    ```
4. Generate Application Key:
    ```sh
    php artisan key:generate
    ```
5. Database Migration:
    ```sh
    php artisan migrate
    ```
6. Run the App:
    ```sh
    php artisan serve
    ```
