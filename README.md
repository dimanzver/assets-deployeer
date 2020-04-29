# assets-deployeer
Easy sync builded (by webpack, gulp, etc..) files with production server.
It may be useful if no possibility to rebuild assets on production server after deploying of source code. Works well in conjunction with GIT-FTP

# How it works
After each uploading builded files on server this script copies changed files to cache directory. Then before uploading rebuilded files it finds ONLY CHANGED files, upload their to server and updates cache.
Cache may be removed or refreshed anytime.

# How to use
Clone this repository and find <b>deployeer</b> file.
In this file insert relative to project root directories paths in <b>DIRECTORIES</b> const
```php
define('DIRECTORIES', [
    'path/to/dist/directory',
]);
```

Then set settings for connection to server.
```php
//for FTP connection
define('DEPLOY_WAY', 'ftp');
define('FTP_HOST', 'host.domain.ru');
define('FTP_PORT', '21');
define('FTP_LOGIN', 'admin');
define('FTP_PASSWORD', 'admin');
define('FTP_BASEPATH', '/');
define('FTP_PASSIVE_MODE', false); //change to true if you have connection problems

//for SFTP connection
define('DEPLOY_WAY', 'sftp'); 
define('SFTP_HOST', 'host.domain.ru');
define('SFTP_PORT', '22');
define('SFTP_LOGIN', 'admin');
define('SFTP_PASSWORD', 'admin');
define('SFTP_BASEPATH', '/');

//local settings
define('ROOT', dirname(__DIR__)); //root path of project
define('STORE_PATH', __DIR__ . '/store'); //path to cache directory, may no change
```

For upload rebuilded files:

    php deployeer push

For clear cache:

    php deployeer clear-cache
    
For refresh cache without uploading:

    php deployeer refresh-cache
