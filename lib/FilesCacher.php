<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 16:55
 */
namespace AssetsDeployeer;

class FilesCacher
{
    /**
     * Save files in cache
     *
     * @param array $files Relative paths for files
     */
    public static function saveInCache(array $files){
        foreach ($files as $file){
            if(!file_exists(ROOT . '/' . $file))
                continue;

            //create new dir if neccessary
            $pathinfo = pathinfo($file);
            $dir = STORE_PATH . '/' . $pathinfo['dirname'];
            if(!is_dir($dir))
                mkdir($dir, 0777, true);

            file_put_contents(STORE_PATH . '/' . $file, file_get_contents(ROOT . '/' . $file));
        }
    }

    /**
     * Clear all cached files
     */
    public static function clear(){
        FileManager::clearDir(STORE_PATH);
    }

    public static function refresh(){
        self::clear();
        $filesForSave = ChangedFilesFinder::getFilesWithChanges();
        self::saveInCache($filesForSave);
    }
}