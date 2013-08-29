<?php

namespace Exfoliate\Tests\Factory;

use Exfoliate\Factory\SoapClientFactory;

class SoapClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterfaceImplementationIsValid()
    {
        $factory = new SoapClientFactory();

        $this->assertInstanceOf('Exfoliate\Factory\FactoryInterface', $factory);
    }
}