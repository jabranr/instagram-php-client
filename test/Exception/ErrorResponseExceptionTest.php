<?php

namespace Jabran\Tests\Exception;

use Jabran\Exception\ErrorResponseException;

class ErrorResponseExceptionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     * @expectedException Jabran\Exception\ErrorResponseException
     */
    public function matchExpectedException() {
        throw new ErrorResponseException();
    }
}
