# Definir a imagem base
FROM php:8.2-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev git zip default-mysql-client

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar o projeto para o contêiner
COPY . .

# Instalar dependências
RUN composer install

# Definir permissões
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]