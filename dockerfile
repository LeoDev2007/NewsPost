# Usar a imagem oficial do PHP com Apache e versão 8.2.12
FROM php:8.2.12-apache

# Copiar os arquivos da aplicação para o diretório padrão do Apache
COPY . /var/www/html/

# Instalar extensões ou dependências adicionais, se necessário
# RUN docker-php-ext-install pdo pdo_mysql

# Expor a porta 80 para o tráfego HTTP
EXPOSE 80
