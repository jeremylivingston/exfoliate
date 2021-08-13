<?php

namespace Exfoliate\Factory;

/**
 * @author Jeremy Livingston <jeremyjlivingston@gmail.com>
 */
interface FactoryInterface
{
    /**
     * Create a soap client.
     *
     * @param string $url
     *   The URI of the WSDL file.
     * @param array $options
     *   List of creation options.
     *
     * @return mixed
     *
     * @throws \Exfoliate\Exception\ConnectionException
     */
    public function create(string $url, array $options = []);
}
