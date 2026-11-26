# ImaginedHotel

Online room reservation and front-desk backoffice application built with **Laravel 13**, **Laravel Breeze**, **Tailwind CSS v4**, and **Alpine.js**.

## Local Development Setup

```sh
composer install
npm install
php artisan key:generate
php artisan migrate
```

Run the Laravel server, queue worker, and Vite dev server together:

```sh
composer run dev
```

Or build frontend assets for production / Laragon virtual hosts:

```sh
npm run build
```

## Running Tests

```sh
php artisan test
```
