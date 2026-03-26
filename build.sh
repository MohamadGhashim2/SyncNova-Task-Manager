#!/usr/bin/env bash
# exit on error
set -o errexit

# تثبيت مكتبات PHP
composer install --no-dev --optimize-autoloader

# تثبيت وبناء ملفات الـ CSS و JS (Tailwind/Vite)
npm install
npm run build

# تنفيذ عمليات الهجرة لقاعدة البيانات (تلقائياً عند كل رفع)
php artisan migrate --force