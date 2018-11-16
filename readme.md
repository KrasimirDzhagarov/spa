

## SPA Project with Laravel 5.6 and vue.js 2 framework

This is simple example of using laravel + vue js  framework to build SPA.
The project use laravel passport to authenticate.


#### Frameworks and libraries
  
   - Laravel 5.6
   - Vue js 2
   - Vuex
   - Vue Router
   - Vee-validate
   - sweetalert2
    
   
#### App provides

   - Consumers page 
        - CRUD
        - Searching
        - Sorting
   - About page     
   
   
## Install

 git clone 
 
 npm install
 
 composer install
 
 create .env file with db credentials
 
 php artisan generate:key
 
 php artisan migrate
 
 php artisan db:seed  - this command will make one user administrator@gmail.com with password: admin123 and will fill crud table with fake data
 
 php artisan passport:install
     