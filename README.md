# test-logistics

## start 

### with docker-compose

Установить нужный порт в .env (по умолчанию 8081)

docker-compose up -d

docker-compose exec -u app app composer install

### without docker

cd proj_id

composer install

php -S


### routes
POST /delivery/fast - быстрая доставка

POST /deliver/slow - медленная

POST /delivery/offer - результат
  в теле запроса любой оффер
