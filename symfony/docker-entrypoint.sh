cd ${PROJECT_DIR}

composer install --no-scripts;

bin/console make:migration && bin/console doctrine:migrations:migrate -n;

# bin/console doctrine:fixtures:load -n;

bin/console froala:install && bin/console assets:install --symlink public

php-fpm;