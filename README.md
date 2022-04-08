# test-logistics

## start 

git clone git@github.com:tim31al/test-logistics.git my_dir

cd my_dir

### with docker-compose

Установить нужный порт в .env (по умолчанию 8081)

docker-compose up -d

docker-compose exec -u app app composer install

### without docker

composer install

php -S


### routes
POST /delivery/fast - быстрая доставка

POST /deliver/slow - медленная

POST /delivery/offer - результат
  в теле запроса любой оффер из списка
