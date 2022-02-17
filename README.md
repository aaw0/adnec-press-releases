# ADNEC Press Releases Package

Press Releases package creates a model, database table and laravel nova resource ready for you.

* This package requires Laravel Nova installed already.
* This package only adds functionality to the Nova admin panel, and the front end is up to you.

# Installation

1 - Add to composer.json file the adnec press releases package like below
```json
"repositories": [
        {
            "type": "composer",
            "url": "https://nova.laravel.com"
        },
        {
            "type": "vcs",
            "url":  "https://github.com/aaw0/adnec-press-releases.git"
        }
    ],
```
2 - Install by running the following composer line 

`composer require aaw0/adnec-press-releases`

3 - Add the following line to `config/app.php`
```php
'providers' => [
  
  /*Other classes*/
  
  \Aaw0\AdnecPressReleases\AdnecPressReleasesServiceProvider::class;
];
```


4 - Finally Run `php artisan migrate`
