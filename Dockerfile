
FROM php:8.4-cli-bookworm 


WORKDIR /app


RUN apt update && apt install -y \
    libonig-dev \
    libzip-dev \
    libmariadb-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install mysqli pdo pdo_mysql

COPY . /app


EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]