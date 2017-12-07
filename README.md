[![Build Status](https://travis-ci.org/shibby/symfony4-example.svg?branch=master)](https://travis-ci.org/shibby/symfony4-example)
[![Code Style](https://styleci.io/repos/113306206/shield)](https://styleci.io/repos/113306206)


## Installation

Create environment config file

    cp .env.dist .env

Install php dependencies

    composer install
    
Install front-end dependencies

    yarn install
    
Create database
    
     php bin/console doctrine:database:create
    
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
