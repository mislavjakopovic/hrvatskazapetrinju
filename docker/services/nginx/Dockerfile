FROM debian:buster

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

# Install NGINX
ARG apt_get_install="apt-get install -y --no-install-recommends --ignore-missing --fix-missing"
RUN $apt_get_install nginx

# Configure for service
RUN usermod -u 1000 www-data

# Configure miscellaneous settings
RUN ln -snf /usr/share/zoneinfo/Europe/Prague /etc/localtime
RUN echo 'alias ll="ls -alk"' >> ~/.bashrc

# Expose ports to Docker network
EXPOSE 80
EXPOSE 443
