# yii2-block extension

The extension allows manage html content block.

### Installation

- Install with composer:

```bash
composer require abdualiym/yii2-cms "^1.0"
```

- **After composer install** run console command for create tables:

```bash
php yii migrate/up --migrationPath=@vendor/abdualiym/yii2-cms/migrations
```

- Setup in common config storage and language configurations.
> language indexes related with database columns.

> Admin panel tabs render by array values order 

```php
'modules' => [
    'cms' => [ // don`t change module key
        'class' => '@abdualiym\cms\Module',
        'storageRoot' => $params['staticPath'],
        'storageHost' => $params['staticHostInfo'],
        'thumbs' => [ // 'sm' and 'md' keys are reserved
            'admin' => ['width' => 128, 'height' => 128],
            'thumb' => ['width' => 320, 'height' => 320],
        ],
        'languages' => [
            'ru' => [
                'id' => 0,
                'name' => 'Русский',
            ],
            'uz' => [
                'id' => 1,
                'name' => 'O`zbek tili',
            ],
        ],
        'menuActions' => [ // for add to menu controller actions
            '' => 'Home',
            'site/contacts' => 'Contacts',
        ]
    ],
],
```

- In admin panel add belove links for manage pages, article categories, articles and menu:
```php
/cms/pages/index
/cms/article-categories/index
/cms/articles/index
/cms/menu/index
```

> CKEditor use Elfinder plugin for save files and images. Refer [Elfinder readme](https://github.com/MihailDev/yii2-elfinder) for proper configuration

###Examples

Extension registers next language arrays to Yii::$app->params[] for use in views:
```php
\Yii::$app->params['cms']['languageIds'][$prefix] = $language['id'];
[
    'en' => 2,
    'ru' => 1,
    ...
]

\Yii::$app->params['cms']['languages'][$prefix] = $language['name'];
[
    'en' => 'English',
    ...
]


\Yii::$app->params['cms']['languages2'][$language['id']] = $language['name'];
[
    2 => 'English',
    ...
]
```

###Examples for use in frontend see [yii2-language](https://github.com/Abdualiym/yii2-language) extension


---

> TODO 
 - Copy from extension root directory example widgets for frontend integration  
