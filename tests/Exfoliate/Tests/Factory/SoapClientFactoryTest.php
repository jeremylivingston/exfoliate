<?php

namespace Exfoliate\Tests\Factory;

use Exfoliate\Factory\SoapClientFactory;
use PHPUnit\Framework\TestCase;

class SoapClientFactoryTest extends TestCase
{
    public function testInterfaceImplementationIsValid()
    {
        $factory = new SoapClientFactory();

        $this->assertInstanceOf('Exfoliate\Factory\FactoryInterface', $factory);
    }
}
