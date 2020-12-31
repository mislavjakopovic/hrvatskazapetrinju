#!/bin/bash -e
echo "===== Running entrypoint script ====="

# Define paths
PROJECT_ROOT=$(realpath ..)
APP_DIR=$PROJECT_ROOT/app
BIN_DIR=$PROJECT_ROOT/bin/nginx
DOCKER_SCRIPTS_DIR=$PROJECT_ROOT/docker/services/entrypoint/scripts/

# Switch to project directory for easier handling
cd $PROJECT_ROOT
echo "INFO: Current working directory: $PROJECT_ROOT"

# Run scripts after services are available
$BIN_DIR/init.sh

# Return to application directory
cd $APP_DIR
echo "INFO: Current working directory: $APP_DIR"

echo "===== Finished entrypoint script ====="

# Delegate current command
exec "$@"
