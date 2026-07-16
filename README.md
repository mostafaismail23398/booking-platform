# Booking Platform (Upwork-style service booking) — Laravel + Vanilla JS/Tailwind

This package contains the **application files** (models, migrations, controllers,
routes, views, middleware) for a service-booking platform:

- Clients browse services and book them.
- Providers list services they offer.
- Simple visitor counter (page views) + admin stats page.
- MySQL database.

Because the base Laravel framework itself has to be pulled from Packagist,
you install the empty framework first, then drop these files on top.

---

## 1. Create the base Laravel app (on YOUR machine, needs internet access to packagist.org)

```bash
composer create-project laravel/laravel booking-platform
cd booking-platform
composer require laravel/sanctum
php artisan install:api        # publishes Sanctum config (Laravel 11+)
```

## 2. Copy these files into the new project

Copy everything from this package into the matching folders of the fresh
`booking-platform` project (overwrite `routes/web.php` and `routes/api.php`):

```
app/Models/*                -> app/Models/
app/Http/Controllers/*      -> app/Http/Controllers/
app/Http/Controllers/Api/*  -> app/Http/Controllers/Api/
app/Http/Middleware/*       -> app/Http/Middleware/
database/migrations/*       -> database/migrations/
routes/web.php              -> routes/web.php
routes/api.php              -> routes/api.php
resources/views/*           -> resources/views/
public/js/*                 -> public/js/
public/css/*                -> public/css/
```

Register the visitor-tracking middleware in `bootstrap/app.php` (Laravel 11):

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\TrackVisit::class,
    ]);
})
```

## 3. Configure the database (MySQL)

Create the DB and user:

```sql
CREATE DATABASE booking_platform CHARACTER SET utf8mb4;
CREATE USER 'booking_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON booking_platform.* TO 'booking_user'@'localhost';
FLUSH PRIVILEGES;
```

Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_platform
DB_USERNAME=booking_user
DB_PASSWORD=your_strong_password
```

## 4. Migrate & run

```bash
php artisan migrate
php artisan serve
```
Visit http://127.0.0.1:8000

## 5. Visitor counter

Every non-API page load is logged into the `page_views` table by
`TrackVisit` middleware. See stats at `/dashboard/stats` (login required,
any logged-in user can see the count for now — lock it down to admins
later if you want).

## 6. Deploying to a Linux server over SSH (production)

```bash
sudo apt update && sudo apt install nginx mysql-server php8.3-fpm \
  php8.3-mbstring php8.3-xml php8.3-mysql php8.3-curl composer -y

git clone your-repo.git /var/www/booking-platform
cd /var/www/booking-platform
composer install --optimize-autoloader --no-dev
cp .env.example .env
php artisan key:generate
php artisan migrate --force
chown -R www-data:www-data storage bootstrap/cache
```

Nginx site config `/etc/nginx/sites-available/booking`:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/booking-platform/public;
    index index.php;

    location / { try_files $uri $uri/ /index.php?$query_string; }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* { deny all; }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/booking /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d yourdomain.com   # free HTTPS
```

Keep queue/schedule alive with `supervisor` if you later add jobs/notifications.

## 7. Suggested next steps for your portfolio

- Add Laravel Sanctum token auth on the API for a future mobile/SPA client.
- Swap the built-in visitor counter for **Umami** (self-hosted, Docker) if
  you want richer analytics — you already know Docker Compose from your
  home-lab project, so it's a one-service addition.
- Add `Roles` (client / provider) with a proper `Gate`/`Policy` instead of
  the simple `role` string check used here, once you want stricter access
  control.
