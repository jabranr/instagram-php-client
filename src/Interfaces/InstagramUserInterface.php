<?php

namespace Jabran\Interfaces;

interface InstagramUserInterface {

    /**
     * Get access token
     */
    public function getAccessToken();

    /**
     * Get user id
     */
    public function getUserId();

    /**
     * Get username
     */
    public function getUsername();

    /**
     * Set access token
     */
    public function setAccessToken($accessToken);

    /**
     * Set user id
     */
    public function setUserId($userId);

    /**
     * Set username
     */
    public function setUsername($username);
}