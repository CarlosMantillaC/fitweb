FROM php:8.2-apache

# 1. Instalar dependencias y extensiones de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Copiar solo los archivos del backend (no el frontend)
COPY . /var/www/html/

# 3. Habilitar mod_rewrite de Apache (para URLs amigables)
RUN a2enmod rewrite

# 4. Exponer el puerto 80 (HTTP)
EXPOSE 80

# 5. Configurar Apache para usar el puerto de Render
ENV APACHE_PORT $PORT
RUN sed -i "s/Listen 80/Listen ${APACHE_PORT}/" /etc/apache2/ports.conf