<?php

namespace Exfoliate;

/**
 * @author Jeremy Livingston <jeremyjlivingston@gmail.com>
 */
interface ClientInterface
{
    /**
     * @param string $method
     * @param mixed $data
     *
     * @return mixed
     */
    public function call($method, $data);

    /**
     * @return null|string
     */
    public function getLastRequest();

    /**
     * @return null|string
     */
    public function getLastResponse();

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers);
}
