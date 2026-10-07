# eLancer

eLancer is a Laravel-based freelance marketplace. Clients can publish projects and manage their listings, while freelancers can maintain a profile and submit proposals to open projects.

## Features

- Browse open projects and view project details
- Create and manage client projects, including categories, tags, and file attachments
- Create a freelancer profile and submit proposals with pricing and estimated duration
- User accounts, authentication, email verification, and password reset
- Admin dashboard tools for categories, roles, and application settings
- Messaging and notifications
- Project REST API protected by an API key and Laravel Sanctum tokens
- Thawani checkout integration (requires provider credentials)

## Tech stack

- PHP 8.1+
- Laravel 10
- MySQL 8
- Blade, Tailwind CSS, Alpine.js, and Vite

## Requirements

- PHP 8.1 or later with the extensions required by Laravel and the project
- Composer
- MySQL 8 (or another database supported by Laravel, configured in `.env`)
- Node.js and npm, for building frontend assets

## Getting started

1. Clone the repository and enter the project directory:

   ```bash
   git clone https://github.com/Khalid-El-Ashe/Laravel-eLancer.git
   cd Laravel-eLancer
   ```

2. Install the PHP dependencies and create your local environment file:

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

   On Windows PowerShell, you can use `Copy-Item .env.example .env` instead of `cp`.

3. Create a MySQL database, then update the `DB_*` values in `.env` to match your local database. The example configuration uses a database named `elancer`.

4. Run the migrations:

   ```bash
   php artisan migrate
   ```

5. Install and build the frontend assets:

   ```bash
   npm ci
   npm run build
   ```

6. Start the Laravel development server:

   ```bash
   php artisan serve
   ```

   Open the URL printed by Artisan (normally <http://127.0.0.1:8000>).

   During frontend development, run `npm run dev` in a second terminal instead of building assets once.

## Docker

The repository includes Docker Compose services for the PHP application, Nginx, MySQL, and Mailpit. The Compose database is exposed on port `3307` on the host; from the application container, use the service name `database` and port `3306`.

1. Copy `.env.example` to `.env` and set the database values for Compose:

   ```dotenv
   APP_URL=http://localhost:8081
   DB_CONNECTION=mysql
   DB_HOST=database
   DB_PORT=3306
   DB_DATABASE=elancer
   DB_USERNAME=elancer
   DB_PASSWORD=secret
   MAIL_HOST=mailpit
   MAIL_PORT=1025
   ```

2. Build and start the services, install dependencies, and initialize the application:

   ```bash
   docker compose up -d --build
   docker compose exec app composer install
   docker compose exec app npm ci
   docker compose exec app npm run build
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate
   ```

3. Visit <http://localhost:8081>. Mailpit's web interface is available at <http://localhost:8025>.

The database credentials in `docker-compose.yml` are for local development only. Replace them and use secure secrets for any deployment.

## Optional integrations

Set these values in `.env` when using the related features:

| Variable | Purpose |
| --- | --- |
| `API_KEY` | API key expected in the `x-api-key` request header |
| `THAWANI_SECRET_KEY` | Thawani API secret |
| `THAWANI_PUBLISHABLE_KEY` | Thawani publishable key |
| `PUSHER_APP_ID`, `PUSHER_APP_KEY`, `PUSHER_APP_SECRET` | Pusher broadcasting credentials |

Do not commit `.env` or production credentials.

## Tests

Run the Laravel test suite with:

```bash
php artisan test
```

## License

No license file is currently included. Add a `LICENSE` file before redistributing the project under a specific license.
