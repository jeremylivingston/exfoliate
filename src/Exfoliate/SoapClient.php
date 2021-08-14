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
     * @var \Exfoliate\Factory\FactoryInterface
     */
    protected $factory;

    /**
     * @var \SoapClient|null
     */
    protected $client;

    /**
     * @var \SoapHeader|array|null
     */
    protected $headers;

    /**
     * @param string $url
     * @param array $options
     * @param \Exfoliate\Factory\FactoryInterface|null $factory
     */
    public function __construct(string $url, array $options = array(), FactoryInterface $factory = null)
    {
        $this->url = $url;
        $this->options = $options;
        $this->factory = $factory ?: new SoapClientFactory();
    }

    /**
     * {@inheritDoc}
     */
    public function call(string $method, array $args, array $options = array(), $inputHeaders = null, array &$outputHeaders = null)
    {
        if (!$this->client) {
            $this->initializeClient();
        }

        try {
            /** @psalm-suppress PossiblyNullReference */
            return $this->client->__soapCall($method, $args, $options, $inputHeaders, $outputHeaders);
        } catch (\SoapFault $soapFault) {
            throw new ClientException(sprintf('Call to %s failed', $method), 0, $soapFault);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getLastRequest(): ?string
    {
        return $this->client ? $this->client->__getLastRequest() : null;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastResponse(): ?string
    {
        return $this->client ? $this->client->__getLastResponse() : null;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders($headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Initialize a new client.
     *
     * @throws \Exfoliate\Exception\ConnectionException
     */
    protected function initializeClient(): void
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
