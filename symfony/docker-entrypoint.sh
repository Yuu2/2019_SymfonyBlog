composer install --no-scripts;

# CKEIDTOR / ELFINDER
if [ ! -d "${APP_VIRTUAL}/public/bundles" ]; then
  mkdir ${APP_VIRTUAL}/public/bundles
  
  bin/console ckeditor:install && bin/console assets:install public
  bin/console elfinder:install

  cp ${APP_VIRTUAL}/public/plugins ${APP_VIRTUAL}/public/bundles
fi

# Doctrine Migrations
bin/console make:migration && bin/console doctrine:migrations:migrate -n;

php-fpm;