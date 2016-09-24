<?php

namespace Jabran\Tests;

class Base_TestCase extends \PHPUnit_Framework_TestCase {

    public $clientId;
    public $clientSecret;
    public $redirectUri;
    public $scope;

    public function setUp() {
        $this->clientId = '1234567890';
        $this->clientSecret = 'abcdef1234567890';
        $this->redirectUri = 'http:://foo.bar/redirect';
        $this->scope = 'basic+public_content';
    }

    public function tearDown() {
        $this->clientId = null;
        $this->clientSecret = null;
        $this->redirectUri = null;
        $this->scope = null;
    }
}
