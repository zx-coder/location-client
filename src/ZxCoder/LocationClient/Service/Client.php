<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 0:53
 */

namespace ZxCoder\LocationClient\Service;

use ZxCoder\LocationClient\Entity\LocationCollection;
use ZxCoder\LocationClient\Exception\ErrorResponseException;
use ZxCoder\LocationClient\Exception\UnknownStructureResponseException;
use ZxCoder\LocationClient\Service\Transport\TransportInterface;
use ZxCoder\LocationClient\Service\Validator\ValidatorInterface;
use ZxCoder\LocationClient\Service\LocationFactory\LocationFactoryInterface;

class Client
{
    /**
     * @var TransportInterface
     */
    private $transport;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var LocationFactoryInterface
     */
    private $locationFactory;

    /**
     * @param TransportInterface $transport
     * @param ValidatorInterface $validator
     * @param LocationFactoryInterface $locationFactory
     */
    public function __construct(
        TransportInterface $transport,
        ValidatorInterface $validator,
        LocationFactoryInterface $locationFactory)
    {
        $this->transport       = $transport;
        $this->validator       = $validator;
        $this->locationFactory = $locationFactory;
    }


    /**
     * @return LocationCollection
     * @throws UnknownStructureResponseException
     * @throws ErrorResponseException
     */
    public function getLocations()
    {
        $response = $this->transport->getResponse();
        if ($this->validator->isValidResponse($response)) {
            return $this->locationFactory->fromResponse($response);
        }

        throw new UnknownStructureResponseException();
    }
}
