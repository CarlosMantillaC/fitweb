# Usar la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar el código PHP
COPY index.php /var/www/html/

# Configurar el puerto y permisos
EXPOSE 80
CMD ["apache2-foreground"]