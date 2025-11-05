# Curso PHP Conference 2025

## Instalação

```bash
mkdir -p ~/.docker_cache/{wp-cli,composer}
docker compose build
docker compose run --rm -u $(id -u):$(id -g) php composer install
```

## Execução

```bash
docker compose up -d server
```

## Validação

Servidor rodando com PHP.

```bash
$ curl -Is http://localhost | grep -E '(Location)'
Location: http://localhost/wp/wp-admin/setup-config.php
```
