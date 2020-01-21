FROM php:7.3-fpm

RUN apt-get update && apt-get -y --no-install-recommends install \
    ca-certificates \
    git\
    curl\
    joe\
    wget\
    unzip\
    sudo

RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer && \
    composer global require hirak/prestissimo --no-plugins --no-scripts

RUN ln -snf /usr/share/zoneinfo/Europe/Amsterdam /etc/localtime

