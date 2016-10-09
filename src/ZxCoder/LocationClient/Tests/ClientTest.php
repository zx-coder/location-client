<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 12:35
 */

namespace ZxCoder\LocationClient\Tests;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use ZxCoder\LocationClient\Entity\Coordinates;
use ZxCoder\LocationClient\Entity\Location;
use ZxCoder\LocationClient\Entity\LocationCollection;
use ZxCoder\LocationClient\Exception\ErrorResponseException;
use ZxCoder\LocationClient\Exception\UnknownStructureResponseException;
use ZxCoder\LocationClient\Service\Client;
use ZxCoder\LocationClient\Service\LocationFactory\JsonLocationFactory;
use ZxCoder\LocationClient\Service\Transport\JsonTransport;
use ZxCoder\LocationClient\Service\Transport\TransportInterface;
use ZxCoder\LocationClient\Service\Validator\JsonValidator;


class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function getProvidedSuccessTestData()
    {
        $testData =
            [
                (new LocationCollection())
                    ->add(new Location('Name 1', new Coordinates(11, 12)))
                    ->add(new Location('Super Name 2', new Coordinates(110.2, 12))),
                (new LocationCollection())
                    ->add(new Location('name1', new Coordinates(98, 132)))
                    ->add(new Location('name2', new Coordinates(110.2, 12)))
                    ->add(new Location('name3', new Coordinates(10.2, 212))),
            ];

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $newTestData = [];
        foreach ($testData as $index => $testDataItem) {
            $response = [];
            $response['success'] = true;
            $response['data']    = json_decode($serializer->serialize($testDataItem, 'json'), true);
            $newTestData[$index][0] = $response;
        }

        return $newTestData;
    }

    public function getProvidedErrorStructureResponse()
    {
        $testData = [
            [0 => ['data' => ['aasdasd' => ['name']]]]
        ];

        return $testData;
    }

    public function getProvidedErrorResponse()
    {
        $testData = [
            [0 => [
                'data'    => ['message' => 'Error!', 'code' => '1'],
                'success' => false
            ]]
        ];

        return $testData;
    }

    /**
     * @param $response
     * @return \PHPUnit_Framework_MockObject_MockObject|TransportInterface
     */
    private function createMockTransport($response)
    {
        $transport = $this->createMock(TransportInterface::class);
        $transport->method('getResponse')->willReturn($response);

        return $transport;
    }

    /**
     * @dataProvider getProvidedSuccessTestData
     */
    public function testGetLocations($response)
    {
        $transport = $this->createMockTransport($response);
        $client = new Client($transport, new JsonValidator(), new JsonLocationFactory());
        $locationCollection = $client->getLocations();


        foreach ($locationCollection->getLocations() as $location)
        {
            $locationResponse = array_shift($response['data']['locations']);
            $this->assertEquals($locationResponse['name'], $location->getName());
            $this->assertEquals($locationResponse['coordinates']['lat'],  $location->getCoordinates()->getLat());
            $this->assertEquals($locationResponse['coordinates']['long'], $location->getCoordinates()->getLong());
        }
    }

    /**
     * @dataProvider getProvidedErrorStructureResponse
     */
    public function testGetLocationsWithBadResponse($response)
    {
        $this->expectException(UnknownStructureResponseException::class);
        $transport = $this->createMockTransport($response);
        $client = new Client($transport, new JsonValidator(), new JsonLocationFactory());
        $client->getLocations();
    }

    /**
     * @dataProvider getProvidedErrorResponse
     */
    public function testGetLocationsWithErrorResponse($response)
    {
        $this->expectException(ErrorResponseException::class);
        $transport = $this->createMockTransport($response);
        $client = new Client($transport, new JsonValidator(), new JsonLocationFactory());
        $client->getLocations();
    }
}
