
## Install

1. git clone https://github.com/kinsly/spot-test.git
2. composer install
3. npm install cypress --save-dev
4. Configure .env
5. php artisan migrate
6. php artisan serve

## Tests

### orderController (backend testing)
php artisan test --filter OrderControllerTest

### Webform data with IndexedDB (front-end testing)
npx cypress open
run cypress/e2e/webform.cy.js

# Stage 2: Form submission and storing data on indexed DB

1. controller : WebformController - index
2. route = /web-form
3. url: http://127.0.0.1:8000/web-form
4. source: resources/webform.blade.php

## Suggestion to face high demand for API requests

We can use Laravel built in Queue system.

1. First configue queue connection (ex: redis)

2. Next create a job using artisan command and add logic to store orders.

3. In the OrderController 'store' method, pass data received from api request to created job.

4. high demand api requests will nicely handle based on max parallel requests configured.

5. Integrate horizon to see all jobs in the queue.

# For Postman

## Register
1. Post Request: http://localhost:8000/register
2. Accept - application/json
3. Referer - http://localhost:3000
4. X-CSRF-TOKEN - (via a get request to http://localhost:8000)
5. Body: name:John
email:john@gmail.com
password:12345678
password_confirmation:12345678

## login
1. Post Request: http://localhost:8000/login
2. Accept - application/json
3. Referer - http://localhost:3000
4. X-CSRF-TOKEN - (via a get request to http://localhost:8000)
5. Body: email:john@gmail.com
password:12345678

## Create new order
1. Post request: http://localhost:8000/api/orders
2. Accept - application/json
3. Referer - http://localhost:3000
4. X-CSRF-TOKEN - (via a get request to http://localhost:8000)
5. body: customer_name:John
			value:250.00
			
## View orders
1. Get request: http://localhost:8000/api/orders
2. Accept - application/json
3. Referer - http://localhost:3000
4. X-CSRF-TOKEN - (via a get request to http://localhost:8000)