** Install Laravel
composer create-project laravel/laravel example-app
composer require laravel/breeze --dev

//Install Starter kit (use api)
php artisan breeze:install
php artisan migrate

//Tests
php artisan test --filter OrderControllerTest

** Stage 2 form submission and storing data on indexed DB
controller = WebformController - index
route = /web-form