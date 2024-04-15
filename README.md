## Запуск сервера

1. Поднять docker контейнер, для этого выполнить команду `docker-compose up -d`
2. При первом запуске сервера:
   1. Войти в php контейнер, выполнив команду `docker exec -it YOUR_CONTAINER_ID bash`. Узнать YOUR_CONTAINER_ID можно, например, посмотрев его в списке запущенных контейнеров командой `docker ps`.
   2. Внутри php контейнера выполнить команду `php artisan migrate` чтобы создать таблицы в базе данных.
   3. Затем выполнить команду `php artisan db:seed` чтобы наполнить таблицы первоналаьными данными.
3. Сервер доступен по адресу http://localhost:8081/

## Пояснение по оплате голосами
[Подробное описание оплаты голосами в мини приложениях ВК](https://dev.vk.com/ru/api/payments/getting-started)
В случае учебного приложения Блюдо дня, как и в других приложениях, инициализацию платежа выполняет клиент, вызывая соответствующий метод библиотеки vk bridge.

## Пояснение по оплате VK Pay

## Лицензия
Код распространяется под лицензией MIT, от имени VK.com (ООО "В контакте").
