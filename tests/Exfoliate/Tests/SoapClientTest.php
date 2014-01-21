<?php

namespace Exfoliate\Tests;

use Exfoliate\SoapClient;

class SoapClientTest extends \PHPUnit_Framework_TestCase
{
    protected $url;
    protected $options;
    protected $client;
    protected $factory;
    protected $factoryClient;

    public function setUp()
    {
        $this->url = 'test-url';
        $this->options = array('option' => 'option_value');
        $this->factory = $this->getMockBuilder('Exfoliate\Factory\FactoryInterface')->getMock();
        $this->client = new SoapClient($this->url, $this->options, $this->factory);
        $this->factoryClient = $this->getMockBuilder('CoreProxies\Proxy\SoapClient')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        $this->url = null;
        $this->options = null;
        $this->factory = null;
        $this->client = null;
        $this->factoryClient = null;
    }

    public function testInterfaceImplementationIsValid()
    {
        $this->assertInstanceOf('Exfoliate\ClientInterface', $this->client);
    }

    public function testClientIsCreated()
    {
        $this->factory->expects($this->once())
            ->method('create')
            ->with($this->url, $this->options)
            ->will($this->returnValue($this->factoryClient));

        $this->client->call('method', array());
    }

    public function testClientIsCreatedOnce()
    {
        $this->factory->expects($this->once())
            ->method('create')
            ->with($this->url, $this->options)
            ->will($this->returnValue($this->factoryClient));

        $this->client->call('method', array());
        $this->client->call('other_method', array());
    }

    public function testClientIsCalled()
    {
        $method = 'method';
        $data = array('data_element' => 'element_value');
        $options = array('soapaction' => 'some_action', 'uri' => 'some_uri');
        $inputHeaders = new \SoapHeader('http://soapinterop.org/echoheader/', 'echoMeStringRequest');
        $outputHeaders = array('data_element' => 'element_value');

        $this->factoryClient->expects($this->once())
            ->method('__soapCall')
            ->with($method, $data, $options, $inputHeaders, $outputHeaders);

        $this->factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->factoryClient));

        $this->client->call($method, $data, $options, $inputHeaders, $outputHeaders);
    }

    public function testConnectionSoapFaultsThrowConnectionException()
    {
        $this->factory->expects($this->once())
            ->method('create')
            ->with($this->url, $this->options)
            ->will($this->throwException(new \SoapFault('fault_code', 'fault_string')));

        $this->setExpectedException('Exfoliate\Exception\ConnectionException');

        $this->client->call('method', array());
    }

    public function testCallSoapFaultsThrowClientException()
    {
        $this->factory->expects($this->once())
            ->method('create')
            ->with($this->url, $this->options)
            ->will($this->returnValue($this->factoryClient));

        $this->factoryClient->expects($this->once())
            ->method('__soapCall')
            ->will($this->throwException(new \SoapFault('fault_code', 'fault_string')));

        $this->setExpectedException('Exfoliate\Exception\ClientException', 'Call to method failed');

        $this->client->call('method', array());
    }

    public function testUninitializedClientReturnsNullRequest()
    {
        $this->assertNull($this->client->getLastRequest());
    }

    public function testUninitializedClientReturnsNullResponse()
    {
        $this->assertNull($this->client->getLastResponse());
    }

    public function testInitializedClientCallsGetRequest()
    {
        $this->factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->factoryClient));

        $this->factoryClient->expects($this->once())
            ->method('__getLastRequest');

        $this->client->call('method', array());
        $this->client->getLastRequest();
    }

    public function testInitializedClientCallsGetResponse()
    {
        $this->factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->factoryClient));

        $this->factoryClient->expects($this->once())
            ->method('__getLastResponse');

        $this->client->call('method', array());
        $this->client->getLastResponse();
    }

    public function testHeadersAreSet()
    {
        $headers = array('header_one' => 'one_value', 'header_two' => 'two_value');

        $this->factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->factoryClient));

        $this->factoryClient->expects($this->once())
            ->method('__setSoapHeaders')
            ->with($headers);

        $this->client->setHeaders($headers);
        $this->client->call('method', array());
    }

    public function testEmptyHeadersAreNotSet()
    {
        $this->factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->factoryClient));

        $this->factoryClient->expects($this->never())
            ->method('__setSoapHeaders');

        $this->client->call('method', array());
    }
}