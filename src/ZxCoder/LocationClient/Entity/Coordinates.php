<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 0:49
 */

namespace ZxCoder\LocationClient\Entity;


class Coordinates
{
    /** @var float */
    private $lat;
    /** @var float */
    private $long;

    /**
     * @param $lat
     * @param $long
     */
    public function __construct($lat, $long)
    {
        $this->lat  = $lat;
        $this->long = $long;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLong()
    {
        return $this->long;
    }
}