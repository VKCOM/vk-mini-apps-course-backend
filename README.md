# Демо-приложение «Блюдо дня»

В репозитории находится исходный код серверной части демонстрационного мини-приложения [Блюдо дня](https://vk.com/app51773283).  
Оно разработано в рамках обучающего видеокурса [Разработка мини-приложений ВКонтакте](https://dev.vk.com/ru/mini-apps/learning/course).

[Репозиторий с клиентской частью мини-приложения](https://github.com/VKCOM/vk-mini-apps-course-frontend)

## Запуск сервера
1. Перейдите в папку с проектом и запустите docker-контейнер с помощью команды `docker-compose up -d`.
2. При первом запуске сервера:
    1. Войдите в php-контейнер, выполнив команду `docker exec -it YOUR_CONTAINER_ID bash`.

   Чтобы узнать `YOUR_CONTAINER_ID`, выполните команду `docker ps` и найдите его в списке запущенных контейнеров.
    2. Внутри php-контейнера выполните команду `php artisan migrate`, чтобы создать таблицы в базе данных.
    3. Выполните команду `php artisan db:seed`, чтобы наполнить таблицы первоначальными данными.
4. Теперь сервер доступен по адресу http://localhost:8081/.

## Конфигурирование
1. Создайте .env-файл. Для этого можно выполнить консольную команду `cp .env.example .env`.
2. Настройте параметры окружения:

```
   VKMA_APP_ID='YOUR_APP_ID'

   VKMA_APP_SECRET='SECRET_KEY'
   VKMA_SERVICE_KEY='SERVICE_KEY'


   // конфигурация VK Pay
   VK_PAY_MERCHANT_ID='MERCHANT_ID'
   VK_PAY_MERCHANT_KEY='MERCHANT_KEY'
   VK_PAY_MERCHANT_URL='MERCHANT_URL'
   VK_PAY_PUBLIC_KEY='PUBLIC_KEY'
```
где:

- YOUR_APP_ID — идентификатор созданного мини-приложения.
- SECRET_KEY — защищённый ключ мини-приложения.
- SERVICE_KEY — сервисный ключ мини-приложения.
- MERCHANT_ID — идентификатор мерчанта.
- MERCHANT_KEY — ключ мерчанта.
- MERCHANT_URL — URL для обращения на сервер VK Pay.
- PUBLIC_KEY — публичный ключ для проверки подписи сообщений от VK Pay.

Идентификатор мини-приложения и ключи доступа можно найти в [настройках](https://dev.vk.com/ru/mini-apps/management/settings).

## Включение оплаты голосами и с помощью VK Pay
Чтобы включить возможность оплаты голосами в демонстрационном мини-приложении, вызовите команду
`php artisan app:switch-donate-flag {user-id}`, где вместо {user-id} передайте идентификатор пользователя в системе.

Чтобы включить возможность оплаты с помощью VK Pay в демонстрационном мини-приложении, вызовите команду
`php artisan app:switch-vk-pay-flag {user-id}`, где вместо {user-id} передайте идентификатор пользователя в системе.


## 🔎 Работа с комментариями
В коде проекта находятся коментарии вида:

```
 Модуль 4. Разработка Урок 3. Роутинг #M4L3.
 Создание роутера и объявление маршрутов.
```

В указанных уроках видеокурса вы найдёте информацию о разработке соответствующих фрагментов кода.
В поиске по файлам используйте названия уроков или хештеги, где M4 — номер модуля, L3 - номер урока.


## 📎 Полезные ссылки
[Портал для разработчиков](https://dev.vk.com/ru/guide)  
[Видеокурс: Разработка мини-приложений ВКонтакте](https://dev.vk.com/ru/mini-apps/learning/course)  
[Мини-приложение «Блюдо дня»](https://vk.com/app51773283)  
[Репозиторий с фронтендом приложения «Блюдо дня»](https://github.com/VKCOM/vk-mini-apps-course-frontend)  
[Задайте вопрос в сообществе разработчиков VK Mini Apps](https://vk.com/vkappsdev)

## Лицензия
Код распространяется под лицензией MIT, от имени VK.com (ООО "В Контакте").
