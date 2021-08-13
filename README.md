# Exfoliate

[![Build Status](https://travis-ci.org/jeremylivingston/exfoliate.png?branch=master)](https://travis-ci.org/jeremylivingston/exfoliate)

Exfoliate is a lightweight PHP wrapper for the core SoapClient class.

This library exists to make interactions with SOAP-based web services less painful. Exfoliate wraps SOAP exceptions in
logical event-based exception classes.

The Exfoliate SoapClient is capable being constructed without initializing a connection to the web service. This capability
can improve performance and also improve the handling of connection exceptions.

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require jeremylivingston/exfoliate:dev-master
```

After installing the Exfoliate library, simply create a new instance of the client and call any web service methods you desire:

```php
<?php

use Exfoliate\SoapClient;

$client = new SoapClient('my-service-url', ['trace' => true]);
$response = $client->call('GetUser', ['user_id' => 1234]);

```

Use the `Exfoliate\SoapClient::setHeaders()` method to set any SOAP headers when the client is initialized:

```php
<?php

use Exfoliate\SoapClient;

$client = new SoapClient('my-service-url', ['trace' => true]);

$client->setHeaders(
    new \SoapHeader('my-namespace', 'Auth', ['User' => 'me', 'Password' => 'pw'])
);

$response = $client->call('GetUser', ['user_id' => 1234]);

```

You can retrieve the most recent request and response content via the `Exfoliate\SoapClient::getLastRequest()` and
`Exfoliate\SoapClient::getLastResponse()` methods, respectively:

```php
<?php

use Exfoliate\SoapClient;

$client = new SoapClient('my-service-url', ['trace' => true]);
$response = $client->call('GetUser', ['user_id' => 1234]);

$lastRequest = $client->getLastRequest();
$lastResponse = $client->getLastResponse();

```
