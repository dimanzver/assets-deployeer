<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 15:58
 */
namespace AssetsDeployeer;

class ChangedFilesFinder
{
    /**
     * Get only files with changes
     * @return array
     */
    public static function getFilesWithChanges(){
        $files = self::getFilesList();
        return array_filter($files, function ($file){
            if(!file_exists(STORE_PATH . '/' . $file))
                return true;

            //check original and cached files content
            return md5_file(STORE_PATH . '/' . $file) !== md5_file(ROOT . '/' . $file);
        });
    }

    /**
     * Get all tracked files list
     *
     * @return array
     */
    protected static function getFilesList(){
        $result = [];
        foreach (DIRECTORIES as $directory){
            $result = (array_merge($result, FileManager::getDirectoryFiles($directory)));
        }
        return $result;
    }

}