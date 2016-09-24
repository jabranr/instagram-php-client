<?php

namespace Jabran\Interfaces;

interface RequestInterface {

    /**
     * @return string
     */
    public function getUri();

    /**
     * @return string
     */
    public function getResource();

    /**
     * @return array
     */
    public function getParams();

    /**
     * @return string|array
     */
    public function getBody();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return Jabran\Interfaces\ResponseInterface
     */
    public function send();
}