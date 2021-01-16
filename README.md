# yii-2-cms extension

The extension allows:
- make html blocks of html contents, files, images.
- make collections for options like tags, categories
- make entities for items like sliders, products, reviews, articles, pages
- support up to 5 languages
- support SEO meta tags
- make multiple menu with parenting feature

## Installation

- Install with composer:

```bash
composer require afzalroq/yii2-cms "^1.0"
```

- **After composer install** run console command for create tables:

### Add to console config for auto discover migrations

```php
'controllerMap' => [
    'migrate' => [
        'class' => MigrateController::class,
        'autoDiscover' => true,
        'migrationPaths' => [
            '@vendor/afzalroq/yii2-cms/migrations'
        ],
    ],
]
```

```bash
php yii migrate/up --migrationPath=@vendor/afzalroq/yii2-cms/migrations
```

### Setup in common config file

> CKEditor use Elfinder plugin for save files and images. Refer [Elfinder readme](https://github.com/MihailDev/yii2-elfinder) for proper configuration
- Language indexes related with database columns.
- Admin panel tabs render by array values order

```php
'modules' => [
    'cms' => [ // don`t change module key
        'class' => '@afzalroq\cms\Module',
        'storageRoot' => $params['staticPath'],
        'storageHost' => $params['staticHostInfo'],
        'languages' => [
            'ru' => [
                'id' => 0, // must start from 0 up to 4
                'name' => 'English',
            ],
            'en' => [
                'id' => 1,
                'name' => 'Русский',
            ],
            'uz' => [
                'id' => 2,
                'name' => 'O`zbek tili',
            ],
        ],
        'menuActions' => [ // for add to menu controller actions
            '' => 'Home',
            'site/contacts' => 'Contacts',
        ]
    ],
]
```

- In admin panel open management via link:
```php
/cms/home/index
```


###Examples

TODO
- Copy from extension root directory example widgets for frontend integration
