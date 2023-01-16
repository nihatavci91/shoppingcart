1. Clone the project:
git clone https://github.com/emrebbozkurt/php-use-case.git

2. Starting the docker containers: 
   a) docker-compose -f docker-compose.yml build
   b) docker-compose -f docker-compose.yml up -d

3. Copy .env.example file and rename to .env

4. Install packages: composer install

5. Generate the application key:
   php artisan key:generate

6. php artisan migrate --seed

Usage :localhost

