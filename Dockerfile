
FROM php:8.4-cli-bookworm


WORKDIR /app


RUN apt update && apt install -y \
    libonig-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install mysqli pdo_mysql

COPY . /app

# 启动命令：使用 PHP 内置 Web 服务器
# Railway 会自动将 $PORT 注入到环境中
CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]
