<?php
/**
 * Created by PhpStorm.
 * User: rouven
 * Date: 05.04.17
 * Time: 14:40
 */

namespace Contentful\Exception;

use GuzzleHttp\Exception\RequestException as GuzzleRequestException;

abstract class RequestException extends \RuntimeException
{
    /**
     * @var GuzzleRequestException
     */
    private $previous;

    /**
     * @var string|null
     */
    private $requestId = null;

    public function __construct($message = "", GuzzleRequestException $previous)
    {
        parent::__construct($message, 0, $previous);

        $this->previous = $previous;

        if ($this->hasResponse()) {
            $this->requestId = $this->getResponse()->getHeader('X-Contentful-Request-Id');
        }
    }

    /**
     * Get the request that caused the exception
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest()
    {
        return $this->previous->getRequest();
    }

    /**
     * Get the associated response
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->previous->getResponse();
    }

    /**
     * Check if a response was received
     *
     * @return bool
     */
    public function hasResponse()
    {
        return $this->previous->hasResponse();
    }
}