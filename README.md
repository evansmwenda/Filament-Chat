# Laravel-Chat-System

This chat system has been developed using filament php

Steps to run project

## Backend

1. Git clone `git clone <project-url>`

2. Navigate to the project root and run composer install `composer install`

3. Copy .env.example to .env `cp .env.example .env`

4. Update .env and set your database credentials

5. Generate laravel Key `php artisan key:generate`

6. Run migrations and seeder `php artisan migrate --seed`

7. Run `php artisan serve` and navigate to `http://localhost:8000` to confirm the page is being served


## Frontend

1. Set up project's front end dependencies `npm install`

2. Run `npm run dev` to compile assets


## RealTime Updates

1. Run this command to start the local web sockets server  `php artisan websockets:serve`

2. Navigate to `http://localhost:8000/laravel-websockets` ,set port as `6001`

3. Click the connect button on the interface. If successful, you should get a `Channels current state is connected`

4. Start the queue worker to process jobs `php artisan queue:work`


## Dashboard

1. Navigate to `http://localhost:8000/admin` to access the admin panel using the credentials below

email: `admin@gmail.com`
password: `password`

2. Navigate to `http://localhost:8000/admin/users` to send a message to a user