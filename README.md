# Test work

## start 

git clone git@github.com:tim31al/test-logistics.git my_dir

cd my_dir

### with docker-compose

Установить нужный порт в .env (по умолчанию 8081)

docker-compose up -d

docker-compose exec -u app app composer install

### without docker

composer install

cd public

php -S localhost:8081


### routes
POST http://localhost:8081/delivery/fast - быстрая доставка

POST http://localhost:8081/deliver/slow - медленная

POST http://localhost:8081/delivery/offer - результат
  в теле запроса любой оффер из списка
