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
        //Not using ssh2_scp_send, ssh2_sftp_mkdir because they are VERY SLOW
        $pathinfo = pathinfo($filepath);
        $dir = rtrim($this->basePath, '/') . '/' . $pathinfo['dirname'];


        if(!ssh2_sftp_stat($this->sftp, $dir)){
//            ssh2_sftp_mkdir($this->sftp, $dir, 0777, true);
            mkdir('ssh2.sftp://' . $this->sftp . $dir, 0777, true);
        }

//        ssh2_scp_send($this->connection, ROOT . '/' . $filepath, $this->basePath . '/' . $filepath);
        file_put_contents('ssh2.sftp://' . $this->sftp . $this->basePath . '/' . $filepath, file_get_contents(ROOT . '/' . $filepath));
    }
}
