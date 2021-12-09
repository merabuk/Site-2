# CRM система
Пример сайта

## Установка

1. Клонировать репозиторий: `git clone https://github.com/merabuk/Site-2.git`
2. Перейти в репозиторий: `cd Site-2`
3. Установить зависимости composer: `composer install`
4. Установить зависимости npm: `npm install`
5. Создать файл .env в корне приложения: `cp .env.example .env` 
6. Настроить .env файл (URL, база данных) + создать пользователя БД и саму БД
7. Сгенерировать ключ приложения: `php artisan key:generate`
8. Запустить миграции БД: `php artisan migrate:fresh --seed`
9. Почистить кеш: `php artisan clear-compiled` , `php artisan optimize`


# CRM system 
Site example

## Installation

1. Cloning Repository: `git clone https://github.com/merabuk/Site-2.git`
2. Go to repository: `cd Site-2`
3. Set Composer dependencies: `composer install`
4. Install the NPM dependences: `npm install`
5. Create .Env file at the root of the application: `cp .env.example .env`
6. Configure .env file (URL, database) + Create a database user and database itself
7. Generate the key key: `php artisan key:generate`
8. Run the database migration: `php artisan migrate:fresh --seed`
9. Clean the cache: `php artisan clear-compiled` , `php artisan optimize`
