#!/bin/bash

# Installer les dépendances PHP
composer install --no-dev --optimize-autoloader

# Effacer et précompiler le cache Symfony
php bin/console cache:clear --env=prod

# Vérifiez si les clés JWT existent
if [ ! -f "config/jwt/private.pem" ] || [ ! -f "config/jwt/public.pem" ]; then
    echo "Les fichiers JWT ne sont pas présents."
    exit 1
fi
