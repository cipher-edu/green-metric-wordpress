FROM php:8.2-apache

# WordPress uchun kerakli PHP kengaytmalarini o'rnatish
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libmagickwand-dev \
    unzip \
    wget \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        mysqli \
        opcache \
        pdo_mysql \
        soap \
        zip \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Apache mod_rewrite yoqish
RUN a2enmod rewrite

# PHP konfiguratsiyasini sozlash
RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini \
    && echo 'upload_max_filesize = 128M' >> /usr/local/etc/php/conf.d/docker-php-uploads.ini \
    && echo 'post_max_size = 128M' >> /usr/local/etc/php/conf.d/docker-php-uploads.ini \
    && echo 'max_execution_time = 600' >> /usr/local/etc/php/conf.d/docker-php-timeout.ini \
    && echo 'max_input_vars = 3000' >> /usr/local/etc/php/conf.d/docker-php-vars.ini \
    && echo 'max_input_time = 300' >> /usr/local/etc/php/conf.d/docker-php-timeout.ini

# Apache konfiguratsiyasini sozlash
RUN echo '<Directory /var/www/html>' >> /etc/apache2/apache2.conf \
    && echo '    AllowOverride All' >> /etc/apache2/apache2.conf \
    && echo '</Directory>' >> /etc/apache2/apache2.conf

# WordPress fayllarni nusxalash
COPY . /var/www/html/

# Fayllar uchun ruxsatlar berish va kerakli jildlarni yaratish
RUN mkdir -p /var/www/html/wp-content/uploads \
    && mkdir -p /var/www/html/wp-content/plugins \
    && mkdir -p /var/www/html/wp-content/themes \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/wp-content

# 80-portni ochish
EXPOSE 80
