# Curso PHP Conference 2025

## Instalação

```bash
WWW_DATA_DIRS=(public/packages/uploads)
mkdir -p ~/.docker_cache/{wp-cli,composer} .config/chromium public/packages/plugins/curso-php-conference-2025 ${WWW_DATA_DIRS[@]}
sudo setfacl -R -m u:82:rwx ${WWW_DATA_DIRS[@]} && sudo setfacl -Rd -m u:82:rwx ${WWW_DATA_DIRS[@]}
sudo setfacl -R -m u:${USER}:rwx ${WWW_DATA_DIRS[@]} && sudo setfacl -Rd -m u:${USER}:rwx ${WWW_DATA_DIRS[@]}
cp .env.example .env
docker compose build
docker compose run --rm -u $(id -u):$(id -g) php composer install
docker compose run --rm -u $(id -u):$(id -g) -v $(pwd)/plugin:/app php composer install
docker compose run --rm -u $(id -u):$(id -g) node npm install
docker compose run --rm -u $(id -u):$(id -g) node npm run build
docker compose up -d db
docker compose run --rm -u $(id -u):$(id -g) installer
```

## Execução

```bash
docker compose up -d server
```

## Desenvolvimento front-end

```bash
docker compose run --rm -u $(id -u):$(id -g) node npm run start
```

## Qualidade

### Testes

Rodar a construção de desenvolvimento antes.

```bash
docker compose run --rm -u $(id -u):$(id -g) \
    -e DB_ENGINE=sqlite \
    -e HOME_URL=http://localhost:12483 \
    -e IS_TESTING=1 \
    installer
```

Execução dos testes

```bash 
docker compose run --rm -u $(id -u):$(id -g) \
    -e DB_ENGINE=sqlite \
    -e HOME_URL=http://localhost:12483 \
    php vendor/bin/codecept run EndToEnd
```

### Rector

```bash
docker compose run --rm -u $(id -u):$(id -g) php vendor/bin/rector process
```

### PHPStan

```bash
docker compose run --rm -u $(id -u):$(id -g) php vendor/bin/phpstan --memory-limit=512G
```
