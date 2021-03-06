<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Запуск проекта
<pre>
git clone https://github.com/kocapb/api.git
composer update
</pre>
Отредактируйте .env файл согласно вашим настройкам БД
<pre>
php artisan migrate
</pre>
Для поддержки Laravel 5.8 
<pre>
git checkout stable-5.8
</pre>

## API
<ul>
    <li><code>POST /api/v1/document/</code> - создаем черновик документа</li>
    <li><code>GET /api/v1/document/{id}</code> - получить документ по id</li>
    <li><code>PATCH /api/v1/document/{id}</code> - редактировать документ</li>
    <li><code>POST /api/v1/document/{id}/publish</code> - опубликовать документ</li>
    <li><code>GET /api/v1/document/?page=1&perPage=20</code> - получить список документов с пагинацией, сортировка в последние созданные сверху.</li>
</ul>

<b>Дополнительные условия:</b>
<ul>
    <li>Если документ не найден, то в ответе возвращается 404 код.</li>
    <li>При попытке редактирования документа, который уже опубликован, должно возвращаться 400.</li>
    <li>Попытка опубликовать уже опубликованный документ возвращает 200.</li>
    <li>Все запросы на конкретный документ возвращают этот документ.</li>
    <li>Список документов возвращается в виде массива документов и значений пагинации.</li>
    <li>апрос <code>PATCH</code> отправляется с телом json в соответсвующей иерархии документа, все поля, кроме <code>payload</code> игнорируются. Если <code>payload</code> не передан, то ответ 400.</li>
</ul>

### Объект документа
```js
document = {
  id: "some-uuid-string",
  status: "draft|published",
  payload: Object,
  created_at: "iso-8601 date time without time zone",
  updated_at: "iso-8601 date time without time zone"
}
```

## Пример работы

### 1. Клиент делает запрос на создание документа

Запрос:

```http
POST /api/v1/document HTTP/1.1
accept: application/json
```

Ответ:

```http
HTTP/1.1 200 OK
content-type: application/json
{
    "document": {
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "draft",
        "payload": {},
        "created_at": "2020-05-25 08:16:44",
        "updated_at": "2020-05-25 08:16:44"
    }
}
```

### 2. Клиент редактирует документ первый раз

Запрос:

```http
PATCH /api/v1/document/dd6a2519-cc4b-4931-9567-040c30dfa0ca HTTP/1.1
accept: application/json
content-type: application/json
{
    "document": {
        "payload": {
            "actor": "The fox",
            "meta": {
                "type": "quick",
                "color": "brown"
            },
            "actions": [
                {
                    "action": "jump over",
                    "actor": "lazy dog"
                }
            ]
        }
    }
}
```

Ответ: 

```http
HTTP/1.1 200 OK
content-type: application/json
{
    "document": {
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "draft",
        "payload": {
            "actor": "The fox",
            "meta": {
                "type": "quick",
                "color": "brown"
            },
            "actions": [
                {
                    "action": "jump over",
                    "actor": "lazy dog"
                }
            ]
        },
        "created_at": "2020-05-25 08:16:44",
        "updated_at": "2020-05-25 09:04:57"
    }
}
```

### 3. Клиент редактирует документ

Запрос:

```http
PATCH /api/v1/document/dd6a2519-cc4b-4931-9567-040c30dfa0ca HTTP/1.1
accept: application/json
content-type: application/json
{
    "document": {
        "payload": {
            "meta": {
                "type": "cunning",
                "color": null
            },
            "actions": [
                {
                    "action": "eat",
                    "actor": "blob"
                },
                {
                    "action": "run away"
                }
            ]
        }
    }
}
```

Ответ:

```http
HTTP/1.1 200 OK
content-type: application/json
{
    "document": {
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "draft",
        "payload": {
            "actor": "The fox",
            "meta": {
                "type": "cunning",
            },
            "actions": [
                {
                    "action": "eat",
                    "actor": "blob"
                },
                {
                    "action": "run away"
                }
            ]
        },
        "created_at": "2020-05-25 08:16:44",
        "updated_at": "2020-05-25 09:07:45"
    }
}
```

### 4. Клиент публикует документ

Запрос:

```http
POST /api/v1/document/dd6a2519-cc4b-4931-9567-040c30dfa0ca/publish HTTP/1.1
accept: application/json
```
Ответ:

```http
HTTP/1.1 200 OK
content-type: application/json
{
    "document": {
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "published",
        "payload": {
            "actor": "The fox",
            "meta": {
                "type": "cunning",
            },
            "actions": [
                {
                    "action": "eat",
                    "actor": "blob"
                },
                {
                    "action": "run away"
                }
            ]
        },
        "created_at": "2020-05-25 08:16:44",
        "updated_at": "2020-05-25 09:45:02"
    }
}
```

### 5. Клиент получает запись в списке

Запрос:

```http
GET /api/v1/document/?page=1 HTTP/1.1
accept: application/json
```

Ответ:

```http
HTTP/1.1 200 OK
content-type: application/json
{
    "document": [
        {
            "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
            "status": "published",
            "payload": {
                "actor": "The fox",
                "meta": {
                    "type": "cunning",
                },
                "actions": [
                    {
                        "action": "eat",
                        "actor": "blob"
                    },
                    {
                        "action": "run away"
                    }
                ]
            },
             "created_at": "2020-05-25 08:16:44",
            "updated_at": "2020-05-25 09:45:02"
        }
    ],
    "pagination": {
        "page": 1,
        "perPage": 20,
        "total": 1
    }
}
```

## Что предстоит сделть
- [ ] Добавить валидатор по Json Schema 
- [ ] Написать unit/api тесты
- [ ] Docker
- [ ] Добавить аутентификацию/авторизацию
