# ToDo List

## Development

### Installation

1. (Optional) If you need to change `docker-compose.yml`, create `docker-compose.override.yml` file from `docker-compose.yml`.
   See [How to share Compose configurations between files and projects](https://docs.docker.com/compose/extends) for more info.

2. Run containers (ad 1. with `-f docker-compose.override.yml`):
   ```sh
   $ docker-compose up -d
   ```

3. Go to http://localhost:8080/api

### PHP Static Analysis

Simply run:
```sh
$ docker-compose exec app php vendor/bin/phpstan analyse
```

### Testing
Simply run:
```sh
$ docker-compose exec app php bin/phpunit
```

1. Build application:
   ```sh
   $ docker-compose -f docker-compose.build.yml build --pull
   ```

2. Run containers:
   ```sh
   $ docker-compose -f docker-compose.production.yml up -d
   ```

3. Go to http://localhost:8080/api

## Build

```sh
$ docker-compose -f docker-compose.build.yml build --pull
```
