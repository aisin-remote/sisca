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
4. change FILESYSTEM_DISK from 'local' to 'public' in the .env file:
   ```sh
    FILESYSTEM_DISK=public
    ```
5. To create the symbolic link, you may use the storage:link Artisan command:
   ```sh
    php artisan storage:link
    ```
6. Generate Application Key:
    ```sh
    php artisan key:generate
   ```
7. Database Migration:
    ```sh
    php artisan migrate
    ```
8. Run the App:
    ```sh
    php artisan serve
    ```
