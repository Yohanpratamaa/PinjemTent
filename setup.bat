@echo off
echo 🚀 PinjemTent Development Setup for Windows

REM Check if composer is installed
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Composer is not installed or not in PATH
    echo Please install Composer from https://getcomposer.org/
    pause
    exit /b 1
)

REM Check if node is installed
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Node.js is not installed or not in PATH
    echo Please install Node.js from https://nodejs.org/
    pause
    exit /b 1
)

echo 📦 Installing Composer dependencies...
composer install --optimize-autoloader --ignore-platform-reqs
if %errorlevel% neq 0 (
    echo ❌ Failed to install Composer dependencies
    pause
    exit /b 1
)

echo 📦 Installing Node dependencies...
npm install
if %errorlevel% neq 0 (
    echo ❌ Failed to install Node dependencies
    pause
    exit /b 1
)

echo 🏗️ Building assets...
npm run build
if %errorlevel% neq 0 (
    echo ❌ Failed to build assets
    pause
    exit /b 1
)

echo 🔑 Checking APP_KEY...
if not exist .env (
    echo 📋 Creating .env file...
    copy .env.example .env
    php artisan key:generate
)

echo 🗃️ Running database migrations...
php artisan migrate:fresh --seed

echo ✅ Setup complete!
echo 🌐 You can now run: php artisan serve
pause
