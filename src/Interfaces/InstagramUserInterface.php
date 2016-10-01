<?php

namespace Jabran\Interfaces;

interface InstagramUserInterface {

    /**
     * Get access token
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getAccessToken();

    /**
     * Get user id
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getUserId();

    /**
     * Get username
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getUsername();

    /**
     * Set access token
     *
     * @param string $accessToken
     * @return self
     * @codeCoverageIgnore
     */
    public function setAccessToken($accessToken);

    /**
     * Set user id
     *
     * @param string $userId
     * @return self
     * @codeCoverageIgnore
     */
    public function setUserId($userId);

    /**
     * Set username
     *
     * @param string $username
     * @return self
     * @codeCoverageIgnore
     */
    public function setUsername($username);
}
