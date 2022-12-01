<?php

namespace CoinGecko;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var StreamInterface
     */
    protected $responseBody;

    /**
     * Response constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return StreamInterface|null
     */
    protected function getBody ()
    {
        if (null !== $this->responseBody) {
            return $this->responseBody;
        }

        return $this->responseBody = $this->response->getBody();
    }

    /**
     * @return string
     */
    public function getContents ()
    {
        $body = $this->getBody();

        return null !== $body
            ? $body->getContents()
            : null;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponseObject ()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getStatusCode ()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return array
     */
    public function toArray ()
    {
        return json_decode($this->getContents(), true);
    }

    /**
     * @return string
     */
    public function toJson ()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return string|null
     */
    public function toString ()
    {
        return $this->getContents();
    }
}
