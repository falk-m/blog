FROM oberd/php-8.2-apache:1695506520

RUN apt-get update && apt-get install --no-install-recommends -y \
     nano \
     git

RUN apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev


RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) gd 
RUN docker-php-ext-install exif
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN a2enmod headers

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

#enable public listing on Port 81
COPY 001-public.conf /etc/apache2/sites-available/
RUN echo 'Listen 81' >> /etc/apache2/ports.conf;
RUN a2ensite 001-public.conf

WORKDIR /var/www/html