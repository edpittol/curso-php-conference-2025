# Curso PHP Conference 2025

## Instalação

```bash
docker compose build
```

## Execução

```bash
docker compose up -d server
```

## Validação

Servidor rodando com PHP.

```bash
$ curl -Is http://localhost | grep -E '(HTTP|nginx|PHP)'
HTTP/1.1 200 OK
Server: nginx/1.28.0
X-Powered-By: PHP/8.4.15
```
