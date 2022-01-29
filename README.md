# Laravel example api + Swagger docs

## First setup for Docker
- Required docker
- Create .env `cp .env.example .env`
- Run command for install package (replace **/path/to** with your path)
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/path/to/laravel-full-stack \
    -w /path/to/laravel-full-stack \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
- Run command `./vendor/bin/sail up` for develop, or see config alias [here](https://laravel.com/docs/8.x/sail#configuring-a-bash-alias)
- Run command `./vendor/bin/sail artisan key:gen`
- Run command `./vendor/bin/sail artisan migrate --seed`
- See more about sail [here](https://laravel.com/docs/8.x/sail)

## URL for using docker
- App: http://localhost
- phpMyAdmin: http://localhost:8081
- MailHog: http://localhost:8025
- Api documents: http://localhost/api/documentation
