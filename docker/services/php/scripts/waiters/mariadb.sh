#!/bin/bash -e
echo "INFO: Waiting for mariadb.."

HOST=mariadb-hzp
PORT=3306
TIMEOUT=30

wait-for-it --host=$HOST --port=$PORT --timeout=$TIMEOUT
