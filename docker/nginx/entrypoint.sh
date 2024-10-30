#!/bin/bash

# exits if a command returns a non-zero value
set -e

# 
apt-get update
apt-get install -y wait-for-it

# wait for the server 
wait-for-it --timeout=600 api.up2you.test.project:80

nginx -g "daemon off;"
