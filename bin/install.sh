#!/bin/bash

set -e

while ! mariadb-admin ping -h ${MYSQL_HOST} -u ${MYSQL_USER} -p${MYSQL_PASSWORD} --silent; do
echo 'Waiting database connection' && sleep 3
done

# Instala WordPress
if ! wp core is-installed; then
  wp core install --url=${HOME_URL} --title="Cuso PHP Conference 2025" --admin_user=admin --admin_password=admin --admin_email=admin@admin.com --skip-email
fi

# Remove arquivos de tradução para garantir que será instalada a última versão
rm -rf packages/languages

# Baixa tradução do WordPress e altera idioma padrão para Português (Brasil)
wp language core install pt_BR
wp site switch-language pt_BR

# Altera estrutura de URLs para o formato amigável para SEO
wp rewrite structure '/%postname%/'

# Ativa pacotes e baixa suas traduções
wp plugin activate --all
wp language plugin install pt_BR --all
wp theme activate storefront
wp language theme install pt_BR --all

# Atualiza banco de dados para última versão de pacotes
wp core update-db
