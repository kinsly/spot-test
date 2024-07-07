** Install Laravel
composer create-project laravel/laravel example-app
composer require laravel/breeze --dev

** Install Starter kit (use api)
php artisan breeze:install
php artisan migrate

** Tests
php artisan test --filter OrderControllerTest

** Stage 2: Form submission and storing data on indexed DB

controller = WebformController - index
route = /web-form
http://127.0.0.1:8000/web-form

** Suggestion to face high demand for API requests
We can use Laravel built in Queue system. 
1. First configue queue connection (ex: redis)
2. Next create a job using artisan command and add logic to store orders.
3. In the OderController 'store' method, pass data received from api request to created job.
4. high demand api requests will nicely handle based on max parallel requests configured.
5. Integrate horizon to see all jobs in the queue. 
