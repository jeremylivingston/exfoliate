<?php

namespace Exfoliate\Factory;

/**
 * @author Jeremy Livingston <jeremyjlivingston@gmail.com>
 */
class SoapClientFactory implements FactoryInterface
{
    /**
     * @param string $url
     * @param array $options
     *
     * @throws \Exfoliate\Exception\ConnectionException
     * @return mixed
     */
    public function create($url, array $options = array())
    {
        return new \SoapClient($url, $options);
    }
}