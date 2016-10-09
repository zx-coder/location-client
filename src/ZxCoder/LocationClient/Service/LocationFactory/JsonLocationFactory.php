<?php
/**
 * Created by PhpStorm.
 * User: zx-coder
 * Date: 10.10.16
 * Time: 10:06
 */

namespace ZxCoder\LocationClient\Service\LocationFactory;


use ZxCoder\LocationClient\Entity\Coordinates;
use ZxCoder\LocationClient\Entity\Location;
use ZxCoder\LocationClient\Entity\LocationCollection;
use ZxCoder\LocationClient\Exception\ErrorResponseException;

class JsonLocationFactory implements LocationFactoryInterface
{
    /**
     * @param  array $response
     * @return LocationCollection
     *
     * @throws ErrorResponseException
     */
    public function fromResponse($response)
    {
        $locationCollection = new LocationCollection();

        if ($response['success'] && isset($response['data']['locations'])) {
            foreach ($response['data']['locations'] as $location) {
                $locationCollection->add(
                    new Location(
                        $location['name'],
                        new Coordinates($location['coordinates']['lat'], $location['coordinates']['long'])
                    )
                );
            }
        } else {
            throw new ErrorResponseException($response['data']['message'], $response['data']['code']);
        }

        return $locationCollection;
    }
}
