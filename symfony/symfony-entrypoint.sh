composer install --no-scripts;

${PROJECT_DIR}/bin/console doctrine:migrations:migrate;

php-fpm -F -R;