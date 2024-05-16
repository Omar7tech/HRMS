HRMS Application
Overview

The HRMS (Human Resource Management System) is a Laravel-based application designed to manage employees, trainees, schedules, positions, interviews, and vacations within an organization. It features multi-role authentication, detailed analytics, and comprehensive management tools.
Features

    Multi-role Authentication: Admin and Moderator roles
    Employee Management: CRUD operations, CV, and image management
    Schedule Management: Working schedules, interview scheduling, and vacations
    Position Management: CRUD operations and assignment to employees
    Statistics and Analytics: Performance metrics and visualizations using Charts.js
    User Management: Moderators can activate/deactivate admin accounts

Installation
Prerequisites

    PHP >= 7.4
    Laravel >= 8.x
    MySQL
    Composer
    Node.js


Admin Dashboard

Admins can manage employees, trainees, schedules, positions, interviews, and vacations. They have access to detailed statistics and performance metrics.
Moderator Dashboard

Moderators can activate or deactivate admin accounts and manage their own profiles.
Database Schema

Key tables and their relationships:

    employees: Manages employee data, references positions and schedules
    interviews: Manages interview schedules, references users
    positions: Manages job positions
    schedules: Manages work schedules
    users: Stores user data with roles and permissions
    vacations: Manages employee vacations, references employees

API Endpoints

    Authentication
        POST /api/login
        POST /api/logout
    Employees
        GET /api/employees
        POST /api/employees
        PUT /api/employees/{id}
        DELETE /api/employees/{id}
    Positions
        GET /api/positions
        POST /api/positions
        PUT /api/positions/{id}
        DELETE /api/positions/{id}

Frontend

    Uses Bootstrap for responsive design and jQuery for AJAX requests.
    Blade templates for dynamic views.

Security

    Ensure correct configuration of environment variables.
    Regularly update dependencies to address security vulnerabilities.
    Use Laravel's validation and sanitation mechanisms.

Contribution

    Fork the repository
    Create a new branch (git checkout -b feature/your-feature)
    Commit your changes (git commit -am 'Add some feature')
    Push to the branch (git push origin feature/your-feature)
    Create a new Pull Request

License

This project is licensed under the MIT License. See the LICENSE file for details.
Contact

For questions or support, contact omar.7tech|@gmail.com.

<h1>Hosted Demo at ( infinityFree ): <a href="http://hrms7.000.pe" target="_blank">visit</a></h1>

<hr/>
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

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
