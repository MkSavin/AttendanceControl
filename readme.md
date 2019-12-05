# AttendanceControl
Attendance control application.

## EN:

### Installation:
#### Step 1. Composer
Open your cloned project directory and run:
```
composer update
```
It will create `/vendors` directory and update dependancies.
#### Step 2. Env
Create `.env` file from `.env.example` and fill `DB_*` fields in it. Also don't forget to fill `APP_KEY` field by setting random key for this application.
#### Step 3. Migrations
Run the migrations by using this command:
```
php artisan migrate
```

### Launching:
Just launch your server and open reserved domain.

## RU:

### Установка:
#### Шаг 1. Composer
Откройте ваш склонированный проект и выполните:
```
composer update
```
Комманда создаст папку `/vendors` и обновит зависимости.
#### Шаг 2. Env
Создайте файл `.env` из `.env.example` и заполните все поля с таким шаблоном: `DB_*` в этом файле. Также не забудьте заполнить поле `APP_KEY` просто указав любой идентификатор, указывающий на ключ данного приложения.
#### Шаг 3. Миграции
Выполните миграции просто введя эту комманду:
```
php artisan migrate
```

### Запуск:
Просто запустите свой сервер и откройте выделенный хост для проекта.
