FROM php:7.4-apache

RUN a2enmod rewrite headers ssl

RUN apt-get update && apt-get install -y \
    vim \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN composer create-project --prefer-dist laravel/laravel:5.* /var/www/html

COPY ../src* /var/www/html

WORKDIR /var/www/html

RUN chmod -R 777 /var/www/html

COPY ./laravel58.conf /etc/apache2/sites-available

RUN a2ensite laravel58.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

CMD ["apache2-foreground"]