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
<pre><span class="pl-smi">document</span> <span class="pl-c1">=</span> <span class="pl-kos">{</span>
  <span class="pl-c1">id</span>: <span class="pl-s">"some-uuid-string"</span><span class="pl-kos">,</span>
  <span class="pl-c1">status</span>: <span class="pl-s">"draft|published"</span><span class="pl-kos">,</span>
  <span class="pl-c1">payload</span>: <span class="pl-v">Object</span><span class="pl-kos">,</span>
  <span class="pl-c1">created_at</span>: <span class="pl-s">"iso-8601 date time without time zone"</span><span class="pl-kos">,</span>
  <span class="pl-c1">updated_at</span>: <span class="pl-s">"iso-8601 date time without time zone"</span>
<span class="pl-kos">}</span>
</pre>

## Пример работы

### 1. Клиент делает запрос на создание документа
Запрос:
<pre>
<span class="pl-k">POST</span><span class="pl-c1"> /api/v1/document HTTP/1.1</span>
<span class="pl-s"><span class="pl-v">accept:</span> application/json</span>
</pre>

Ответ:
<pre>HTTP/<span class="pl-c1">1.1</span> <span class="pl-c1">200</span> OK
<span class="pl-s"><span class="pl-v">content-type:</span> application/json</span>

{
    <span class="pl-s"><span class="pl-pds">"</span>document<span class="pl-pds">"</span></span>: {
        <span class="pl-s"><span class="pl-pds">"</span>id<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>dd6a2519-cc4b-4931-9567-040c30dfa0ca<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>status<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>draft<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>payload<span class="pl-pds">"</span></span>: {},
        <span class="pl-s"><span class="pl-pds">"</span>created_at<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 08:16:44<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>updated_at<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 08:16:44<span class="pl-pds">"</span></span>     
    }
}</pre>

### 2. Клиент редактирует документ первый раз
Запрос:
<pre><span class="pl-k">PATCH</span><span class="pl-c1"> /api/v1/document/dd6a2519-cc4b-4931-9567-040c30dfa0ca HTTP/1.1</span>
<span class="pl-s"><span class="pl-v">accept:</span> application/json</span>
<span class="pl-s"><span class="pl-v">content-type:</span> application/json</span>

{
    <span class="pl-s"><span class="pl-pds">"</span>document<span class="pl-pds">"</span></span>: {
        <span class="pl-s"><span class="pl-pds">"</span>payload<span class="pl-pds">"</span></span>: {
            <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>The fox<span class="pl-pds">"</span></span>,
            <span class="pl-s"><span class="pl-pds">"</span>meta<span class="pl-pds">"</span></span>: {
                <span class="pl-s"><span class="pl-pds">"</span>type<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>quick<span class="pl-pds">"</span></span>,
                <span class="pl-s"><span class="pl-pds">"</span>color<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>brown<span class="pl-pds">"</span></span>
            },
            <span class="pl-s"><span class="pl-pds">"</span>actions<span class="pl-pds">"</span></span>: [
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>jump over<span class="pl-pds">"</span></span>,
                    <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>lazy dog<span class="pl-pds">"</span></span>
                }
            ]
        }
    }
}</pre>

Ответ: 

<pre>HTTP/<span class="pl-c1">1.1</span> <span class="pl-c1">200</span> OK
<span class="pl-s"><span class="pl-v">content-type:</span> application/json</span>

