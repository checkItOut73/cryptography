docker run \
    --rm \
    --interactive \
    --volume /$(pwd)://var/www/html \
    --workdir //var/www/html \
    --entrypoint npm \
    node:10.15 $@
