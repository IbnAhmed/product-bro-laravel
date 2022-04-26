# Product Bro - Laravel

Its a simple CRUD application for `products` table. This application has JWT API authentication.

## Installation

1. Git clone the repo (which you've probably already done).
2. Create a MySQL DB - `CREATE DATABASE product_bro;`.
3. Copy `.env.example` to `.env` and customize it's database credential.
5. Install required vendor - `composer install` (Run it from the project root folder). 
5. Migrate all DB table - `php artisan migrate` (Run it from the project root folder).
6. Populate DB with some demo data - `php artisan db:seed`  (Run it from the project root folder).
7. Link with storage - `php artisan storage:link`
8. Run the project in local - `php artisan serve`. Base url will be `http://localhost:8000`.


## Demo User For Auth

Email: `admin.user@product-bro.com`<br>
Password: `password123`

## Postman Collection Instruction

1. You'll find the collection in root folder. Collection file name is `Product Bro.postman_collection.json`.
2. Import it into postman.
3. First open the `Auth\login` Request. And press the `Send` button, If you get success message then you're ready to check all the api request. You don't have to worry about token. After successfull login, token automatically assigned into collection's  global variable. 
4. You can change the `pb_base_url` variable from collection's `Edit` option

## Frontend Part

Frontend part made with REACT. Check here -> [https://github.com/IbnAhmed/product-bro-react](https://github.com/IbnAhmed/product-bro-react)