## Installation step

1. cp .env.example .env
2. composer require doctrine/dbal
3. composer install
4. php artisan vendor:publish
5. php artisan migrate
6. php artisan db:seed
7. php artisan storage:link
8. php artisan serve

## to drop db & add it again
1. php artisan migrate:rollback
2. php artisan migrate:reset
3. php artisan migrate:fresh / php artisan migrate:fresh --seed
4. php artisan db:seed
