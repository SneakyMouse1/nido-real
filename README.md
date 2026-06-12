# NidoReal

> **Note:** This is a final thesis project (*Proyecto de Fin de Ciclo*) for the **FP Grado Superior** at **IG Formación** in Alicante, Spain. It was built to explore the Laravel, Filament, and Tailwind CSS ecosystem, and is not intended for production use without additional security, testing, and optimization.

**NidoReal** is a Spanish real estate platform built as a Laravel monolith. It features two Filament v4 administration panels and a public-facing frontend powered by Blade and Tailwind CSS v4.

---

## Features

* **Public website** — property catalogue with search and filtering capabilities, including agency profile pages and interactive Mapbox maps
* **Agency cabinet** (`/cabinet`) — manage property listings, upload photos and floor plans, and manage agent teams
* **Admin panel** (`/secret-admin`) — content moderation, agency and subscription plan management, and feature administration
* **Multi-language support** — Spanish (default) and English
* **SPA-like Feel** — smooth page transitions powered by Swup
* **Interactive Maps** — Mapbox-powered location maps and catalog search with dark mode auto-styling
* **Galleries & Sliders** — responsive property galleries powered by Swiper
* **Dark mode** — implemented using Alpine.js and localStorage
* **Billing simulation** — three subscription plans (`starter`, `pro`, `unlimited`) with listing limits

---

## Tech Stack

| Layer               | Technology                                                                  | Version              |
| ------------------- | --------------------------------------------------------------------------- | -------------------- |
| Backend             | [Laravel](https://laravel.com)                                              | ^12.0                |
| Admin / Cabinet     | [Filament](https://filamentphp.com)                                         | ^4.0                 |
| Public Frontend     | Laravel Blade + Alpine.js                                                   | Alpine ^3.x          |
| CSS Framework       | [Tailwind CSS](https://tailwindcss.com)                                     | ^4.2                 |
| Interactive Maps    | [Mapbox GL JS](https://www.mapbox.com/)                                     | v3.4.0 (CDN)         |
| Page Transitions    | [Swup](https://swup.js.org/)                                                | ^4.9                 |
| Slider / Carousel   | [Swiper](https://swiperjs.com/)                                             | ^12.1                |
| Media Lightbox     | [Fancybox](https://fancyapps.com/fancybox/)                                 | ^6.1                 |
| Database            | PostgreSQL                                                                  | 15+ (16 recommended) |
| Roles & Permissions | [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)      | ^7.2                 |
| Media Management    | [Spatie Laravel Media Library](https://spatie.be/docs/laravel-medialibrary) | ^11.21               |
| Activity Logging    | Spatie Laravel Activitylog                                                  | ^4.12                |
| Slug Generation     | Spatie Laravel Sluggable                                                    | ^3.8                 |
| Icons               | [Blade Heroicons](https://github.com/blade-ui-kit/blade-heroicons)          | ^2.7                 |
| Asset Bundler       | Vite                                                                        | ^7.0                 |
| Deployment          | Hetzner VPS with [Coolify](https://coolify.io)                              | —                    |

---

## System Requirements

| Dependency | Minimum Version | Recommended Version |
| ---------- | --------------- | ------------------- |
| PHP        | 8.2             | **8.4**             |
| Composer   | 2.5             | **2.8+**            |
| Node.js    | 18.x            | **20.x**            |
| npm        | 9.x             | **10.x**            |
| PostgreSQL | 14              | **16**              |

Required PHP extensions:

```text
pdo_pgsql, mbstring, exif, pcntl, bcmath, gd, zip, intl
```

---

## Local Setup

### 1. Clone the repository

```bash
git clone <repository-url> nido-real
cd nido-real
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with the appropriate database credentials and Mapbox token:

```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nido_real
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mapbox API token for interactive maps
VITE_MAPBOX_TOKEN=your_mapbox_token_here
```

### 4. Create the PostgreSQL database

```bash
psql -U postgres -c "CREATE DATABASE nido_real;"
```

### 5. Run migrations and seeders

```bash
php artisan migrate
php artisan db:seed
```

### 6. Create the storage symlink

```bash
php artisan storage:link
```

### 7. Install Node.js dependencies and start Vite

```bash
npm install
npm run dev
```

### 8. Start the development environment

```bash
# Start all development services (server, queue, logs, and Vite)
composer dev
```

The application will be available at:

```text
http://localhost:8000
```

---

## Panels and Access Control

| URL             | Panel                | Roles                     |
| --------------- | -------------------- | ------------------------- |
| `/secret-admin` | Administration Panel | `superadmin`, `admin`     |
| `/cabinet`      | Agency Cabinet       | `agency_manager`, `agent` |
| `/`             | Public Website       | All visitors              |

---

## Docker (Optional)

The project includes a `Dockerfile` and `docker-compose.yml` configured for deployment using Coolify with Traefik integration.

For local development, the native setup described above is recommended.

```bash
docker compose up -d
```

---

## Project Structure

```text
nidoreal/
├── app/
│   ├── Enums/              # PHP enums (PropertyType, PropertyStatus, etc.)
│   ├── Models/             # Eloquent models
│   ├── Observers/          # Model observers (billing, file cleanup)
│   ├── Policies/           # Authorization policies
│   ├── Services/           # Business logic services
│   └── Filament/
│       ├── Admin/          # Resources for /secret-admin
│       └── Agency/         # Resources for /cabinet
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/app.css         # Tailwind CSS and design system tokens
│   ├── js/app.js           # Alpine.js and dark mode functionality
│   └── views/
│       ├── components/public/  # Public Blade components
│       ├── layouts/            # Layout templates
│       └── public/             # Public pages
├── lang/
│   ├── es/                 # Spanish translations
│   └── en/                 # English translations
└── public/
    └── images/logo.svg     # Project logo
```

---

## Useful Commands

```bash
# Clear application caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Run Filament upgrade tasks after updating Filament
php artisan filament:upgrade

# Start the queue worker
php artisan queue:listen --tries=1

# Build frontend assets for production
npm run build
```

---

## License

This project is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

Created as a final graduation project (*Proyecto de Fin de Ciclo*) for FP Grado Superior at IG Formación (Alicante). Feel free to use, study, and modify it.
