FROM php:8.1.1-apache

# Install packages and PHP extensions
RUN apt update \
    # common libraries and extensions
    && apt install -y git acl openssl openssh-client wget zip \
    && apt install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    && docker-php-ext-install intl pdo gd zip \
    # for MySQL
    && docker-php-ext-install pdo_mysql \
    # APCu
    && pecl install apcu \
    # enable Docker extensions
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache apcu

# Install and update composer
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
COPY ./composer.* /var/www/html/
RUN composer install --prefer-dist --no-scripts --no-interaction --no-dev

## Copy project content
COPY . /var/www/html/
RUN #/var/www/html/bin/console a:i

RUN mkdir -p /var/www/html/var
RUN chown -R www-data:www-data /var/www/html/var

# Install NODE 14 and Yarn
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt -y install nodejs
RUN curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt update && apt install yarn

RUN yarn && yarn build && yarn start

# Update Apache config
COPY ./docker/php/default.conf /etc/apache2/sites-available/default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && a2dissite 000-default \
    && a2ensite default \
    && service apache2 restart

# Modify upload file size
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

EXPOSE 80