#!/bin/sh
rm -rf app/cache/*
chmod a+r+w -R app/cache
php app/console cache:warmup --env=prod --no-debug
php app/console assetic:dump --env=prod --no-debug
chmod a+r+w -R app/cache
chmod a+r+w -R app/logs