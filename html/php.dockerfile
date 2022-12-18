FROM php:8.0.16-fpm-alpine3.14

ARG PHPGROUP
ARG PHPUSER

ENV PHPGROUP=${PHPGROUP}
ENV PHPUSER=${PHPUSER}

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}; exit 0

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN apk add --update \
		$PHPIZE_DEPS \
		php \
		php-ctype \
		php-curl \
		php-xml \
		php-fileinfo \
		php-gd \
		php-json\
		php-mbstring \
		php-pdo \
		php-zip \
		git \
		libjpeg-turbo-dev \
		libpng-dev \
		libxml2-dev \
		libzip-dev \
		openssh-client \
		php7-json \
		php7-openssl \
		php7-pdo \
		php7-pdo_mysql \
		php7-session \
		php7-simplexml \
		php7-tokenizer \
		php7-xml \
		imagemagick \
		imagemagick-libs \
		imagemagick-dev \
		php7-imagick \
		php7-pcntl \
		php7-zip \
		gd \
		freetype 


RUN printf "\n" | pecl install \
		imagick && \
		#sockets \
		docker-php-ext-enable --ini-name 20-imagick.ini imagick

RUN printf "\n" | pecl install \
		pcov && \
		docker-php-ext-enable pcov

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php composer-setup.php \
	&& php -r "unlink('composer-setup.php');" \
	&& mv composer.phar /usr/bin/composer

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis


RUN apk add --no-cache --virtual build-essentials \
icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev && \
docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
docker-php-ext-install gd && \
docker-php-ext-install mysqli && \
docker-php-ext-install pdo_mysql && \
docker-php-ext-install exif && \
docker-php-ext-install zip 
#apk del build-essentials && rm -rf /usr/src/php*

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
