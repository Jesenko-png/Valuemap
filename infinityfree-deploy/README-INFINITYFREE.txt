VALUEMAP - INFINITYFREE UPLOAD

Upload the contents of htdocs to the hosting account's htdocs folder.
Upload the valuemap-app folder next to htdocs, at the FTP account root.

Do not upload a local .env file. Rename .env.infinityfree.example to .env inside
valuemap-app on the server, then fill in a new APP_KEY, APP_URL, MySQL and SMTP values.

Before first launch:
1. Create a MySQL database in the InfinityFree panel.
2. Import database-mysql-clean.sql through phpMyAdmin. It contains the schema and safe starter data, but no local users, sessions or cache records.
3. Copy storage/app/public into htdocs/storage if uploaded files exist.
4. Check that htdocs/index.php points to ../valuemap-app.
5. Set APP_DEBUG=false and clear any cached config made for local development.
6. Add a NEW production GEMINI_API_KEY to valuemap-app/.env if the AI news assistant should work online. Never reuse or upload the exposed local key.

The package already has no local config.php cache. If you change .env later,
remove valuemap-app/bootstrap/cache/config.php if it exists.

The deployment package includes vendor generated locally with --no-dev and the
already-built public/build assets. Node.js and Composer are not needed on the host.

The local development project is outside this package and is not changed by FTP.
