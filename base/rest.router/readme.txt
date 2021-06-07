Пример кода вызова компонента rest.router

<?$APPLICATION->IncludeComponent('base:rest.router', '', [
    'SEF_FOLDER' => '/rest/',
    'SEF_URL_PATHS' =>[
      'article/get-list/' => 'Article::getlist()',
      'article/get-detail/' => 'Article::getDetail()',
      'article/upsert/' => 'Article::upsert()',
     ]
]);?>
