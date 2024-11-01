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

## Important Commands

1. Create a new controller: `php artisan make:controller NameController`
2. Create a new model: `php artisan make:model Name`
3. Create a new migration: `php artisan make:migration create_name_table`
4. Run the migrations: `php artisan migrate` or `php artisan migrate:fresh` (drop all tables and re-run the migrations)
5. Rollback the last migration: `php artisan migrate:rollback`
6. Create a new seeder: `php artisan make:seeder NameTableSeeder`
7. Seed the database: `php artisan db:seed`
8. Create a new middleware: `php artisan make:middleware NameMiddleware`
9. Create a new request: `php artisan make:request NameRequest`
10. Create a new resource: `php artisan make:resource NameResource`
11. Create a new event: `php artisan make:event NameEvent`
12. Create a new listener: `php artisan make:listener NameListener`
13. Create a new job: `php artisan make:job NameJob`
14. Create a new mail: `php artisan make:mail NameMail`
15. Create a new notification: `php artisan make:notification NameNotification`
16. Create a new channel: `php artisan make:channel NameChannel`
17. Create a new factory: `php artisan make:factory NameFactory`
18. Create a new test: `php artisan make:test NameTest`
19. Create a new policy: `php artisan make:policy NamePolicy`
20. Cache the routes: `php artisan route:cache`
21. Clear the cache: `php artisan cache:clear`
22. Create a new package: `php artisan package:make Name`
23. Create a new command: `php artisan make:command NameCommand`
24. Create a new provider: `php artisan make:provider NameServiceProvider`
25. Create a new event listener: `php artisan event:generate`
26. Create a new model factory: `php artisan make:factory NameFactory --model=Name`
27. Create a new resource controller: `php artisan make:controller NameController --resource`
28. Create a new resource collection: `php artisan make:resource NameCollection`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
```
