# Propay People

A Laravel application with Filament admin panel for managing people and their interests.

## Requirements

- PHP 8.4 or higher
- Laravel 12
- Composer
- MySQL 8 or higher

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/websa24/propay.git
   cd propay
   ```

2. **Environment Setup:**
   ```bash
   cp .env.example .env
   ```
    ```bash
   php artisan key:generate
   ```

3. **Install PHP dependencies:**
   ```bash
   composer install
   ```

   Update the `.env` file with your database configuration if needed. This project uses MySQL.

5. **Run Database Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed the Database:**
   ```bash
   php artisan db:seed
   ```
   This will create sample data including interests and people.

## Creating an Admin User for Filament

To access the Filament admin panel, you need to create an admin user:

```bash
php artisan filament:user
```

Follow the prompts to enter:
- Name
- Email address
- Password


## Running the Application

Start your local server:

  ```bash
  php artisan serve
  ```
 
Start your Queue:

  ```bash
  php artisan queue:work
  ```
  
## Accessing the Application

- **Application:** http://localhost:8000/admin

## Features

- **People Management:** CRUD operations for people records
- **Interests Management:** Manage interests that can be associated with people
- **Admin Dashboard:** Filament-powered admin interface with widgets and charts
- **Database Relationships:** Many-to-many relationship between people and interests

## Built With

- [Laravel](https://laravel.com/) - PHP Framework
- [Filament](https://filamentphp.com/) - Admin Panel
