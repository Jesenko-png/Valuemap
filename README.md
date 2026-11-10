# ValueMap website

Laravel 12 website for the ValueMap Horizon Europe project. The public site includes the project overview, work-package structure, consortium map, stakeholder ecosystem, public results library, news and media hub, and contact form.

## Local setup

Requirements are PHP 8.2+, Composer, Node.js 22.12+ and SQLite. Production can use MySQL or MariaDB through Laravel's database configuration.

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

Create the first main administrator interactively. The command prompts for credentials and creates or updates the account for the supplied email address.

```bash
php artisan valuemap:create-admin
```

Open `/login` and sign in, then go to `/admin`. `/admin/login` redirects to the same login page.

## Accounts and publication approval

- **Main administrator** approves account requests, assigns roles, manages content and approves publication.
- **Administrator** creates, edits and deletes content, and submits items for publication approval.
- **Reader** signs in with an approved account and has no content management access.

New account requests require approval by the main administrator. Administrators can manage news, events, newsletters, press items, deliverables, publications and other project outputs, including document and image uploads.

## Publish a news item

1. Open **Add content +** and select **News** under **Content type**.
2. Enter the title, short description and full content. The short description appears separately above the article body, so avoid repeating it at the beginning of the full content.
3. Add the responsible partner, category and cover image as needed. Cover images support JPG, PNG and WebP up to 5 MB. Documents support PDF, Word, Excel, PowerPoint and ZIP up to 20 MB.
4. Under **Publication details**, choose **Published** and check **Make this item publicly visible**.
5. Leave **Publication date** empty or choose today's date or an earlier date for immediate publication. A future date schedules the item after approval.
6. Click **Create content**. A main administrator's submission is approved immediately. An administrator's submission appears under **Awaiting approval**, where the main administrator can review it and click **Approve**.
7. Confirm that the **Visibility** column shows **Public**, then use **View** or open `/news-media` to check the article.

The message **Content item created** confirms that the item was saved. Public visibility also requires a status other than Draft, the public visibility checkbox, approval and a publication date that has been reached or is empty. New forms default to Draft with public visibility unchecked.

Use **Edit / review** to update an existing item and **Save changes** to save it. Edits made by an administrator to a public item hide it until the main administrator approves it again. Changing the title preserves the article URL. **Delete** removes the item and its uploaded files.

If an item appears missing in the admin list, open **All** and clear the approval filter. The **Visibility** column distinguishes **Draft**, **Hidden**, **Awaiting approval**, **Not approved**, **Scheduled** and **Public**.

## Optional news draft assistant

Set `GEMINI_API_KEY` in the server environment to enable the AI news assistant in the content form. `GEMINI_NEWS_MODEL` selects the model. The assistant generates an English draft from source notes. Review the facts before saving and publishing through the normal approval flow.

## Analytics and production settings

Set these values in the production `.env` file:

```env
APP_NAME=ValueMap
APP_ENV=production
APP_DEBUG=false
APP_URL=https://valuemap-project.eu
GA_MEASUREMENT_ID=G-XXXXXXXXXX
```

Configure the production database and mail settings in `.env`. Set `CONTACT_MAIL_TO` to the contact-message recipient. The default `MAIL_MAILER=log` writes messages to logs. Configure a delivery mailer for contact notifications and newsletter confirmation emails.

Run migrations with `php artisan migrate --force`, build assets with `npm ci` and `npm run build`, and run `php artisan storage:link` so uploaded images and documents are publicly accessible. Ensure `storage` and `bootstrap/cache` are writable by the web server. Run `php artisan optimize` after production configuration changes. Point the web server document root to the Laravel `public` directory.

## Import a news update

Back up the database before importing SQL. In phpMyAdmin, select the existing project database, open **Import**, choose the intended `.sql` file and use the SQL format. Word documents are source material for articles and cannot be imported as SQL.

Review each script before importing it. A targeted news update should match the existing article by its unique slug and change only the intended fields. Check the public article after importing.

## Verification

Run the application test suite with `composer test` and verify the frontend build with `npm run build`.
