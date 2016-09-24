<?php

namespace Jabran;

use Jabran\Interfaces\RequestInterface;
use Jabran\Interfaces\ResponseInterface;

class ResponseSuccess implements ResponseInterface {

    /**
     * @var object
     */
    private $meta;

    /**
     * @var object
     */
    private $data;

    /**
     * @var object
     */
    private $pagination;

    /**
     * @var Jabran\Interfaces\RequestInterface
     */
    private $request;

    /**
     * {@inheritDoc}
     */
    public function __construct(ResponseInterface $response) {

        if (property_exists($response->getResponse(), 'meta')) {
            $this->setMeta($response->getResponse()->meta);
        }

        if (property_exists($response->getResponse(), 'data')) {
            $this->setData($response->getResponse()->data);
        }

        if (property_exists($response->getResponse(), 'pagination')) {
            $this->setPagination($response->getResponse()->pagination);
        }

        $this->setRequest($response->getRequest());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setMeta($meta) {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPagination() {
        return $this->pagination;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setPagination($pagination) {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRawResponse() { }

    /**
     * {@inheritDoc}
     */
    public function setRawResponse($response) { }

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