cd ${PROJECT_DIR}

composer install --no-scripts;

# CKEIDTOR / ELFINDER
if [ ! -d "${PROJECT_DIR}/public/bundles" ]; then
  bin/console ckeditor:install && bin/console assets:install public
  bin/console elfinder:install public
fi

# Doctrine Migrations
bin/console make:migration && bin/console doctrine:migrations:migrate -n;

php-fpm;