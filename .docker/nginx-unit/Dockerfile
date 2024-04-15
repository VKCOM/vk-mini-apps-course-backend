FROM nginx/unit:1.29.1-php8.1

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./*.pem /docker-entrypoint.d/
COPY ./*.json /docker-entrypoint.d/
COPY ./*.sh /docker-entrypoint.d/

ARG SITE_PATH=/var/www/html

USER root

RUN mkdir -p ${SITE_PATH} && \
chown -R unit:unit ${SITE_PATH} && \
chmod -R 775 ${SITE_PATH}

WORKDIR ${SITE_PATH}
