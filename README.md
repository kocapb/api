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
Edit .env file for your database configuration
<pre>
php artisan migrate
</pre>
For version Laravel 5.8 switch to the branch:
<pre>
git checkout stable-5.8
</pre>

## Описание
<b>API</b>
<ul>
    <li>POST /api/v1/document/ - создаем черновик документа</li>
    <li>GET /api/v1/document/{id} - получить документ по id</li>
    <li>PATCH /api/v1/document/{id} - редактировать документ</li>
    <li>POST /api/v1/document/{id}/publish - опубликовать документ</li>
    <li>GET /api/v1/document/?page=1&perPage=20 - получить список документов с пагинацией, сортировка в последние созданные сверху.</li>
</ul>

<b>Дополнительные условия:</b>
<ul>
    <li>Если документ не найден, то в ответе возвращается 404 код.</li>
    <li>При попытке редактирования документа, который уже опубликован, должно возвращаться 400.</li>
    <li>Попытка опубликовать уже опубликованный документ возвращает 200.</li>
    <li>Все запросы на конкретный документ возвращают этот документ.</li>
    <li>Список документов возвращается в виде массива документов и значений пагинации.</li>
    <li>апрос PATCH отправляется с телом json в соответсвующей иерархии документа, все поля, кроме payload игнорируются. Если payload не передан, то ответ 400.</li>
</ul>
