<?php

namespace Jabran\Interfaces;

use Jabran\Interfaces\RequestInterface;

interface ResponseInterface {

    /**
     * Get raw response
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getRawResponse();

    /**
     * Set raw response
     *
     * @param string $response
     * @return self
     * @codeCoverageIgnore
     */
    public function setRawResponse($response);

    /**
     * Set request that triggered this response
     *
     * @param Jabran\Interfaces\RequestInterface $request
     * @return self
     * @codeCoverageIgnore
     */
    public function setRequest(RequestInterface $request);
}
