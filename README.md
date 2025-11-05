# Curso PHP Conference 2025

## Instalação

```bash
mkdir -p ~/.docker_cache/{wp-cli,composer}
docker compose build
docker compose run --rm -u $(id -u):$(id -g) php composer install
docker compose run --rm -u $(id -u):$(id -g) installer
```

## Execução

```bash
docker compose up -d server
```

## Validação

Servidor rodando com PHP.

```bash
$ curl -Is http://localhost | grep -E '(Link)'
Link: <http://localhost/wp-json/>; rel="https://api.w.org/"
```
