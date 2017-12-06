![Test Status](https://travis-ci.org/shibby/symfony4-example.svg?branch=master)
![Code Style](https://styleci.io/repos/113306206/shield)


## Installation

Create environment config file

    cp .env.dist .env
    
Create database
    
     php bin/console doctrine:database:create

Install php dependencies

    composer install
    
Install front-end dependencies

    yarn install
    
Update your database schema
    
    php bin/console doctrine:schema:update --force
        
Load dummy data

    php bin/console doctrine:fixtures:load --no-interaction

Run built-in server

    php bin/console server:run

Compile assets

    yarn run encore dev --watch    

Navigate to your browser:

    http://127.0.0.1:8000
