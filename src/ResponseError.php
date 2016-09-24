<?php

namespace Jabran;

use Jabran\Exception\ErrorResponseException;

class ResponseError extends ErrorResponseException {

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $errorType;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * {@inheritDoc}
     */
    public function __construct(\stdClass $response) {
        $this->setCode($response->code);
        $this->setErrorType($response->error_type);
        $this->setErrorMessage($response->error_message);

        $this->setMessage(
            sprintf('(%d) %s %s', $this->getCode(), $this->getErrorType(), $this->getErrorMessage())
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getErrorType() {
       return $this->errorType;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setErrorType($errorType) {
        $this->errorType = $errorType;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getErrorMessage() {
       return $this->errorMessage;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString() {
        echo $this->getMessage();
    }
}