#!/bin/bash

set -ex

# Aguarda conexão com banco de dados quando serviço de banco de dados é MySQL
if [ "1" == ${IS_TESTING:-0} ]; then
  vendor/bin/codecept dev:start
else
  while ! mariadb-admin ping -h ${MYSQL_HOST} -u ${MYSQL_USER} -p${MYSQL_PASSWORD} --silent; do
    echo 'Waiting database connection' && sleep 3
  done
fi

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

# Importa carga de demonstração do WooCommerce se ainda não possui produtos na base
if [[ "0" == $(wp post list --post_type=product --format=count) ]]; then
  wp plugin activate wordpress-importer
  wp import ./public/packages/plugins/woocommerce/sample-data/sample_products.xml --authors=skip
  wp plugin deactivate wordpress-importer
fi

# Sobreescreve options definidas em resources/data/options/
find resources/data/options/ -name "*.json" -exec bash -c 'cat {} | envsubst | wp option update $(basename {} .json) --format=json' \;
find resources/data/options/ -name "*.txt" -exec bash -c 'cat {} | envsubst | tr -d "\n" | wp option update $(basename {} .txt)' \;

if [ "1" == ${IS_TESTING:-0} ]; then
  sqlite3 public/packages/database/.ht.sqlite .dump > tests/Support/Data/dump.sql
fi
