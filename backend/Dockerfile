# Imagen base correcta
FROM php:8.2-apache

# Instalar extensiones de PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite en Apache para que .htaccess funcione
RUN a2enmod rewrite

# Copiar archivos del backend al contenedor
COPY . /var/www/html/

# Configurar Apache para permitir .htaccess
RUN echo "<Directory /var/www/html/>
    AllowOverride All
    Require all granted
</Directory>" > /etc/apache2/sites-available/000-default.conf

# Reiniciar Apache para aplicar cambios
RUN service apache2 restart

# Exponer el puerto 80
EXPOSE 80
