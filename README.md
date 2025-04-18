# talks quality checker

###Развернуть проект
``make init``

###Поднять контейнеры
``docker compose up -d``

## Проверка работы
### Запрос к сервису
`curl --location 'localhost/api/v1/tasks' \
--header 'X-API-KEY: qm64ak8mbb1q2gdao6i8kqezczv4k0lk' \
--header 'Content-Type: application/json' \
--data '{
"audioUrl": "http://localhost/test"
}'`
