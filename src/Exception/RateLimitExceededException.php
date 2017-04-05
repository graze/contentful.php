<?php
/**
 * @copyright 2016-2017 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Exception;

use GuzzleHttp\Exception\RequestException as GuzzleRequestException;

/**
 * A RateLimitExceededException is thrown when there have been too many requests.
 *
 * The usual RateLimit on the Content Delivery API is 216000 requests/hour and 78 requests/second.
 * Responses cached by the Contentful CDN don't count against the rate limit.
 *
 * @api
 */
class RateLimitExceededException extends RequestException
{
    /**
     * @var int|null
     */
    private $rateLimitReset;

    /**
     * RateLimitExceededException constructor.
     *
     * @param string                       $message
     * @param GuzzleRequestException|null  $previous
     */
    public function __construct($message = "", GuzzleRequestException $previous = null)
    {
        parent::__construct($message, $previous);

        $rateLimitReset = (int) $previous->getResponse()->getHeader('X-Contentful-RateLimit-Reset')[0];

        $this->rateLimitReset = $rateLimitReset;
    }

    /**
     * Returns the number of seconds until the rate limit expires.
     *
     * @return int|null
     */
    public function getRateLimitReset()
    {
        return $this->rateLimitReset;
    }
}
