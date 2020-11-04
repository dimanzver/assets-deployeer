<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 15:48
 */

use AssetsDeployeer\ChangedFilesFinder;
use AssetsDeployeer\Deploy\Deploy;
use AssetsDeployeer\Logger;

Logger::log('Searching files to sync');
$filesToUpload = ChangedFilesFinder::getFilesWithChanges();
if(empty($filesToUpload)){
    echo 'Nothing to upload' . PHP_EOL;
}

Deploy::uploadFiles($filesToUpload);
Deploy::removeOldFiles();
