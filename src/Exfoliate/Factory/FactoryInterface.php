<?php

namespace Exfoliate\Factory;

/**
 * @author Jeremy Livingston <jeremyjlivingston@gmail.com>
 */
interface FactoryInterface
{
    /**
     * @param string $url
     * @param array $options
     *
     * @return mixed
     */
    public function create($url, array $options = []);
}
