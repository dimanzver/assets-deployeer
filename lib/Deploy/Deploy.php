<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 18:15
 */
namespace AssetsDeployeer\Deploy;

use AssetsDeployeer\Logger;
use Exception;

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
            try{
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
            }catch (Exception $e){

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
        }
    }

}