{
    <span class="pl-s"><span class="pl-pds">"</span>document<span class="pl-pds">"</span></span>: {
        <span class="pl-s"><span class="pl-pds">"</span>id<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>dd6a2519-cc4b-4931-9567-040c30dfa0ca<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>status<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>draft<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>payload<span class="pl-pds">"</span></span>: {
            <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>The fox<span class="pl-pds">"</span></span>,
            <span class="pl-s"><span class="pl-pds">"</span>meta<span class="pl-pds">"</span></span>: {
                <span class="pl-s"><span class="pl-pds">"</span>type<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>quick<span class="pl-pds">"</span></span>,
                <span class="pl-s"><span class="pl-pds">"</span>color<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>brown<span class="pl-pds">"</span></span>
            },
            <span class="pl-s"><span class="pl-pds">"</span>actions<span class="pl-pds">"</span></span>: [
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>jump over<span class="pl-pds">"</span></span>,
                    <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>lazy dog<span class="pl-pds">"</span></span>
                }
            ]
        },
        <span class="pl-s"><span class="pl-pds">"</span>createAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 08:16:44<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>modifyAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 09:04:57<span class="pl-pds">"</span></span>
    }
}</pre>

### 3. Клиент редактирует документ
Запрос:
<pre><span class="pl-k">PATCH</span><span class="pl-c1"> /api/v1/document/dd6a2519-cc4b-4931-9567-040c30dfa0ca HTTP/1.1</span>
<span class="pl-s"><span class="pl-v">accept:</span> application/json</span>
<span class="pl-s"><span class="pl-v">content-type:</span> application/json</span>

{
    <span class="pl-s"><span class="pl-pds">"</span>document<span class="pl-pds">"</span></span>: {
        <span class="pl-s"><span class="pl-pds">"</span>payload<span class="pl-pds">"</span></span>: {
            <span class="pl-s"><span class="pl-pds">"</span>meta<span class="pl-pds">"</span></span>: {
                <span class="pl-s"><span class="pl-pds">"</span>type<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>cunning<span class="pl-pds">"</span></span>,
                <span class="pl-s"><span class="pl-pds">"</span>color<span class="pl-pds">"</span></span>: <span class="pl-c1">null</span>
            },
            <span class="pl-s"><span class="pl-pds">"</span>actions<span class="pl-pds">"</span></span>: [
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>eat<span class="pl-pds">"</span></span>,
                    <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>blob<span class="pl-pds">"</span></span>
                },
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>run away<span class="pl-pds">"</span></span>
                }
            ]
        }
    }
}</pre>

Ответ:
<pre>HTTP/<span class="pl-c1">1.1</span> <span class="pl-c1">200</span> OK
<span class="pl-s"><span class="pl-v">content-type:</span> application/json</span>

{
    <span class="pl-s"><span class="pl-pds">"</span>document<span class="pl-pds">"</span></span>: {
        <span class="pl-s"><span class="pl-pds">"</span>id<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>dd6a2519-cc4b-4931-9567-040c30dfa0ca<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>status<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>draft<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>payload<span class="pl-pds">"</span></span>: {
            <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>The fox<span class="pl-pds">"</span></span>,
            <span class="pl-s"><span class="pl-pds">"</span>meta<span class="pl-pds">"</span></span>: {
                <span class="pl-s"><span class="pl-pds">"</span>type<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>cunning<span class="pl-pds">"</span></span>,
            },
            <span class="pl-s"><span class="pl-pds">"</span>actions<span class="pl-pds">"</span></span>: [
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>eat<span class="pl-pds">"</span></span>,
                    <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>blob<span class="pl-pds">"</span></span>
                },
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>run away<span class="pl-pds">"</span></span>
                }
            ]
        },
        <span class="pl-s"><span class="pl-pds">"</span>createAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 08:16:44<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>modifyAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 09:07:45<span class="pl-pds">"</span></span>
    }
}</pre>

### 4. Клиент публикует документ
Запрос:
<pre>
<span class="pl-k">POST</span><span class="pl-c1"> /api/v1/document/dd6a2519-cc4b-4931-9567-040c30dfa0ca/publish HTTP/1.1</span>
<span class="pl-s"><span class="pl-v">accept:</span> application/json</span>
</pre>

Ответ:
<pre>HTTP/<span class="pl-c1">1.1</span> <span class="pl-c1">200</span> OK
<span class="pl-s"><span class="pl-v">content-type:</span> application/json</span>

