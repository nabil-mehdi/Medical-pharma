FROM php:8.2-apache

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

RUN a2enmod rewrite

COPY . /var/www/html

WORKDIR /var/www/html

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN sed -i "s/80/8080/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Change le DocumentRoot dans UNE SEULE config
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN chmod -R 755 /var/www/html/public
RUN chown -R www-data:www-data /var/www/html/public

EXPOSE 8080

CMD php artisan storage:link && apache2-foreground