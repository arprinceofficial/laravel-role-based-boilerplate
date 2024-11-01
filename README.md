<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel Role Based Access Control (RBAC)

This is a simple Laravel project that demonstrates how to implement Role Based Access Control (RBAC) in Laravel. The project has two roles: Admin and User. The Admin role has full access to the application while the User role has limited access. The project has the following features:

- User registration
- User login
- Social login (Firebase)
- User profile
- Admin dashboard
- User management
- Role management
- Permission management

## Installation

1. Clone the repository
2. Run `composer install`
3. Create a new database
4. Copy the `.env.example` file to `.env` and update the database credentials
5. Run `php artisan key:generate`
6. Run `php artisan migrate --seed`
7. Run `php artisan serve`
8. Visit `http://localhost:8000`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
```
