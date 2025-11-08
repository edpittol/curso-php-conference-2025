# Curso PHP Conference 2025

## Instalação

```bash
mkdir -p ~/.docker_cache/{wp-cli,composer} public/packages/plugins/curso-php-conference-2025
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
$ docker compose run --rm -u $(id -u):$(id -g) php wp plugin list
+---------------------------+--------+--------+---------+----------------+-------------+
| name                      | status | update | version | update_version | auto_update |
+---------------------------+--------+--------+---------+----------------+-------------+
| curso-php-conference-2025 | active | none   | 1.0.0   |                | off         |
+---------------------------+--------+--------+---------+----------------+-------------+
```
