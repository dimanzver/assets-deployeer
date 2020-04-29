<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 17:11
 */
namespace AssetsDeployeer;

class FileManager
{
    /**
     * Recursive find all files in directory
     *
     * @param $directory
     * @return array
     */
    public static function getDirectoryFiles($directory){
        $dir = ROOT . '/' . $directory;
        $files = array_slice(scandir($dir), 2);
        $result = [];
        foreach ($files as $file){
            if(!is_dir($dir . '/' . $file)){
                $result[] = $directory . '/' . $file;
            }else{
                //for dir - find all files in it (recursively)
                $result = array_merge($result, self::getDirectoryFiles($directory . '/' . $file));
            }
        }
        return $result;
    }

    /**
     * Recursive clear files in dir (without this dir)
     * @param string $dir
     */
    public static function clearDir(string $dir){
        $files = glob($dir . '/*');
        foreach ($files as $file){
            if(is_dir($file)){
                self::clearDir($file);
                rmdir($file);
            }else{
                @unlink($file);
            }
        }
    }
}