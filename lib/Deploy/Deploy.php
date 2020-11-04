<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 18:15
 */
namespace AssetsDeployeer\Deploy;

use AssetsDeployeer\FilesCacher;
use AssetsDeployeer\Logger;

class Deploy
{
    /**@var DeployInterface $instance*/
    protected static $instance;

    /**
     * Get deploy instance
     *
     * @return DeployInterface
     */
    public static function getInstance() : DeployInterface {
        if(!static::$instance){
            switch (DEPLOY_WAY){
                case 'ftp': {
                    static::$instance = new FtpDeploy(FTP_HOST, FTP_PORT, FTP_LOGIN, FTP_PASSWORD, FTP_BASEPATH);
                    break;
                }
                case 'sftp': {
                    static::$instance = new SftpDeploy(SFTP_HOST, SFTP_PORT, SFTP_LOGIN, SFTP_PASSWORD, SFTP_BASEPATH);
                    break;
                }
                default: {
                    exit('Deploy way not found' . PHP_EOL);
                }
            }
        }
        return static::$instance;
    }

    /**
     * Upload some files to server
     *
     * @param array $files Relative files paths
     */
    public static function uploadFiles(array $files){
        foreach ($files as $file){
            Logger::log('Uploading ' . $file);
            static::getInstance()->upload($file);
            FilesCacher::saveInCache([$file]);
        }
    }

    public static function removeOldFiles() {
        foreach (DIRECTORIES as $dir) {
            $path = ROOT . '/' . $dir;
            $files = static::getInstance()->getFilesListRecursive($dir);
            foreach ($files as $file) {
                if(!file_exists($path . '/' . $file)) {
                    Logger::log('Delete old file ' . $dir . '/' . $file);
                    self::getInstance()->removeFile($dir . '/' . $file);
                }
            }
        }
    }
}