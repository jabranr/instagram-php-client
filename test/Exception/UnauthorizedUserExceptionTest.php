<?php

namespace Jabran\Tests\Exception;

use Jabran\Exception\UnauthorizedUserException;

class UnauthorizedUserExceptionTest {

    /**
     * @expectedException Jabran\Exception\UnauthorizedUserException
     */
    public function testMatchExpectedException() {
        throw new UnauthorizedUserException();
    }
}
