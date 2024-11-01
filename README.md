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

- Clone the repository
- Run `composer install`
- Create a new database
- Copy the `.env.example` file to `.env` and update the database credentials
- Run `php artisan key:generate`
- Run `php artisan migrate --seed`
- Run `php artisan db:seed --class=UserSeeder`
- Run `php artisan serve`
- Visit `http://localhost:8000`

## Important Commands

- Create a new model: `php artisan make:model Name`
- Create a new controller: `php artisan make:controller NameController`
- Create a new controller with resource methods: `php artisan make:controller NameController -r`
- Create a new migration: `php artisan make:migration create_name_table`
- Run the migrations: `php artisan migrate` or `php artisan migrate:fresh` (drop all tables and re-run the migrations)
- Rollback the last migration: `php artisan migrate:rollback`
- Create a new seeder: `php artisan make:seeder NameTableSeeder`
- Seed the database: `php artisan db:seed`
- Seed the database using the class name: `php artisan db:seed --class=NameTableSeeder`
- Create a new factory: `php artisan make:factory NameFactory`
- Create a new model factory: `php artisan make:factory NameFactory --model=Name`
- Create a new middleware: `php artisan make:middleware NameMiddleware`
- Create a new request: `php artisan make:request NameRequest`
- Create a new resource: `php artisan make:resource NameResource`
- Create a new event: `php artisan make:event NameEvent`
- Create a new listener: `php artisan make:listener NameListener`
- Create a new job: `php artisan make:job NameJob`
- Create a new mail: `php artisan make:mail NameMail`
- Create a new notification: `php artisan make:notification NameNotification`
- Create a new channel: `php artisan make:channel NameChannel`
- Create a new test: `php artisan make:test NameTest`
- Create a new policy: `php artisan make:policy NamePolicy`
- Cache the routes: `php artisan route:cache`
- Clear the cache: `php artisan cache:clear`
- Create a new package: `php artisan package:make Name`
- Create a new command: `php artisan make:command NameCommand`
- Create a new provider: `php artisan make:provider NameServiceProvider`
- Create a new event listener: `php artisan event:generate`
- Create a new resource controller: `php artisan make:controller NameController --resource`
- Create a new resource collection: `php artisan make:resource NameCollection`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
```
