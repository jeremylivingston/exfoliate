<?php

namespace Exfoliate;

use Exfoliate\Exception\ClientException;
use Exfoliate\Exception\ConnectionException;
use Exfoliate\Factory\FactoryInterface;
use Exfoliate\Factory\SoapClientFactory;

/**
 * @author Jeremy Livingston <jeremyjlivingston@gmail.com>
 */
class SoapClient implements ClientInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Factory\SoapClientFactory
     */
    protected $factory;

    /**
     * @var \SoapClient
     */
    protected $client;

    /**
     * @var mixed
     */
    protected $headers;

    /**
     * @param string $url
     * @param array $options
     * @param Factory\FactoryInterface $factory
     */
    public function __construct($url, array $options = array(), FactoryInterface $factory = null)
    {
        $this->url = $url;
        $this->options = $options;
        $this->factory = $factory ?: new SoapClientFactory();
    }

    /**
     * @param string $method
     * @param mixed $data
     *
     * @throws Exception\ClientException
     * @return mixed
     */
    public function call($method, $data)
    {
        if (!$this->client) {
            $this->initializeClient();
        }

        try {
            return $this->client->__soapCall($method, $data);
        } catch (\SoapFault $soapFault) {
            throw new ClientException(sprintf('Call to %s failed', $method), 0, $soapFault);
        }
    }

    /**
     * @return null|string
     */
    public function getLastRequest()
    {
        return $this->client ? $this->client->__getLastRequest() : null;
    }

    /**
     * @return null|string
     */
    public function getLastResponse()
    {
        return $this->client ? $this->client->__getLastResponse() : null;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @throws Exception\ConnectionException
     */
    protected function initializeClient()
    {
        try {
            $this->client = $this->factory->create($this->url, $this->options);

            if ($this->headers) {
                $this->client->__setSoapHeaders($this->headers);
            }
        } catch (\SoapFault $soapFault) {
            throw new ConnectionException('Client failed to connect', 0, $soapFault);
        }
    }
}