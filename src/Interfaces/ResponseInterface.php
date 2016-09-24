<?php

namespace Jabran\Interfaces;

use Jabran\Interfaces\RequestInterface;

interface ResponseInterface {

    /**
     * Get raw response
     *
     * @return string
     */
    public function getRawResponse();

    /**
     * Set raw response
     *
     * @param string $response
     * @return self
     */
    public function setRawResponse($response);

    /**
     * Set request that triggered this response
     *
     * @param Jabran\Interfaces\RequestInterface $request
     * @return self
     */
    public function setRequest(RequestInterface $request);
}