# YM Medical Appointment

A production-ready Laravel platform for managing medical appointments across **patients, doctors, and administrators**.

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com/docs/10.x)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Build Tool](https://img.shields.io/badge/Vite-5.x-646CFF?logo=vite&logoColor=white)](https://vitejs.dev/)

## Table of Contents
1. [Project Purpose](#project-purpose)
2. [Core Features](#core-features)
3. [Roles and Permissions](#roles-and-permissions)
4. [Tech Stack](#tech-stack)
5. [Quick Start](#quick-start)
6. [Configuration](#configuration)
7. [Default Admin Access](#default-admin-access)
8. [Useful Commands](#useful-commands)
9. [Security Notes](#security-notes)
10. [Troubleshooting](#troubleshooting)
11. [Testing](#testing)
12. [License](#license)

## Project Purpose
YM Medical Appointment digitizes clinic workflows by centralizing scheduling, doctor-patient coordination, and platform operations in one system.

This project helps teams:
- reduce manual appointment errors,
- make booking faster for patients,
- give doctors a clear live schedule,
- provide admins full operational control and visibility.

## Core Features
| Area | Capabilities |
| --- | --- |
| Authentication | Multi-role login (Admin, Doctor, Patient), profile management |
| Appointments | Book, approve, reject, cancel, and track appointment lifecycle |
| Doctor Operations | Schedule availability, manage requests, review patient history |
| Patient Experience | Browse doctors, manage bookings, view health content |
| Admin Back Office | Manage users, applications, specialities, dashboards, exports |
| Reporting | Charts and PDF exports for operational insights |
| Notifications | In-app notifications and workflow updates |

## Roles and Permissions
| Role | Main Responsibilities |
| --- | --- |
| `Admin` | Manages doctors, patients, schedules, appointments, applications, and platform settings |
| `Doctor` | Manages personal schedule, appointments, and patient interactions |
| `Patient` | Finds doctors, books appointments, and monitors personal bookings |

## Tech Stack
| Layer | Tools |
| --- | --- |
| Backend | Laravel 10, PHP 8.1+, Sanctum |
| Frontend | Blade, Tailwind CSS, Bootstrap 5, Alpine.js, jQuery |
| Build | Vite, npm |
| Database | MySQL or MariaDB |
| Packages | DomPDF, Laravel Charts, Heroicons, SweetAlert2, FullCalendar |

## Quick Start
### 1. Clone the repository
```bash
git clone https://github.com/YoussefSelk/YM-Medical-Appointment.git
cd YM-Medical-Appointment
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Create your environment file
```bash
cp .env.example .env
```
On Windows PowerShell:
```powershell
Copy-Item .env.example .env
```

### 4. Configure environment values
Update `.env` with your database and app settings.

### 5. Prepare application
```bash
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
```

### 6. Run the app
```bash
php artisan serve
npm run dev
```

### 7. Optional scheduler worker
```bash
php artisan schedule:work
```

## Configuration
Minimum required `.env` variables:

| Key | Purpose |
| --- | --- |
| `APP_URL` | Base URL of the application |
| `APP_ENV`, `APP_DEBUG` | Environment and debug mode |
| `DB_*` | Database connection |
| `MAIL_*` | SMTP/email integration |
| `NEWS_API_KEY` | Optional: external health articles feed |

## Default Admin Access
After running `php artisan migrate:fresh --seed`:

- **Email:** `admin@example.com`
- **Password:** `Estk@23@24`

Seeder source: [database/seeders/UsersTableSeeder.php](database/seeders/UsersTableSeeder.php)

For real deployments, change this account immediately.

## Useful Commands
| Task | Command |
| --- | --- |
| Run tests | `php artisan test` |
| Cache routes | `php artisan route:cache` |
| Cache config | `php artisan config:cache` |
| Build frontend assets | `npm run build` |
| Clear app caches | `php artisan optimize:clear` |

## Security Notes
- Keep `APP_DEBUG=false` outside local development.
- Use strong production credentials and rotate defaults.
- Route and role checks are enforced for protected operations.
- Rate limiting is applied on sensitive/high-frequency endpoints.
- Secure headers middleware is enabled.

## Troubleshooting
### Login fails with seeded admin
1. Re-run seeders: `php artisan migrate:fresh --seed`
2. Clear caches: `php artisan optimize:clear`
3. Confirm you are using:
   - Email: `admin@example.com`
   - Password: `Estk@23@24`

### Too many redirects (`ERR_TOO_MANY_REDIRECTS`)
1. Ensure `.env` has the correct `APP_URL` (for local: `http://127.0.0.1:8000`).
2. Clear caches: `php artisan optimize:clear`
3. Remove old browser cookies for `127.0.0.1`.

## Testing
Run the automated test suite:

```bash
php artisan test
```

## License
Licensed under the [MIT License](LICENSE).
