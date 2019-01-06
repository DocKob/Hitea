# Hitea

Create a global view of your IT infrastructures.
It has an IP, You can manage it.

## Required
- Apache 2.4 +
- PHP 7.2 +
- MariaDB 10.3.11 (Warning! If you have other version or MySql, please change this in doctrine.yaml)
- Composer
- NodeJs
- Yarn

## Dev Install

 - Edit .env file acording to your MariaDB/MySql server settings

```
DATABASE_URL=mysql://User:Password@127.0.0.1:3306/Hitea_App
```

 - Open Hitea's root folder in a CMD and install all project dependencies.

```
composer install
nmp install / yarn install
```

 - Create database and run migrations

```
 php bin/console doctrine:database:create
 php bin/console doctrine:migrations:migrate
```

 - Load app fixtures

```
php bin/console doctrine:fixtures:load
```

 - Run PHP and Webpack dev server.

```
php bin/console server:run
yarn encore dev --watch
```

- Go to http://127.0.0.1:8000
- Default admin account for testing : demo@hitea.fr/demo
