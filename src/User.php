<?php

namespace Jabran;

use Jabran\Interfaces\RequestInterface;
use Jabran\Interfaces\ResponseInterface;
use Jabran\Interfaces\InstagramUserInterface;

class User implements InstagramUserInterface, ResponseInterface {

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $bio;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $profilePicture;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var Jabran\Interfaces\RequestInterface
     */
    private $request;

    /**
     * {@inheritDoc}
     */
    public function __construct(ResponseInterface $response) {

        $res = $response->getResponse();

        $this->setUserId($res->user->id);
        $this->setBio($res->user->bio);
        $this->setWebsite($res->user->website);
        $this->setFullName($res->user->full_name);
        $this->setUsername($res->user->username);
        $this->setProfilePicture($res->user->profile_picture);
        $this->setAccessToken($res->access_token);

        $this->setRequest($response->getRequest());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getUserId() {
       return $this->userId;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getBio() {
       return $this->bio;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setBio($bio) {
        $this->bio = $bio;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getWebsite() {
       return $this->website;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setWebsite($website) {
        $this->website = $website;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getFullName() {
       return $this->fullName;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setFullName($fullName) {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getUsername() {
       return $this->username;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getProfilePicture() {
       return $this->profilePicture;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setProfilePicture($profilePicture) {
        $this->profilePicture = $profilePicture;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAccessToken() {
       return $this->accessToken;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
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