cd ${PROJECT_DIR}

composer install --no-scripts;

# CKEditor
bin/console ckeditor:install && bin/console assets:install public

# Elfinder
bin/console elfinder:install public

# Doctrine Migrations
bin/console make:migration && bin/console doctrine:migrations:migrate -n;

php-fpm;