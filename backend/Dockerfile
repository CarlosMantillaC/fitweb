# Imagen base correcta
FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite en Apache para permitir .htaccess
RUN a2enmod rewrite

# Configurar Apache para permitir .htaccess
RUN echo '<Directory /var/www/html/>
    AllowOverride All
    Require all granted
</Directory>' > /etc/apache2/sites-available/000-default.conf

# Copiar archivos del backend al contenedor
COPY . /var/www/html/

# Establecer permisos correctos para Apache
RUN chown -R www-data:www-data /var/www/html

# Reiniciar Apache para aplicar los cambios
CMD ["apache2-foreground"]

# Exponer el puerto 80
EXPOSE 80
