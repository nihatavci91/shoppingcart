FROM php:7.4-fpm

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN apt-get update && apt-get install -y \
  build-essential \
  libpng-dev \
  libzip-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  libxml2-dev \
  locales \
  zip \
  jpegoptim optipng pngquant gifsicle \
  vim \
  unzip \
  wget \
  curl \
  gnupg2 \
  nodejs \
  npm

# Set working directory
WORKDIR /var/www

# Install extensions
RUN pecl install redis
RUN docker-php-ext-enable redis
RUN docker-php-ext-install pdo_mysql exif pcntl gd

# Copy existing application directory contents
COPY ./ /var/www/
RUN composer install

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
COPY --chown=www:www ./ /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
