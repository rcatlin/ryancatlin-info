Ryan Catlin Info (Personal Site)
========================

Code for my personal site: http://ryancatlin.info

## Install locally (dev)
* REQUIRES PHP>=5.3.3, composer, bower, npm, and an available MySQL instance.
* `git clone git@github.com:rcatlin/ryancatlin-info`
* `cd ryancatlin-info`
* Install PHP dependencies and generate autoloader: `composer install` 
* Create `parameters.yml` file: `cp app/config/parameters.yml.dist app/config/parameters.yml`
* Edit `app/config/parameters.yml` with database credentials to allow connection to your MySql instance.
* Install node dependencies `npm install`
* Install front-end dependencies: `bower install`
* Generate front-end assets: `grunt`
* Generate database: `php app/console doctrine:database:create`
* Execute migrations: `php app/console doctrine:migrations:migrate`
* Run server: `php app/console server:run`
* Visit `http://127.0.0.1:8000/register` and register.
* Logout via `http://127.0.0.1:8000/logout`
* Promote your user: `php app/console fos:user:promote --super your-registered-username-here`
* Login via `http://127.0.0.1:8000/login` to have access to admin.
