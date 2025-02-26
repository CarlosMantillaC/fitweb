# Imagen base correcta
FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar archivos del backend al contenedor (desde la carpeta actual)
COPY . /var/www/html/

# Configurar puerto dinámico para Render
ENV APACHE_PORT=$PORT
RUN echo "Listen ${APACHE_PORT}" > /etc/apache2/ports.conf