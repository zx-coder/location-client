<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 1:09
 */

namespace ZxCoder\LocationClient\Service\Transport;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use ZxCoder\LocationClient\Exception\JsonWrongFormatResponseException;
use ZxCoder\LocationClient\Exception\TransportException;

class JsonTransport implements TransportInterface
{
    /** @var string */
    private $method = 'GET';
    /** @var string */
    private $uri;

    /**
     * @return array
     * @throws TransportException
     * @throws JsonWrongFormatResponseException
     */
    public function getResponse()
    {
        try {
            $client = new Client();
            $r = $client->request($this->method, $this->uri);
            $body = $r->getBody();

            $json_body = json_decode($body, true);

            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new JsonWrongFormatResponseException();
            }

            return $json_body;
        } catch(GuzzleException $exception) {
            throw new TransportException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * {@inheritDoc}
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }
}
