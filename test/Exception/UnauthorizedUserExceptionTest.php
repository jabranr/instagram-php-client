<?php

namespace Jabran\Tests\Exception;

use Jabran\Exception\UnauthorizedUserException;

class UnauthorizedUserExceptionTest {

    /**
     * @test
     * @expectedException Jabran\Exception\UnauthorizedUserException
     */
    public function matchExpectedException() {
        throw new UnauthorizedUserException();
    }
}
