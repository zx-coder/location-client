<?php
/**
 * Created by PhpStorm.
 * User: zx-coder
 * Date: 10.10.16
 * Time: 10:03
 */

namespace ZxCoder\LocationClient\Service\LocationFactory;

use ZxCoder\LocationClient\Entity\LocationCollection;

interface LocationFactoryInterface
{
    /**
     * @param $response
     * @return LocationCollection
     */
    public function fromResponse($response);
}
