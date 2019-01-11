#!/bin/sh
set -e
cd /app
exec php ./vendor/bin/luya "$@"
