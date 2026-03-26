FROM php:8.2-fpm

# تثبيت الاعتمادات
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx libpq-dev

# تثبيت إضافات PHP الضرورية (أضفنا pdo_pgsql لقاعدة بيانات Render)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# تثبيت المكتبات وبناء الملفات
RUN composer install --no-dev --optimize-autoloader
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs
RUN npm install && npm run build

# ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# تشغيل السيرفر وتنفيذ الهجرة تلقائياً
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000