<?php

namespace Jabran;

use Jabran\Response;
use Jabran\Interfaces\RequestInterface;

class Request implements RequestInterface {

    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';

    const API_TIMEOUT = 30;
    const API_USER_AGENT = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $resource;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string|array
     */
    private $body;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $headers;

    /**
     * Make a call
     *
     * @return Jabran\Interfaces\ResponseInterface
     */
    public function send() {

        // Setup cURL
        $curl = curl_init();

        // Setup cURL defaults
        curl_setopt($curl, CURLOPT_URL, $this->getUri());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, static::API_TIMEOUT);
        curl_setopt($curl, CURLOPT_USERAGENT, static::API_USER_AGENT);

        // Setup cURL post options
        if (static::HTTP_POST === strtoupper($this->getMethod())) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getBody());
        }

        // Send request
        $result = curl_exec($curl);

        // Cache cURL info
        $curlErrorCode = curl_errno($curl);
        $curlErrorMessage = curl_error($curl);
        $curlHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlTotalTime = curl_getinfo($curl, CURLINFO_TOTAL_TIME);

        // Close cURL
        curl_close($curl);

        // @todo Add more common cURL response errors
        if (CURLE_OK === $curlErrorCode) {
            $response = new Response($result);
            $response->setRequest($this);
            return $response;
        } else {
            throw new \RunTimeException($curlErrorMessage, $curlHttpCode);
        }
    }

    /**
     * Validate available methods
     *
     * @param string $method
     * @return bool
     */
    protected function isValidRequestMethod($method) {
        switch ($method) {
            case static::HTTP_GET:
            case static::HTTP_POST:
                return true;
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setUri($uri) {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setResource($resource) {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setParams($params) {
        $this->params = $params;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setHeaders(array $headers) {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getHeader($header) {
        return isset($this->headers[$header]) ? $this->headers[$header] : '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function setHeader($key, $value) {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setMethod($method) {

        if (! $this->isValidRequestMethod($method)) {
            throw new \InvalidArgumentException(
                sprintf('Unsupported method "%s" requested.', $method), 400);
        }

        $this->method = $method;
        return $this;
    }
}