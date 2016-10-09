<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 0:57
 */

namespace ZxCoder\LocationClient\Service\Transport;


interface TransportInterface
{
    /**
     * @return mixed
     */
    public function getResponse();

    /**
     * @param string $method
     * @return void
     */
    public function setMethod($method);

    /**
     * @param string $uri
     * @return void
     */
    public function setUri($uri);
}
