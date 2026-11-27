# AttendanceControl - Контроль посещаемости
Attendance control application.
[![Build Status](https://github.com/MkSavin/AttendanceControl/actions/workflows/tests.yml/badge.svg)](https://github.com/MkSavin/AttendanceControl/actions/workflows/tests.yml)

## EN:

### Installation:
#### Step 1. Composer
Open your cloned project directory and run:
```
composer install
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

(With Docker use `localhost:33061`, user: `attendance` password: `attendance-local` for connecting to Database)

#### Step 4. Test credentials
These accounts are available after importing `dump.example.sql`:

| Role | Email | Password |
| --- | --- | --- |
| Administrator | `admin@example.test` | `AttendanceAdmin!` |
| Manager | `manager3@example.test` | `AttendanceManager!` |
| Student | `student1@example.test` | `AttendanceStudent!` |

Signing in rotates the account's API token, so previously issued bearer tokens stop working. To issue a token for an external integration, run `php artisan api-token user@example.test`; the token is shown once and stored hashed.

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
composer install
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

(При использовании Docker подключение к БД происходит через `localhost:33061`, пользователь: `attendance` пароль: `attendance-local`)

#### Шаг 4. Данные для входа
После импорта `dump.example.sql` доступны тестовые учётные записи:

| Роль | Email | Пароль |
| --- | --- | --- |
| Администратор | `admin@example.test` | `AttendanceAdmin!` |
| Менеджер | `manager3@example.test` | `AttendanceManager!` |
| Студент | `student1@example.test` | `AttendanceStudent!` |

При входе API-токен аккаунта перевыпускается, поэтому ранее выданные bearer-токены перестают работать. Для внешней интеграции выполните `php artisan api-token user@example.test`: токен будет показан один раз, а в БД сохранится его хеш.

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
