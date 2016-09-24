<?php

namespace Jabran;

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
        $response = (string) $response;
        $response = trim($response);

        $this->setRawResponse($response);
        $this->_decode();
    }

    /**
     * Parse/decode raw response
     *
     * @throws \UnexpectedValueException
     * @return Jabran\Response
     */
    private function _decode() {
        if ($this->getRawResponse()) {
            $object = json_decode($this->getRawResponse(), false);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \UnexpectedValueException(json_last_error_msg(), 400);
            }

            $this->setResponse($object);
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
     * @codeCoverageIgnore
     */
    public function setRawResponse($rawResponse) {
        $this->rawResponse = $rawResponse;
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