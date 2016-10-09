<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 13:14
 */

namespace ZxCoder\LocationClient\Entity;


class LocationCollection
{
    /**
     * @var Location[]
     */
    private $locations = [];

    /**
     * @param Location $location
     * @return $this
     */
    public function add(Location $location)
    {
        $this->locations[] = $location;

        return $this;
    }

    /**
     * @return Location[]
     */
    public function getLocations()
    {
        return $this->locations;
    }
}
