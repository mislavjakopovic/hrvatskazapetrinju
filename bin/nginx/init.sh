#!/bin/bash -e

# Define paths
PROJECT_ROOT=$(pwd)
APP_DIR=$PROJECT_ROOT/app

source $PROJECT_ROOT/bin/lib/helpers.sh

info "Soft linking web server config"
run "rm -rfv /etc/nginx/sites-enabled/*"
run "ln -sfv /etc/nginx/sites-available/app.$APP_ENV.conf /etc/nginx/sites-enabled/app.conf"

info "Changing current working directory to project.."
run "cd $PROJECT_ROOT"
