<?php
/**
* Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 0:46
 */
namespace ZxCoder\LocationClient\Entity;

class Location
{
    /** @var string */
    private $name;
    /** @var Coordinates */
    private $coordinates;

    /**
     * @param $name
     * @param Coordinates $coordinates
     */
    public function __construct($name, Coordinates $coordinates)
    {
        $this->name        = $name;
        $this->coordinates = $coordinates;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}