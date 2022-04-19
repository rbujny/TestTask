# Test Task

## About project

* An application in symfony which allows, from the homepage, to log the user in.
* Once logged in, the user gains access to the path "/secured-area" which is only available to logged in users.
* The logged-in user will be able to create, view and edit existing users.
* The user logs in with their email address and password.

## Technologies used in the project
**Frontend**

- HTML/Twig 🌱

- CSS 🔵

- JS 🟡

**Backend**

- Symfony 6 (PHP) 🐘

- SQLite 🐬


## Setup

After cloning the repository you need to install composer:

```
composer install
```

## Database setup

The SQLite database was used for the project.
To build the database and execute the migrations, type in your terminal:
```
    bin/console doctrine:database:create
    bin/console doctrine:migrations:migrate
    bin/console doctrine:fixtures:load
```

## Start server

To start your web server type:

```
    symfony serve -d
```

## Configuration on website

After the server has started, you can log in with admin account:
- email: `admin@admin.com` with password `admin`
- Or go to `/register` and create user!
- Then you will automatically be redirected to `/secured-area` where you can use the full functionality of the website.

### Author

*Radosław Bujny*
