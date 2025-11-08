# Curso PHP Conference 2025

## Instalação

```bash
mkdir -p ~/.docker_cache/{wp-cli,composer} public/packages/plugins/curso-php-conference-2025
cp .env.example .env
docker compose build
docker compose run --rm -u $(id -u):$(id -g) php composer install
docker compose run --rm -u $(id -u):$(id -g) installer
```

## Execução

```bash
docker compose up -d server
```

## Validação

Servidor rodando com PHP e Xdebug integrado com VSCode.

### Validação da instalação

```bash
$ docker compose exec fpm php-fpm -i | grep xdebug.mode
             Enabled Features (through 'xdebug.mode' setting)             
xdebug.mode => off => off
$ docker compose run --rm -u $(id -u):$(id -g) php php -i | grep xdebug.mode
             Enabled Features (through 'xdebug.mode' setting)             
xdebug.mode => off => off
```

### Validação da configuração

Altere o valor de `PHP_XDEBUG_MODE` para `debug` no arquivo `.env`.

Para validar a configuração é necessário adicionar um breakpoint na linha 3 (`define( 'WP_USE_THEMES', true );`), pressionar F5 para iniciar a depuração no VSCode.

Ao executar o comando abaixo, a execução deve parar no breakpoint adicionado.

```bash
curl -s http://localhost > /dev/null
docker compose run --rm -u $(id -u):$(id -g) php php public/index.php > /dev/null 2>&1
```
