# ValueMap website

Laravel 12 website for the ValueMap Horizon Europe project. The public site includes the project overview, work-package structure, consortium map, stakeholder ecosystem, public results library, news and media hub, and contact form.

## Local setup

Requirements: PHP 8.2+, Composer, Node.js 20+ and SQLite.

```bash
composer install
copy .env.example .env
php artisan key:generate
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan migrate --seed
npm install
npm run build
php artisan storage:link
php artisan serve
```

On Windows PowerShell, create the database with:

```powershell
New-Item -ItemType File -Path database\database.sqlite -Force
```

## Create an administrator

The site does not contain a default password. Create the first administrator interactively:

```bash
php artisan valuemap:create-admin
```

Open `/admin/login` and sign in. Administrators can add and edit news, events, newsletters, press items, deliverables, publications and other project outputs, including document and image uploads.

## Analytics and production settings

Set these values in the production `.env` file:

```env
APP_NAME=ValueMap
APP_ENV=production
APP_DEBUG=false
APP_URL=https://valuemap.eu
GA_MEASUREMENT_ID=G-XXXXXXXXXX
```

Run `php artisan optimize` after production configuration changes. Point the web server document root to the Laravel `public` directory.

## Content status

The current copy, work-package titles, partner profiles, grant details and contact information are draft placeholders based on the initial brief. Replace them with consortium-approved material before public launch. The official ValueMap logo should also replace the temporary typographic mark when the source asset is available.
