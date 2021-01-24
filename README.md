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
        'path' => $params['storageRoot'], // dirname(__DIR__, 2) . '/storage'
        'host' => $params['storageHostInfo'], // 'https://site.example'
        'fallback' => $params['storageRoot'] . '/fallback.png',
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

> By default uses for caching component with name "cache". Config as belove:
```php
'components' => [
    'cache' => [
        'class' => 'yii\caching\FileCache',
        'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'
    ],
]
```

- In admin panel open management via link:

```php
/cms/home/index
```

### Examples

TODO

- Copy from extension root directory example widgets for frontend integration

# Usage

### Unit getter

```php
Unit::get('slug'); // will return data using cache
```

---

### Item Getters

```php
 $item->getText1(); // for get Text 1
 $item->getText2(); // for get Text 2
 $item->getText3(); // for get Text 3
 $item->getText4(); // for get Text 4
 $item->getText5(); // for get Text 5
 $item->getText6(); // for get Text 6
 $item->getText7(); // for get Text 7
```

###Return File URI
```php
 $item->getFile1(); // for get File 1
 $item->getFile2(); // for get File 2
 $item->getFile3(); // for get File 3 
```

###Return Datetime with specified format
```php
 $item->getDate($format); // for get date with format like "d.m.Y H:i:s"
 ```

###Return image URI by specified operation(default `cropResize`)
###[View all image operations & examples from documentation](https://github.com/Gregwar/Image#usage)

```php
 $item->getPhoto1(width, height, operation, background, xPos, yPos); // for get Photo 1
 $item->getPhoto2(width, height, operation, background, xPos, yPos); // for get Photo 2
 $item->getPhoto3(width, height, operation, background, xPos, yPos); // for get Photo 3
```

---

### Option Getters

```php
 $option->getName(); // for get Name

 $option->getContent(); // for get Content

 $option->getPhoto1(); // for get Photo 1
 $option->getPhoto2(); // for get Photo 2

 $option->getFile1(); // for get File 1
 $option->getFile2(); // for get File 2
```
