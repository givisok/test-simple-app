# Тестовое задание simple store
Реализация на vue 2 + laravel 5.5

## Disclaimer :)
Для упрощения работы, взял готовые компоненты для работы со stripe.

Еще одно допущение, после неудачной оплаты корзина не сбрасывается.
По хорошему нужно создавать номер заказа в сессии прокидывать его наверх и платить по нему еще раз.
Но приложение простое...

Для работы проекта необходим `docker`.

`make start` - развертывание окружения в режиме продакшена

`make start-dev` - развертывание окружения в режиме dev - тут работает xdebug
`make shell` или `make shell-dev` - для входа в PHP-Cli проекта

`make node-install` - выполнение `npm install`
`make node-compile-dev` - компиляция scss и js 
`make shell-node` - для входа в node-cli
`make phpunit` - выполнение unit тестов

и много еще чего полезного можно найти в `Makefile`

После изменений в конфиге nginx выполнить `make stop && docker-compose build nginx-dev && make start-dev`

Для разварачивания проекта первый раз необходимо выполнить
`make start && make shell`
`composer install && php artisan migrate:refresh --seed`

#### Настройка nginx для доступа к сайту по нормальному имени

```
server {
    server_name test-simple-store.su;
    listen 80;

    location / {
        proxy_pass              http://localhost:60080;
        proxy_set_header Host   test-simple-store.su;
    }
}
```

###Настройка дебаг сессии
PhpStorm перейдите во вкладку Language & frameworks -> php -> servers
Для localhost настройки mapping. app/app -> app/htdocs/