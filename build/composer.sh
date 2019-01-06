docker run \
    --rm \
    --interactive \
    --volume /$(pwd)://var/www/html \
    --workdir //var/www/html \
    --env LOGGING_HOST= \
    --env LOGGING_PORT= \
    composer $@
