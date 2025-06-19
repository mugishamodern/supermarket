# 🚀 Deploying Mukora Supermarket Laravel App to Render.com (Free, SQLite)

This guide will help you deploy your Laravel project to Render.com for a free, public demo using SQLite. It includes all production best practices and Render-specific steps.

---

## 1. Prepare Your Project Locally

### A. Set Up Production Environment Variables
1. Copy your `.env` to `.env.production`:
   ```sh
   cp .env .env.production
   ```
2. Edit `.env.production`:
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Set a strong `APP_KEY` (copy from your local .env)
   - Set `DB_CONNECTION=sqlite`
   - Set `DB_DATABASE=/data/database.sqlite`
   - Set mail and other production settings as needed

### B. Build Frontend Assets
```sh
npm install
npm run build
```

### C. Commit All Changes
```sh
git add .
git commit -m "Prepare for Render.com deployment"
```

---

## 2. Push to GitHub
1. Create a new repo on GitHub (if not already):
   - https://github.com/mugishamodern/your-repo-name
2. Push your code:
   ```sh
   git remote add origin https://github.com/mugishamodern/your-repo-name.git
   git push -u origin master
   ```

---

## 3. Deploy on Render.com
1. Go to [https://dashboard.render.com/](https://dashboard.render.com/)
2. Click **"New Web Service"** and connect your GitHub.
3. Select your repo.
4. Fill in the settings:
   - **Environment:** PHP
   - **Build Command:**
     ```sh
     composer install --optimize-autoloader --no-dev && npm install && npm run build && php artisan migrate --force && php artisan storage:link
     ```
   - **Start Command:**
     ```sh
     php artisan serve --host 0.0.0.0 --port 10000
     ```
   - **Environment Variables:**
     - Copy from `.env.production` (especially `APP_KEY`, `APP_ENV`, `APP_DEBUG`, `DB_CONNECTION`, `DB_DATABASE`)
5. **Add a disk**:
   - Name: `data`
   - Mount Path: `/data`
   - Size: 1GB (free)
6. Click **Create Web Service** and wait for deployment.

---

## 4. After Deploy
- Visit your Render.com URL (e.g., `https://your-app.onrender.com`)
- Test all features (login, checkout, admin, uploads, etc.)
- You can delete the service after your demo.

---

## 5. Production Optimization Checklist
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`
- `composer install --optimize-autoloader --no-dev`
- `npm run build`
- `php artisan migrate --force`
- `php artisan storage:link`
- Set `APP_DEBUG=false` and `APP_ENV=production` in your environment variables

---

## 6. Notes
- SQLite database will persist as long as the Render disk exists.
- For file uploads, use the `/data` disk (already set up by default).
- For a real production launch, use a paid host and a real database (MySQL/Postgres).

---

**Happy Launching!** 🎉 