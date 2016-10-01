<?php

namespace Jabran\Tests\Exception;

use Jabran\Exception\ErrorResponseException;

class ErrorResponseExceptionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException Jabran\Exception\ErrorResponseException
     */
    public function testMatchExpectedException() {
        throw new ErrorResponseException();
    }
}