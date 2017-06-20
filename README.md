<div align="center">
    <h1>Try my guitar</h1>
    A platform that brings guitar players together.
</div>

## Installation
### Essential
* Clone the project
* cd into the project directory
* Run "composer install"
* Run "npm install"
* Copy the example environment file: "cp .env.example .env"
* Edit the .env (DB settings are essential to get the project running)
* Run "php artisan key:generate"
* Run "php artisan migrate --seed"
* Run "npm run dev"
* Run "php artisan serve" to start the built-in webserver

### With working chat and maps
* Edit the following in the env file:
    * Change "Broadcast driver" to "pusher"
    * Enter your pusher credentials in the "pusher" section
    * Enter your google api credentials in the "google" section
