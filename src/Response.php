<?php

namespace Jabran;

use Jabran\Request;
use Jabran\Interfaces\RequestInterface;
use Jabran\Interfaces\ResponseInterface;

class Response implements ResponseInterface {

    /**
     * @var string
     */
    private $rawResponse;

    /**
     * @var \stdClass
     */
    private $response;

    /**
     * @var Jabran\Interfaces\RequestInterface
     */
    private $request;

    /**
     * {@inheritDoc}
     */
    public function __construct($response = '') {
        $this->setRawResponse($response);
    }

    /**
     * Parse/decode raw response
     *
     * @throws \UnexpectedValueException
     * @return Jabran\Response
     */
    public function decode() {
        if ($this->getRawResponse()) {
            $object = json_decode($this->getRawResponse(), false);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \UnexpectedValueException(json_last_error_msg(), 400);
            }

            $this->setResponse($object);
            $this->setRequest(new Request());
        }

        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getRawResponse() {
       return $this->rawResponse;
    }

    /**
     * @param string $rawResponse
     * @throws \UnexpectedValueException
     * @return Jabran\Response
     */
    public function setRawResponse($rawResponse) {
        if (! is_string($rawResponse)) {
            throw new \UnexpectedValueException(
                sprintf('Expected a string as raw response but got "%s" instead.', gettype($rawResponse))
            );
        }

        $rawResponse = trim($rawResponse);
        $this->rawResponse = $rawResponse;
        $this->decode();
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getResponse() {
       return json_decode($this->getRawResponse(), false);
    }

    /**
     * @codeCoverageIgnore
     */
    public function setResponse($response) {
        $this->response = $response;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getRequest() {
       return $this->request;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setRequest(RequestInterface $request) {
        $this->request = $request;
        return $this;
    }
}
