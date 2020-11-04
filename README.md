# assets-deployeer
Easy sync builded (by webpack, gulp, etc..) files with production server.
It may be useful if no possibility to rebuild assets on production server after deploying of source code. Works well in conjunction with GIT-FTP

# How it works
After each uploading builded files on server this script copies changed files to cache directory. Then before uploading rebuilded files it finds ONLY CHANGED files, upload their to server and updates cache.
Cache may be removed or refreshed anytime.

# How to use
Clone this repository. Then copy .env-example file to .env and change settings

For upload rebuilded files:

    php deployeer push

For clear cache:

    php deployeer clear-cache
    
For refresh cache without uploading:

    php deployeer refresh-cache
