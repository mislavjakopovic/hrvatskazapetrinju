#!/bin/bash -e

APP_ENV=dev

# Define paths
PROJECT_ROOT=$(pwd)
APP_DIR=$PROJECT_ROOT/app

source $PROJECT_ROOT/bin/php/helpers.sh

info "Changing current working directory to application.."
run "cd $APP_DIR"

info "Installing dependencies.."
run "composer install && npm install"

info "Warming up cache.."
run "bin/console cache:warmup --env=$APP_ENV"

info "Creating assets.."
run "npm run dev && bin/console assets:install --env=$APP_ENV --symlink"

info "Initializing Doctrine.."
run "bin/console doctrine:migrations:migrate --env=$APP_ENV --no-interaction"

info "Setting user rights.."
run "chown -R www-data:www-data $APP_DIR"

info "Changing current working directory to project.."
run "cd $PROJECT_ROOT"
