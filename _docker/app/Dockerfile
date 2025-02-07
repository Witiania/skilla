FROM php:8.3-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    curl \
    git \
    zip \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libmagickwand-dev --no-install-recommends \
    libpq-dev \
    libonig-dev \
    libzip-dev && \
    rm -rf /var/lib/apt/lists/*

# Установка и настройка GD с поддержкой FreeType и JPEG
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Установка и настройка ImageMagick
RUN git clone https://github.com/Imagick/imagick.git /usr/src/imagick && \
    cd /usr/src/imagick && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    docker-php-ext-enable imagick

# Установка расширений для Laravel
RUN docker-php-ext-install pdo pdo_pgsql bcmath mbstring exif opcache zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Создание директории .composer и настройка прав
RUN mkdir -p /var/www/.composer /var/www/.composer/cache && \
    chown -R www-data:www-data /var/www && \
    composer config --global cache-dir /tmp/.composer/cache

# Настройка пользователя
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Переключение на пользователя www-data
USER www-data

WORKDIR /var/www

# Установка директории кеша Composer
ENV COMPOSER_CACHE_DIR="/tmp/.composer/cache"

# Запуск PHP-FPM
ENTRYPOINT ["php-fpm"]
