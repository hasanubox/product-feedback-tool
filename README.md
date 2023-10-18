## Project Setup

This document provides instructions on setting up and running the project. After clone the project please follow these steps to get started

1. Copy `.env.example` to `.env`

```shell
cp .env.example .env
```
## 2. Install Composer Dependencies
```shell
composer install
```
# 3. Configure the Database and Email

- In the `.env` file you created in step 1, set up your database and email credentials:
- Create a database and add its name and credentials in the `.env` file.
- Add your email service credentials to the `.env` file.

## 4. Install Supervisor
 To manage queue workers, you'll need to install Supervisor. Follow the Laravel documentation for Supervisor configuration:
## [Supervisor Configuration](https://laravel.com/docs/10.x/queues#supervisor-configuration)

## 5. Run Database Migrations and Seed Data
```shell
php artisan migrate --seed
```
## 6. Start the Development Server
You can run the development server using the following command:
```shell
php artisan serve
```
## 7. Compile Frontend Assets
```shell
npm run dev
```
