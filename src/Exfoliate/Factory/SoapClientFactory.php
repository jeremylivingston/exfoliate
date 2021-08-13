<?php

namespace Exfoliate\Factory;

/**
 * @author Jeremy Livingston <jeremyjlivingston@gmail.com>
 */
class SoapClientFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(string $url, array $options = []): \SoapClient
    {
        return new \SoapClient($url, $options);
    }
}
