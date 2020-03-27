<?php
/**
 * Created by PhpStorm.
 * User: diman
 * Date: 27.03.20
 * Time: 17:33
 */

namespace AssetsDeployeer\Deploy;

interface DeployInterface
{
    /**
     * @param string $filepath Relative path to file
     * @return mixed
     */
    public function upload(string $filepath);
}