# Student Manager (std-mgr)

A comprehensive Student Management System built using the **TALL/VILT stack** concepts, featuring a complete CRUD (Create, Read, Update, Delete) interface.

## Tech Stack

- **Backend:** [Laravel](https://laravel.com/) (PHP)
- **Frontend:** [Vue 3](https://vuejs.org/) (Composition API)
- **Routing/Data bridge:** [Inertia.js](https://inertiajs.com/)
- **Styling:** [Tailwind CSS](https://tailwindcss.com/)
- **Components:** [shadcn-vue](https://www.shadcn-vue.com/)
- **Routing Generation:** [Laravel Wayfinder](https://github.com/laravel/vite-plugin-wayfinder)

## Features

- Complete Student CRUD capabilities.
- Form validations handling uniqueness across both creating and updating records.
- Responsive data tables.
- Seamless, single-page application experience leveraging Inertia.js.
- Dark mode support using Tailwind CSS.

## Requirements

Before getting started, ensure you have the following installed on your machine:
- PHP >= 8.2
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en/) & NPM
- Database (SQLite, MySQL, or PostgreSQL)

## Installation & Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/Nak9009/std-mgr.git
   cd std-mgr
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   Copy the example environment file and generate a new application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure to update your database credentials inside the `.env` file if you aren't using the default SQLite database.*

5. **Run Migrations**
   Create the database tables.
   ```bash
   php artisan migrate
   ```

6. **Start the Development Servers**
   You will need to run two processes in separate terminal tabs:

   Start the Vite development server for the frontend assets:
   ```bash
   npm run dev
   ```

   Start the Laravel local development server:
   ```bash
   php artisan serve
   ```

7. **Visit the application**
   Open your browser and navigate to `http://localhost:8000`. 
   You can register a new account and then head over to the **Students** tab in your dashboard sidebar to manage student records.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
