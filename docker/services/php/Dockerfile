FROM php:7.4-fpm-buster

# Get latest packages
RUN apt-get update

# Install system packages
ARG apt_get_install="apt-get install -y --no-install-recommends"
RUN $apt_get_install curl
RUN $apt_get_install wget
RUN $apt_get_install git
RUN $apt_get_install vim
RUN $apt_get_install nano
RUN $apt_get_install zip
RUN $apt_get_install unzip
RUN $apt_get_install apt-utils
RUN $apt_get_install ca-certificates
RUN $apt_get_install wait-for-it
RUN $apt_get_install cron
RUN $apt_get_install g++
RUN $apt_get_install zlib1g-dev
RUN $apt_get_install libzip-dev
RUN $apt_get_install libonig-dev
RUN $apt_get_install libicu-dev
RUN $apt_get_install libbz2-dev

# Install PHP extensions
ARG php_ext_install="docker-php-ext-install"
RUN $php_ext_install pdo_mysql
RUN $php_ext_install intl
RUN $php_ext_install bz2
RUN $php_ext_install zip
RUN $php_ext_install opcache

# Configure for service
ADD config "$PHP_INI_DIR/conf.d"
RUN ln -s "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN usermod -u 1000 www-data

# Install Composer: https://getcomposer.org/download/
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN chmod 755 /usr/local/bin/composer

# Install Node.js: https://github.com/nodesource/distributions#debinstall
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN $apt_get_install nodejs

# Configure miscellaneous settings
RUN ln -snf /usr/share/zoneinfo/Europe/Prague /etc/localtime
RUN echo 'alias ll="ls -alk"' >> ~/.bashrc

# Expose ports to Docker network
EXPOSE 9000
