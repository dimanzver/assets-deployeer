<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 15:48
 */

use AssetsDeployeer\ChangedFilesFinder;
use AssetsDeployeer\Deploy\Deploy;
use AssetsDeployeer\FilesCacher;
use AssetsDeployeer\Logger;

Logger::log('Searching files to sync');
$filesToUpload = ChangedFilesFinder::getFilesWithChanges();
if(empty($filesToUpload)){
    exit('Nothing to upload' . PHP_EOL);
}

Deploy::uploadFiles($filesToUpload);

Logger::log('Updating files cache');
FilesCacher::saveInCache($filesToUpload);