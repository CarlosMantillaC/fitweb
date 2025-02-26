# Imagen base correcta
FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite para que .htaccess funcione
RUN a2enmod rewrite

# Copiar archivos del backend al contenedor
COPY . /var/www/html/

# Establecer permisos y configuración de Apache
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80
EXPOSE 80
