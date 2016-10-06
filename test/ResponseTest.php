<?php

namespace Jabran\Tests;

use Jabran\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase {

    public $_response;
    public $_data;

    public function setUp() {
        $this->_response = new Response();
        $this->_data = array('foo' => 'bar');
    }

    public function tearDown() {
        $this->_response = null;
        $this->_data = null;
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function nullAsRawResponse() {
        $this->_response->setRawResponse(null);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function arrayAsRawResponse() {
        $this->_response->setRawResponse($this->_data);
    }

    /**
     * @test
     */
    public function emptyValueAsRawResponse() {
        $this->assertEmpty($this->_response->getRawResponse(), $this->_response);
    }

    /**
     * @test
     */
    public function rawResponseNotNull() {
        $this->_response->setRawResponse(json_encode($this->_data));
        $this->assertInstanceOf('Jabran\Response', $this->_response);
        $this->assertNotNull($this->_response->getRawResponse());
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionCode 400
     */
    public function decodeWithStringValue() {
        $this->_response->setRawResponse('foobar');
        $this->_response->decode();
    }

    /**
     * @test
     */
    public function decodeWithValidValue() {
        $this->_response->setRawResponse(json_encode($this->_data));
        $decode = $this->_response->decode();

        $this->assertInstanceOf('Jabran\Response', $decode);
        $this->assertTrue(is_object($this->_response->getResponse()));

        $this->assertNotNull($this->_response->getRequest());
        $this->assertInstanceOf('Jabran\Request', $this->_response->getRequest());
        $this->assertInstanceOf('Jabran\Interfaces\RequestInterface', $this->_response->getRequest());
    }
}

