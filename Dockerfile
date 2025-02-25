FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar los archivos al contenedor
COPY . /var/www/html/

# Exponer el puerto 80
EXPOSE 80