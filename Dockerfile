# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalación de dependencias necesarias (como root)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar la extensión bcmath
RUN docker-php-ext-install bcmath pdo_mysql

# Crear y dar permisos al directorio de build
RUN mkdir -p /var/www/html/public/build && \
    chown -R www-data:www-data /var/www/html/public/build && \
    chmod -R 775 /var/www/html/public/build

# Instalar Node.js y npm (versión 20.x)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Habilitar la extensión GD (con soporte para FreeType y JPEG)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Configuración de Apache para permitir el uso de .htaccess
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/000-default.conf

# Instalar Composer (gestor de dependencias de PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cambiar al directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html

# Instalar dependencias de PHP y compilar assets
RUN composer install
RUN npm install --legacy-peer-deps


# Cambiar los permisos del directorio para que Apache tenga acceso
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Exponer el puerto 80 para que Apache esté accesible
EXPOSE 80


