# AFFILIATE CRM

## Установка

1. Сгенерировать ключь SSH: `ssh-keygen -t rsa`
2. Добавить ключ для доступа к приватному репозиторию:  **[Репозиторий](git@github.com:fibergateproj/affiliate2.git)**
3. Клонировать репозиторий: `git clone git@github.com:fibergateproj/affiliate2.git`
4. Перейти в репозиторий: `cd affiliate2`
5. Установить зависимости composer: `composer install`
6. Установить зависимости npm: `npm install`
7. Создать файл .env в корне приложения: `cp .env.example .env` 
8. Настроить .env файл (URL, база данных) + создать пользователя БД и саму БД
9. Сгенерировать ключ приложения: `php artisan key:generate`
10. Запустить миграции БД: `php artisan migrate:fresh --seed`
11. Почистить кеш: `php artisan clear-compiled` , `php artisan optimize`

## CRON задача

Для корректной работы очередей требуется CRON задача.
- Пример:
`* * * * *	/usr/local/bin/php /home/pwtjbzzd/public_html/motoshop/artisan schedule:run >> /dev/null 2>&1`
- `* * * * *` - запуск задачи ежеминутно
- `/usr/local/bin/php` - путь на сервере к php
- `/home/pwtjbzzd/public_html/motoshop/artisan` - путь к файлу artisan.php
- `schedule:run >> /dev/null 2>&1` - команда запуска расписания задач
