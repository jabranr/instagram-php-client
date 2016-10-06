<?php

namespace Jabran\Tests;

use Jabran\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {

    public $_request;

    public function setUp() {
        $this->_request = new Request();
    }

    public function tearDown() {
        $this->_request = null;
    }

    /**
     * @test
     */
    public function supportedMethods() {
        $this->assertTrue($this->_request->isValidRequestMethod('GET'));
        $this->assertTrue($this->_request->isValidRequestMethod('get'));

        $this->assertTrue($this->_request->isValidRequestMethod('POST'));
        $this->assertTrue($this->_request->isValidRequestMethod('post'));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 405
     */
    public function unsupportedMethods() {
        $this->assertFalse($this->_request->isValidRequestMethod('PUT'));
        $this->assertFalse($this->_request->isValidRequestMethod('put'));

        $this->assertFalse($this->_request->isValidRequestMethod('PATCH'));
        $this->assertFalse($this->_request->isValidRequestMethod('patch'));

        $this->assertFalse($this->_request->isValidRequestMethod('DELETE'));
        $this->assertFalse($this->_request->isValidRequestMethod('delete'));

        $this->assertFalse($this->_request->isValidRequestMethod('HEAD'));
        $this->assertFalse($this->_request->isValidRequestMethod('head'));

        $this->assertFalse($this->_request->isValidRequestMethod('LINK'));
        $this->assertFalse($this->_request->isValidRequestMethod('link'));
    }

    /**
     * @test
     */
    public function getNonExistingHeader() {
        $this->assertEmpty($this->_request->getHeader('foo'));
    }

    /**
     * @test
     */
    public function getExistingHeader() {
        $this->_request->setHeader('foo', 'bar');
        $this->assertEquals('bar', $this->_request->getHeader('foo'));
    }

    /**
     * @test
     */
    public function getExistingSetOfHeaders() {
        $this->_request->setHeaders(array(
            'foo' => 'bar',
            'bar' => 'baz'
        ));

        $this->assertEquals('array', gettype($this->_request->getHeaders()));
        $this->assertGreaterThanOrEqual(2, sizeof($this->_request->getHeaders()));
    }

    /**
     * Test unexpected response type
     *
     * @test
     * @expectedException \RuntimeException
     * @expectedException \UnexpectedValueException
     */
    public function sendRequestToGetUnexpectedResponse() {
        $this->_request->setUri('https://jabran.me');
        $this->_request->setMethod(Request::HTTP_GET);
        $response = $this->_request->send();
    }

    /**
     * Test expected response type i.e. JSON
     *
     * @test
     */
    public function sendRequestToGetExpectedResponse() {
        $this->_request->setUri('https://api.github.com/users/jabranr');
        $this->_request->setMethod(Request::HTTP_GET);
        $response = $this->_request->send();

        $this->assertInstanceOf('Jabran\Interfaces\ResponseInterface', $response);
    }
}

