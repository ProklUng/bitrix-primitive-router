# Примитивный роутер для Битрикс на компонентах

### Зачем?

Иногда не получается по административно-техническим причинам развернуть нормальный роутер. Один из вариантов поведения
в такой ситуации - эти компоненты.

## Установка

composer.json:

```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/proklung/bitrix.primitive.router"
        }
    ]
```

```bash
composer require proklung/bitrix-primitive-router
```

## Использование

В `/bitrix/components/base/` прилетят два компонента: `base.router` и `rest.router`

```php
$APPLICATION->IncludeComponent('base:base.router', '', array(
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => 3600,
    "SEF_FOLDER" => '/article/',
    "SEF_MODE" => "Y",
    "SEF_URL_TEMPLATES" => array(
        "detail" => "#ELEMENT_ID#/",
        "index" => "index.php",
    ),
));
```

```php
$APPLICATION->IncludeComponent('base:rest.router', '', [
    'SEF_FOLDER' => '/rest/',
    'SEF_URL_PATHS' =>[
      'article/get-list/' => 'Article::getlist()',
      'article/get-detail/' => 'Article::getDetail()',
      'article/upsert/' => 'Article::upsert()',
     ]
]);
```

#### base:rest.router

Методы не статические. Конструктор должен быть без зависимостей (никакого намека на автовайринг не предусмотрено).

Шаблона не предусмотрено. В браузер отправляется json, создающийся из ответа метода-обработчика.

По соглашению метод-обработчик в возвращаемом массиве может вернуть ключ `httpStatusCode` с HTTP кодом ответа.