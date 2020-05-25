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
<pre>
document = {
  id: "some-uuid-string",
  status: "draft|published",
  payload: Object,
  created_at: "iso-8601 date time with time zone",
  updated_at: "iso-8601 date time with time zone"
}
</pre>

## Пример работы

### 1. Клиент делает запрос на создание документа
Запрос:
<pre>
<span class="pl-k">POST</span><span class="pl-c1"> /api/v1/document HTTP/1.1</span>
<span class="pl-s"><span class="pl-v">accept:</span> application/json</span></pre>
Ответ:
<pre>
{
    "document": {
        "payload": {},
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "draft",
        "updated_at": "2020-05-25 08:16:44",
        "created_at": "2020-05-25 08:16:44"
    }
}
</pre>

### 2. Клиент редактирует документ первый раз
Запрос:
<pre>
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
</pre>
Ответ: 
<pre>
HTTP/1.1 200 OK
content-type: application/json

{
    "document": {
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "draft",
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
        },
        "created_at": "2020-05-25 08:16:44",
        "updated_at": "2020-05-25 09:04:57"
    }
}
</pre>

### 3. Клиент редактирует документ
Запрос:
<pre>
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
</pre>

Ответ:
<pre>
{
    "document": {
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "draft",
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
        },
        "created_at": "2020-05-25 08:16:44",
        "updated_at": "2020-05-25 09:07:45"
    }
}
</pre>

### 4. Клиент публикует документ
Запрос:
<pre>
POST /api/v1/document/dd6a2519-cc4b-4931-9567-040c30dfa0ca/publish HTTP/1.1
accept: application/json
</pre>

Ответ:
<pre>
{
    "document": {
        "id": "dd6a2519-cc4b-4931-9567-040c30dfa0ca",
        "status": "published",
        "payload": {
            "actor": "The fox",
            "meta": {
                "type": "quick",
                "color": "brown"
            },
            "actions": [
                {
                    "action": "jump over",
                    "actor": "ssdfsdg"
                }
            ]
        },
        "created_at": "2020-05-25 09:33:46",
        "updated_at": "2020-05-25 09:45:02"
    }
}
</pre>

### 5. Клиент получает запись в списке
Запрос:
<pre>
GET /api/v1/document/?page=1 HTTP/1.1
accept: application/json
</pre>

Ответ:
<pre>
{
    "document": [
        {
            "id": "54a79c31-4ebb-4333-b72d-1ed86a09c187",
            "status": "published",
            "payload": {
                "meta": {
                    "type": "cunning",
                    "color": null
                },
                "actions": [
                    {
                        "action": "eat",
                        "actor": "sss"
                    },
                    {
                        "action": "run away"
                    }
                ]
            },
            "created_at": "2020-05-25 09:18:20",
            "updated_at": "2020-05-25 09:20:49"
        },
        {
            "id": "1f5392e4-2061-4dee-aa5f-6b6813b4ab04",
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
            "created_at": "2020-05-25 09:24:34",
            "updated_at": "2020-05-25 09:27:02"
        },
        {
            "id": "00e31ad1-9647-4163-8c6a-cefde410f9cc",
            "status": "published",
            "payload": {
                "actor": "The fox",
                "meta": {
                    "type": "quick",
                    "color": "brown"
                },
                "actions": [
                    {
                        "action": "jump over",
                        "actor": "ssdfsdg"
                    }
                ]
            },
            "created_at": "2020-05-25 09:33:46",
            "updated_at": "2020-05-25 09:45:02"
        }
    ],
    "pagination": {
        "page": 1,
        "perPage": 20,
        "total": 3
    }
}
</pre>
