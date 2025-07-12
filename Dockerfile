# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Active mod_rewrite pour Laravel
RUN a2enmod rewrite

# Copie le code source dans le conteneur
COPY . /var/www/html

# Définit le répertoire de travail
WORKDIR /var/www/html

# Installe Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Installe les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Donne les bons droits aux dossiers de cache Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose le port 80
EXPOSE 80

# Commande de démarrage
CMD ["apache2-foreground"] 