<?php

namespace Jabran\Interfaces;

interface RequestInterface {

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getUri();

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getResource();

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function getParams();

    /**
     * @return string|array
     *
     * @codeCoverageIgnore
     */
    public function getBody();

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getMethod();

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    public function getHeaders();

    /**
     * @return Jabran\Interfaces\ResponseInterface
     *
     * @codeCoverageIgnore
     */
    public function send();
}
