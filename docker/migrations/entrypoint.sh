#!/bin/bash

set -e

echo "Running migrations"

DATABASE_URL_TEST_PROJECT_DB=mysql://$MYSQL_USER:$MYSQL_PASSWORD@$DB_HOST:$DB_PORT/test_project
DATABASE_URL=$DATABASE_URL_TEST_PROJECT_DB dbmate --migrations-dir ./migrations --no-dump-schema --wait up

echo "DB mate migrations completed with success"

tail -f /var/log/*
