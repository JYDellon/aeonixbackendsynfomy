# #!/bin/bash

# # Installer les dépendances PHP
# composer install --no-dev --optimize-autoloader

# # Effacer et précompiler le cache Symfony
# php bin/console cache:clear --env=prod

# # Vérifiez si les clés JWT existent
# if [ ! -f "config/jwt/private.pem" ] || [ ! -f "config/jwt/public.pem" ]; then
#     echo "Les fichiers JWT ne sont pas présents."
#     exit 1
# fi














#!/bin/bash

# Installer les dépendances avec Composer
composer install --no-dev --optimize-autoloader

# Préparer le cache Symfony
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

# Vérifiez les permissions des fichiers et dossiers
chmod -R 775 var/cache var/log
