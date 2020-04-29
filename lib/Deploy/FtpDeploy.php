<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 17:35
 */

namespace AssetsDeployeer\Deploy;

use Exception;

class FtpDeploy implements DeployInterface
{
    protected $connection;
    protected $basePath;

    /**
     * FtpDeploy constructor.
     * @param $host
     * @param $port
     * @param $login
     * @param $password
     * @param $basePath
     * @throws Exception
     */
    public function __construct($host, $port, $login, $password, $basePath)
    {
        $this->connection = ftp_connect($host, $port, 30);
        if(!ftp_login($this->connection, $login, $password))
            exit('FTP connection error' . PHP_EOL);
        $this->basePath = $basePath;
        ftp_pasv($this->connection, FTP_PASSIVE_MODE);
    }

    /**
     * @param string $filepath Relative path to file
     */
    public function upload(string $filepath)
    {
        $pathinfo = pathinfo($filepath);
        $dir = rtrim($this->basePath, '/') . '/' . $pathinfo['dirname'];
        if(!ftp_chdir($this->connection, $dir)){
            ftp_chdir($this->connection, $this->basePath);
            $this->toDirWithCreating($pathinfo['dirname']);
        }
        ftp_put($this->connection, $pathinfo['basename'], ROOT . '/' . $filepath, FTP_BINARY);
    }

    /**
     * Move to need directory with creating need dirs
     * @param string $dir
     */
    protected function toDirWithCreating(string $dir){
        preg_match('/^([^\/]+)(?:\/(.*)){0,1}$/', $dir, $matches); //parse dir on 1 level (when necessary move now) and other

        if(!ftp_chdir($this->connection, $matches[1])){
            ftp_mkdir($this->connection, $matches[1]);
            ftp_chdir($this->connection, $matches[1]);
        }

        if(!empty($matches[2])){
            $this->toDirWithCreating($matches[2]);
        }
    }

    public function __destruct()
    {
        ftp_close($this->connection);
    }
}