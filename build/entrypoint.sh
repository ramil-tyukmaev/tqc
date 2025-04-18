service nginx start
service supervisor start
service cron start
supervisorctl start "laravel-worker:*"
php-fpm
