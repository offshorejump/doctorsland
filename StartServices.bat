color 0a
d:
cd\xampp\htdocs\doctrosland
cls
#composer update
php artisan migrate:refresh --seed
php artisan serve