{
    <span class="pl-s"><span class="pl-pds">"</span>document<span class="pl-pds">"</span></span>: {
        <span class="pl-s"><span class="pl-pds">"</span>id<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>dd6a2519-cc4b-4931-9567-040c30dfa0ca<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>status<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>published<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>payload<span class="pl-pds">"</span></span>: {
            <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>The fox<span class="pl-pds">"</span></span>,
            <span class="pl-s"><span class="pl-pds">"</span>meta<span class="pl-pds">"</span></span>: {
                <span class="pl-s"><span class="pl-pds">"</span>type<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>cunning<span class="pl-pds">"</span></span>,
            },
            <span class="pl-s"><span class="pl-pds">"</span>actions<span class="pl-pds">"</span></span>: [
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>eat<span class="pl-pds">"</span></span>,
                    <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>blob<span class="pl-pds">"</span></span>
                },
                {
                    <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>run away<span class="pl-pds">"</span></span>
                }
            ]
        },
        <span class="pl-s"><span class="pl-pds">"</span>createAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 09:33:46<span class="pl-pds">"</span></span>,
        <span class="pl-s"><span class="pl-pds">"</span>modifyAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 09:45:02<span class="pl-pds">"</span></span>
    }
}</pre>

### 5. Клиент получает запись в списке
Запрос:
<pre>
<span class="pl-k">GET</span><span class="pl-c1"> /api/v1/document/?page=1 HTTP/1.1</span>
<span class="pl-s"><span class="pl-v">accept:</span> application/json</span>
</pre>

Ответ:
<pre>HTTP/<span class="pl-c1">1.1</span> <span class="pl-c1">200</span> OK
<span class="pl-s"><span class="pl-v">content-type:</span> application/json</span>

{
    <span class="pl-s"><span class="pl-pds">"</span>document<span class="pl-pds">"</span></span>: [
        {
            <span class="pl-s"><span class="pl-pds">"</span>id<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>dd6a2519-cc4b-4931-9567-040c30dfa0ca<span class="pl-pds">"</span></span>,
            <span class="pl-s"><span class="pl-pds">"</span>status<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>published<span class="pl-pds">"</span></span>,
            <span class="pl-s"><span class="pl-pds">"</span>payload<span class="pl-pds">"</span></span>: {
                <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>The fox<span class="pl-pds">"</span></span>,
                <span class="pl-s"><span class="pl-pds">"</span>meta<span class="pl-pds">"</span></span>: {
                    <span class="pl-s"><span class="pl-pds">"</span>type<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>cunning<span class="pl-pds">"</span></span>,
                },
                <span class="pl-s"><span class="pl-pds">"</span>actions<span class="pl-pds">"</span></span>: [
                    {
                        <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>eat<span class="pl-pds">"</span></span>,
                        <span class="pl-s"><span class="pl-pds">"</span>actor<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>blob<span class="pl-pds">"</span></span>
                    },
                    {
                        <span class="pl-s"><span class="pl-pds">"</span>action<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>run away<span class="pl-pds">"</span></span>
                    }
                ]
            },
            <span class="pl-s"><span class="pl-pds">"</span>createAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 09:33:46<span class="pl-pds">"</span></span>,
            <span class="pl-s"><span class="pl-pds">"</span>modifyAt<span class="pl-pds">"</span></span>: <span class="pl-s"><span class="pl-pds">"</span>2020-05-25 09:45:02<span class="pl-pds">"</span></span>
        }
    ],
    <span class="pl-s"><span class="pl-pds">"</span>pagination<span class="pl-pds">"</span></span>: {
        <span class="pl-s"><span class="pl-pds">"</span>page<span class="pl-pds">"</span></span>: <span class="pl-c1">1</span>,
        <span class="pl-s"><span class="pl-pds">"</span>perPage<span class="pl-pds">"</span></span>: <span class="pl-c1">20</span>,
        <span class="pl-s"><span class="pl-pds">"</span>total<span class="pl-pds">"</span></span>: <span class="pl-c1">1</span>
    }
}</pre>
