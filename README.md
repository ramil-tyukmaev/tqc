# talks quality checker

Чтобы развернуть проект запустите `make init` и заполните в .env TRANSCRIPTION_API_KEY

###Поднять контейнеры
`docker compose up -d`

## Проверка работы
### Создание задания
```
curl 'localhost/api/v1/tasks' \
--header 'X-API-KEY: qm64ak8mbb1q2gdao6i8kqezczv4k0lk' \
--header 'Content-Type: application/json' \
--data '{
    "audioUrl": "http://localhost/test"
}'
```

### Получить статус задания и результаты транскрибации и оценки
```
curl --request GET 'localhost/api/v1/tasks/1' \
--header 'X-API-KEY: qm64ak8mbb1q2gdao6i8kqezczv4k0lk'
```

###Примечание
Процесс транскрибации асинхронный и статус транскрибации проверяется каждые 5 минут. Для ручного запуска проверки статуса транскрибации запустите `php artisan tasks:check-transcription-status` внутри контейнера.
