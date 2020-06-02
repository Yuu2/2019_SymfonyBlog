composer install --no-scripts;

cd ${PROJECT_DIR}

bin/console doctrine:migrations:migrate -n;

bin/console doctrine:fixtures:load -n;

php-fpm -F -R;