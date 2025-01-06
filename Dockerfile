# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalación de dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar la extensión bcmath (ya incluida en PHP)
RUN docker-php-ext-install bcmath

# Habilitar la extensión GD (con soporte para FreeType y JPEG)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Cambiar los permisos del directorio para que Apache tenga acceso
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Configurar Apache para permitir el uso de .htaccess (Rewrite)
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/000-default.conf

# Configuración de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html

# Instalar Composer (gestor de dependencias de PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar las dependencias de PHP con Composer
RUN composer install

# Exponer el puerto 80 para que Apache esté accesible
EXPOSE 80

# Comando para iniciar Apache en primer plano
CMD ["apache2-foreground"]
