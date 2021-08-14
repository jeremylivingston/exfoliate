<?php

namespace Exfoliate;

/**
 * @author Jeremy Livingston <jeremyjlivingston@gmail.com>
 */
interface ClientInterface
{
    /**
     * Make a call to a SOAP method.
     *
     * @param string $method
     *   The method name.
     * @param array $args
     *   Data to be passed to the client.
     * @param array $options
     *   Client options.
     * @param \SoapHeader|array|null $inputHeaders
     *   Input headers.
     * @param array|null $outputHeaders
     *   Output headers.
     *
     * @return mixed
     * @throws \Exfoliate\Exception\ClientException|\Exfoliate\Exception\ConnectionException
     *
     * @see https://www.php.net/manual/soapclient.soapcall.php
     */
    public function call(string $method, array $args, array $options = array(), $inputHeaders = null, array &$outputHeaders = null);

    /**
     * Get last request made by client.
     *
     * @return string|null
     */
    public function getLastRequest(): ?string;

    /**
     * Get last response.
     *
     * @return string|null
     */
    public function getLastResponse(): ?string;

    /**
     * Set headers used for soap all SOAP requests.
     *
     * @param \SoapHeader|array|null $headers
     */
    public function setHeaders($headers): void;
}
