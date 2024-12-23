# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip unzip git \
    && docker-php-ext-install intl pdo pdo_mysql opcache \
    && docker-php-ext-enable intl opcache

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le projet dans le conteneur
COPY . /var/www/html/

# Configurer le répertoire de l'application
WORKDIR /var/www/html/

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Activer le module rewrite d'Apache
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80

# Lancer le serveur Apache
CMD ["apache2-foreground"]
