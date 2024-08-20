# Availability Management System

This project is a Laravel-based web application designed for managing and displaying availability for an admin under different categories.
This project i have used laravel in-built auth for admin login.

## Features

- **Category**: Create and manage categories for availability.
- **Availability**: Admin can create availability slots, specifying the category, date, start time, end time, and interval.
- **Filtering**: View all availability with an option to filter by category.
- **Pagination**: Display availability for 3 consecutive days with options to navigate to the next and previous days.

## Installation

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/lokesh0571995/availability-management.git
   cd availability-management

2. Install dependencies:
    1. composer install or composer update
    2. npm install
    3. npm run build
    
3. Set up environment variables:   
    1. DB_DATABASE=your_database_name
    2. DB_USERNAME=your_username
    3. DB_PASSWORD=your_password

4. Generate application key:    

    1. php artisan key:generate

5. Run migrations:
    1. php artisan migrate

6. Seed the database for admin login:

   1. php artisan db:seed --class=AdminSeeder


7. Run the server:
   1. php artisan serve

  
  Admin Login

  http://127.0.0.1:8000/login

  username : admin@gmail.com
  password :123456

  Front Url : http://127.0.0.1:8000/availabilities







   

