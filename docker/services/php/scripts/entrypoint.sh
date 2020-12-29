#!/bin/bash -e
echo "===== Running entrypoint script ====="

# Define paths
PROJECT_ROOT=$(realpath ..)
APP_DIR=$PROJECT_ROOT/app
BIN_DIR=$PROJECT_ROOT/bin/php
DOCKER_SCRIPTS_DIR=$PROJECT_ROOT/docker/services/php/scripts/
WAITERS_DIR=$DOCKER_SCRIPTS_DIR/waiters

# Switch to project directory for easier handling
cd $PROJECT_ROOT
echo "INFO: Current working directory: $PROJECT_ROOT"

# Run service waiters
$WAITERS_DIR/mariadb.sh

# Run scripts after services are available
$BIN_DIR/init.sh

# Return to application directory
cd $APP_DIR
echo "INFO: Current working directory: $APP_DIR"

echo "===== Finished entrypoint script ====="

# Delegate current command
exec "$@"
