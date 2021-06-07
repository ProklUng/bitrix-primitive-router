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
            "url": "https://github.com/proklung/bitrix-primitive-router"
        }
    ]
```

```bash
composer require proklung/bitrix-primitive-router
```

## Использование

В `/bitrix/components/base/` прилетят два компонента: `base.router` и `rest.router`

```php
$APPLICATION->IncludeComponent('bitrix-primitive-router:base.router', '', array(
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
$APPLICATION->IncludeComponent('bitrix-primitive-router:rest.router', '', [
    'SEF_FOLDER' => '/rest/',
    'SEF_URL_PATHS' =>[
      'article/get-list/' => 'Local\Rest\Article::getlist()',
      'article/get-detail/' => 'Local\Rest\Article::getDetail()',
      'article/upsert/' => 'Local\Rest\Article::upsert()',
     ]
]);
```

#### base:rest.router

Методы не статические. Названия классов - полноразмерные. Конструктор должен быть без зависимостей (никакого намека на автовайринг не предусмотрено).

Шаблона не предусмотрено. В браузер отправляется json, создающийся из ответа метода-обработчика.

По соглашению метод-обработчик в возвращаемом массиве может вернуть ключ `httpStatusCode` с HTTP кодом ответа.