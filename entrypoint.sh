#!/bin/bash

# Récupère le port donné par Railway (ou utilise 8080 par défaut)
PORT=${PORT:-8080}

# Remplace le port 80 dans la config Apache
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf
sed -i "s/80/${PORT}/g" /etc/apache2/sites-enabled/000-default.conf

# Assure que le dossier 'public' est bien le DocumentRoot
sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Démarre Apache en mode foreground
exec apache2-foreground
