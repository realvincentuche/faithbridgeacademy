# Faith Bridge Academy — classic WordPress theme + auto-deploy to Namecheap

Classic (non-block) custom theme. Coming-soon v1 homepage in git, optional
live DB content section per template, blog fully DB-driven.

## Local dev (Herd)

Site: https://faithbridgeacademy.test (SQLite file DB — no MySQL needed locally).
Live Namecheap uses its own MySQL `wp-config.php` — never committed.

## Push to GitHub (first time)

```powershell
git remote add origin https://github.com/YOU/faithbridgeacademy.git
git push -u origin main
```

Only `wp-content/themes/faithbridgeacademy/` + `.github/` are tracked (see `.gitignore`).

## Auto-sync to Namecheap (Option B, prod-only)

1. Namecheap cPanel: install WordPress (Softaculous) into `public_html`,
   then Appearance > Themes > activate **Faith Bridge Academy**.
2. GitHub repo > Settings > Secrets and variables > Actions > add:
   - `FTP_SERVER` (e.g. `ftp.yourdomain.com`)
   - `FTP_USERNAME` (from cPanel > FTP Accounts)
   - `FTP_PASSWORD`
3. Every push to `main` touching the theme runs PHP lint, then FTPS-uploads
   to `public_html/wp-content/themes/faithbridgeacademy/`.

## Rules

- Edit theme code here, push, let Actions deploy. Never edit theme PHP in
  cPanel File Manager — the next push overwrites it.
- Page text/shortcodes/Contact Form 7/chat plugins live in the DB on
  Namecheap — deploys never touch them.
