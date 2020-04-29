<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 29.04.20
 * Time: 14:07
 */

namespace AssetsDeployeer\Deploy;


class SftpDeploy implements DeployInterface
{

    protected $connection;
    protected $basePath;
    protected $sftp;

    /**
     * FtpDeploy constructor.
     * @param $host
     * @param $port
     * @param $login
     * @param $password
     * @param $basePath
     */
    public function __construct($host, $port, $login, $password, $basePath)
    {
        $this->connection = ssh2_connect($host, $port);
        if(!ssh2_auth_password($this->connection, $login, $password)){
            exit('SFTP connection error' . PHP_EOL);
        }
        $this->basePath = $basePath;
        $this->sftp = ssh2_sftp($this->connection);
    }

    /**
     * @param string $filepath Relative path to file
     */
    public function upload(string $filepath)
    {
        $pathinfo = pathinfo($filepath);
        $dir = rtrim($this->basePath, '/') . '/' . $pathinfo['dirname'];

        if(!ssh2_sftp_stat($this->sftp, $dir)){
            $this->createSubdirectoryRecursive($pathinfo['dirname']);
        }

        ssh2_scp_send($this->connection, ROOT . '/' . $filepath, $this->basePath . '/' . $filepath);
    }

    protected function createSubdirectoryRecursive(string $resultPath, string $createdPath = ''){
        $resultPath = trim($resultPath, '/');
        $createdPath = trim($createdPath, '/');
        $additional = $createdPath ? preg_quote($createdPath) . '\/' : '';
        preg_match('/(^' . $additional . '\w+)(?:\/|$)/', $resultPath, $matches);
        $dir = $matches[1];
        ssh2_sftp_mkdir($this->sftp, $this->basePath . '/' . $dir);
        if($dir !== $resultPath){
            $this->createSubdirectoryRecursive($resultPath, $dir);
        }
    }
}