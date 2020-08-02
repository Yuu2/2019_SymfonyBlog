composer install --no-scripts;

# CKEIDTOR / ELFINDER
if [ ! -d "${PROJECT_DIR}/public/bundles" ]; then
  mkdir {$PROJECT_DIR}/public/bundles
  
  bin/console ckeditor:install && bin/console assets:install public
  bin/console elfinder:install

  cp ${PROJECT_DIR}/public/plugins ${PROJECT_DIR}/public/bundles
fi

# Doctrine Migrations
bin/console make:migration && bin/console doctrine:migrations:migrate -n;

php-fpm;