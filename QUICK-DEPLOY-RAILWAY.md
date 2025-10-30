# 🚀 Quick Deploy to Railway

## 📋 Prerequisites

-   [x] GitHub account
-   [x] Railway account ([railway.app](https://railway.app))
-   [x] Project pushed to GitHub

## ⚡ Quick Steps

### 1. **Deploy Application**

1. Go to [railway.app](https://railway.app) and login
2. Click **"New Project"**
3. Select **"Deploy from GitHub repo"**
4. Choose **PinjemTent** repository
5. Railway will auto-detect Laravel and start building

### 2. **Add Database**

1. In project dashboard → Click **"+ New"**
2. Select **"Database"** → **"Add MySQL"**
3. Wait for provisioning (~2-3 minutes)

### 3. **Configure Environment Variables**

Go to **Variables** tab and add:

```bash
# Required Variables
APP_NAME=PinjemTent
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (copy from MySQL addon)
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=6543
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_mysql_password

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public
```

### 4. **Generate APP_KEY**

```bash
# Run locally to generate key
php artisan key:generate --show

# Copy the output (base64:xxx...) to APP_KEY variable
```

### 5. **Deploy & Access**

1. Railway will automatically redeploy with new variables
2. Check **Deployments** tab for build progress
3. Once deployed, click **"View App"** to access your application

## 🎯 Default Login Credentials

After seeding (if enabled):

-   **Admin**: admin@example.com / password
-   **User**: user@example.com / password

## 🐛 Troubleshooting

**Build Failed?**

-   Check **Logs** tab for detailed error messages
-   Ensure all dependencies are in `composer.json`

**Database Connection Error?**

-   Verify database credentials in **Variables** tab
-   Check MySQL addon is running

**500 Error?**

-   Verify `APP_KEY` is set correctly
-   Check application logs for detailed errors

## 📞 Need Help?

Check the full guide in `DEPLOYMENT-RAILWAY.md` for detailed instructions.

---

**Total Time: ~10-15 minutes** ⏱️
