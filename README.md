# AttendanceControl - Контроль посещаемости
Attendance control application.
[![Build Status](https://travis-ci.com/MkSavin/AttendanceControl.svg?branch=master)](https://travis-ci.com/MkSavin/AttendanceControl)

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
#### Step 3. Database
Run the migrations by using this command:
```
php artisan migrate
```
Fill database using `dump.example.sql` file.
##### ИЛИ
Just import `dump.example.sql` file to database. 

(With Docker use `localhost:33061`, user: `root` password: `*empty*` for connecting to Database)

### Launching:
Just launch your server and open reserved domain.
##### OR
Run 
```
docker-compose build
docker-compose up -d
```
for build Docker image and instantiationg containers.
After that you can open `localhost:8888` for getting access to application.

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
#### Шаг 3. База данных
Выполните миграции просто введя эту комманду:
```
php artisan migrate
```
Далее заполните базу данных на основе данных из файла `dump.example.sql`.
##### ИЛИ
Выполните импорт базы данных из файла `dump.example.sql`.

(При использовании Docker подключение к БД происходит через `localhost:33061`, пользователь: `root` пароль: `*пусто*`)

### Запуск:
Просто запустите свой сервер и откройте выделенный хост для проекта.
##### ИЛИ
Выполните 
```
docker-compose build
docker-compose up -d
```
для построения нового образа Docker и создания контейнеров.
После этого откройте `localhost:8888` для того, чтобы получить доступ к приложению.
