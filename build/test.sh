docker run \
    --rm \
    --interactive \
    --volume /$(pwd)://var/www/html \
    --workdir //var/www/html \
    --env LOGGING_HOST= \
    --env LOGGING_PORT= \
    --entrypoint php \
    php:7.1.8-apache vendor/phpunit/phpunit/phpunit tests
