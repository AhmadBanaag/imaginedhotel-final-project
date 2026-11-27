<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# oop-pos-1-2627-sims

## Carl's Module

# ImaginedHotel - Room & User Management Modules (Carl's Module)

This module implements the **Room Inventory Management** (CRUD operations, category pricing, and availability states) and **User Account Management** (role assignment and activation/deactivation controls) based on the project's Entity-Relationship Diagram (ERD).

---

## 🛠️ Features Completed

### 1. Room Management (`/admin/rooms`)
- **Add Rooms**: Create physical room units with custom identifiers (`Room 101`, `Room 201`, etc.) linked to designated Room Categories.
- **Dynamic Categories & Pricing**: Seeded and synchronized with the ERD:
  - *Single-bed room* (₱999.00 / night, 1 Guest)
  - *Double-bed room* (₱1,999.00 / night, 2 Guests)
  - *Family Room* (₱2,999.00 / night, 4 Guests)
  - *Superior / Suite* (₱4,999.00 / night, 6 Guests)
- **Room Status Management**: Track physical room readiness with availability states:
  - `available` (Open for guest reservations)
  - `booked` (Occupied by a guest)
  - `unavailable` (Under maintenance / cleaning hold by admin)
- **Edit & Update Rooms**: Modify room number, category assignment, or availability status with duplicate validation protection.
- **Delete Rooms**: Remove room units from inventory with a single click.
- **Dynamic Category Filtering**: Live client-side Alpine.js filtering (`All`, `Single`, `Double`, `Family`, `Superior`).

### 2. User & Access Management (`/admin/users`)
- **User Roles Synchronization**:
  - `Role 1` = `admin` (System Administrator)
  - `Role 2` = `guest` (Unregistered walk-in guest booking without an account)
  - `Role 3` = `account_user` (Registered customer with credentials)
- **Automatic Role Assignment**: When a new user registers through `/register`, they are automatically assigned `role_id = 3` (`account_user`).
- **Account Activation / Deactivation**:
  - Admins can toggle any user account between **Active** and **Deactivated** directly from the backoffice table.
  - Deactivated accounts are restricted from logging into the portal.

### 3. Guest Booking Calculation Flow (`/reservations/book`)
- Multi-night stay calculation based on selected check-in and check-out dates.
- Dynamic calculation of 50% downpayment deposit for Over-The-Counter (OTC) or full amount for E-Wallet payments.
- Date validation ensuring check-out is strictly after check-in.

---

## 📂 Files Created & Modified

### Database Migrations & Seeders
- `database/migrations/..._create_user_roles_table.php` (Creates `user_roles` with `role_id` PK)
- `database/migrations/..._add_role_and_status_to_users_table.php` (Adds `role_id`, `first_name`, `last_name`, `phone`, `is_active` to `users`)
- `database/migrations/..._create_room_types_table.php` (Creates `room_types` with `PricePerNight`, `maxGuest`)
- `database/migrations/..._create_rooms_table.php` (Creates `rooms` with FK `room_type_id`, `room_number`, `status`)
- `database/seeders/ImaginedHotelInitialSeeder.php` (Initial seed data for roles, room types, and sample rooms)
  

### Models
- `app/Models/User.php` (Updated fillable attributes and casts)
- `app/Models/Room.php` (Custom PK `room_id`, `belongsTo(RoomType::class)`)
- `app/Models/RoomType.php` (Custom PK `room_type_id`, `hasMany(Room::class)`)

### Controllers
- `app/Http/Controllers/Admin/RoomController.php` (Full CRUD operations for rooms)
- `app/Http/Controllers/Admin/UserController.php` (Directory listing & account activation toggle)
- `app/Http/Controllers/Auth/RegisteredUserController.php` (Auto-assigns `role_id = 3` to new signups)

### Views & Routes
- `resources/views/admin/rooms/index.blade.php` (Room inventory dashboard)
- `resources/views/admin/rooms/create.blade.php` (Add room unit form)
- `resources/views/admin/rooms/edit.blade.php` (Edit room unit form)
- `resources/views/admin/users/index.blade.php` (User management directory & activation toggle)
- `resources/views/reservations/create.blade.php` (Updated guest booking summary & cost calculation)
- `routes/web.php` (Connected resource routes for rooms and users)

---

## User Dashboard Created
- **Dynamic Synchronization**:
  - Dynamic Personal Info
  - Edit, Update of Personal info Not included yer    
- **Dynamic Showcase of Available Rooms To Book**: Admins can Avail, Unavail Rooms and it will dynamically show it in the dashboard
- **Account Activation / Deactivation**:
  - Admins can toggle any user account between **Active** and **Deactivated** directly from the backoffice table and the dashboard will showcase it to the user.
  - Deactivated accounts are restricted from logging into the portal.

## 🚀 How to Run and Test

1. **Start Laragon**: Ensure Apache and MySQL are running.
2. **Start the Laravel Server**:
   ```bash
   php artisan serve
   ```
3. **Open the URLs in Browser**:
   - **Room Inventory**: [http://127.0.0.1:8000/admin/rooms](http://127.0.0.1:8000/admin/rooms)
   - **User Directory**: [http://127.0.0.1:8000/admin/users](http://127.0.0.1:8000/admin/users)
   - **Guest Booking**: [http://127.0.0.1:8000/reservations/book](http://127.0.0.1:8000/reservations/book)
