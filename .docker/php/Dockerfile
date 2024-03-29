FROM php:8.1.0-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget nodejs zip unzip libpng-dev libzip4 libzip-dev \
    gnupg gnupg1 gnupg2 \
    zlib1g-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    sudo

##NODE + YARN
RUN apt-get install -y npm
RUN npm install -g n
RUN n 18.16.0
RUN npm install --global yarn
# https://symfony.com/doc/current/frontend/encore/installation.html
##NODE + YARN

RUN apt install -y libldap2-dev

RUN docker-php-ext-install pdo pdo_mysql zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY php.ini /usr/local/etc/php/php.ini
COPY php-fpm-pool.conf 	/usr/local/etc/php/pool.d/www.conf

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
    mv composer.phar /usr/local/bin/composer

RUN wget --no-check-certificate https://phar.phpunit.de/phpunit-9.5.26.phar && \
    mv phpunit*.phar phpunit.phar && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit

RUN	echo "deb https://deb.nodesource.com/node_9.x jessie main" >> /etc/apt/sources.list.d/nodejs.list && \
    wget -nv -O -  https://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add - && \
    echo "deb-src https://deb.nodesource.com/node_9.x jessie main" >> /etc/apt/sources.list.d/nodejs.list && \
    apt-get update && \
    apt-get install -y --force-yes nodejs && \
    rm -f /etc/apt/sources.list.d/nodejs.list

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m
RUN passwd -d dev

RUN rm -rf /var/lib/apt/lists/*
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

RUN echo "dev ALL=(ALL) ALL" > /etc/sudoers

WORKDIR /var/www/lpa_sf6
##</romaricp>##

EXPOSE 9000
CMD ["php-fpm"]
