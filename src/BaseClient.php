<?php

namespace Jabran;

use Jabran\Request;
use Jabran\ResponseError;
use Jabran\Interfaces\RequestInterface;
use Jabran\Interfaces\ResponseInterface;
use Jabran\Interfaces\InstagramUserInterface;
use Jabran\Exception\UnauthorizedUserException;

class BaseClient {

    const API_VERSION = '/v1';
    const API_RESPONSE_TYPE = 'code';
    const API_OAUTH_URI = '/oauth/authorize';
    const API_GRANT_TYPE = 'authorization_code';
    const API_HOST = 'https://api.instagram.com';
    const API_ACCESS_TOKEN_URI = '/oauth/access_token';
    const API_DEFAULT_SCOPE = 'basic+public_content';

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var string
     */
    private $scope;

    /**
     * @var string
     */
    private $apiUri;

    /**
     * @var string
     */
    private $authUri;

    /**
     * @var string
     */
    private $accessTokenUri;

    /**
     * @var string
     */
    private $responseCode;

    /**
     * @var Jabran\Interfaces\InstagramUser
     */
    private $user;

    /**
     * Basic setup
     *
     * @param $client_id string
     * @param $secret string
     * @param $redirect_uri string
     * @param $scope string
     * @return self
     */
    public function __construct($client_id, $secret, $redirect_uri, $scope = null) {
        $this->setClientId($client_id);
        $this->setClientSecret($secret);
        $this->setRedirectUri($redirect_uri);
        $this->setScope($scope);

        $this->_bootstrap();
    }

    /**
     * Make a HTTP GET request
     *
     * @param string $resource
     * @param array $params
     * @return Jabran\Interfaces\InstagramResponse
     */
    public function get($resource, $params = array()) {
        return $this->apiCall($resource, $params);
    }

    /**
     * Make a HTTP POST request
     *
     * @param string $resource
     * @param array $postfields
     * @return Jabran\Interfaces\InstagramResponse
     */
    public function post($resource, $postfields = array()) {
        return $this->apiCall($resource, $postfields, Request::HTTP_POST);
    }

    /**
     * Bootstrap and setup defaults
     *
     * @codeCoverageIgnore
     * @return Jabran\BaseClient
     */
    private function _bootstrap() {
        $this->apiUri = sprintf('%s%s', static::API_HOST, static::API_VERSION);
        $this->authUri = sprintf('%s%s', static::API_HOST, static::API_OAUTH_URI);
        $this->accessTokenUri = sprintf('%s%s', static::API_HOST, static::API_ACCESS_TOKEN_URI);

        if (null === $this->getScope()) {
            $this->setScope(static::API_DEFAULT_SCOPE);
        }

        return $this;
    }

    /**
     * Form an authorized API URI
     *
     * @param Jabran\Interfaces\RequestInterface $request
     * @throws Jabran\Exception\UnauthorizedUserException
     * @return string
     */
    protected function getAuthorizedApiUri(RequestInterface $request) {

        if (! $this->getUser() instanceof InstagramUserInterface) {
            throw new UnauthorizedUserException('User is not authorized to request this resource.', 401);
        }

        $uri = sprintf('%s/%s?access_token=%s', $this->getApiUri(), ltrim($request->getResource(), '/'), $this->getUser()->getAccessToken());

        if (is_array($request->getParams()) && count($request->getParams())) {
            $uri = sprintf('%s&%s', $uri, http_build_query($request->getParams()));
        }

        return $uri;
    }

    /**
     * Generic API call method
     *
     * @param string $endpoint
     * @param array $params
     * @param string $method
     * @throws \InvalidArgumentException
     * @return Jabran\Interface\ResponseInterface
     */
    protected function apiCall($endpoint, $params, $method = 'GET') {
        $request = new Request();
        $request->setMethod($method);
        $request->setResource($endpoint);

        if (Request::HTTP_GET === $method) {
            $request->setParams($params);
        } else {
            $request->setBody($params);
        }

        $request->setUri($this->getAuthorizedApiUri($request));
        $response = $request->send();

        return $this->handle($response);
    }

    /**
     * Handle response to parse to appropriate type
     *
     * @param Jabran\Interfaces\ResponseInterface $response
     * @throws Jabran\Exception\ErrorResponseException
     * @return Jabran\Interfaces\ResponseInterface
     */
    protected function handle(ResponseInterface $response) {

        if (property_exists($response->getResponse(), 'meta')) {

            if (property_exists($response->getResponse()->meta, 'error_type')) {
                throw new ResponseError($response->getResponse()->meta);
            }

            return new ResponseSuccess($response);
        }

        if (property_exists($response->getResponse(), 'code')) {
            throw new ResponseError($response->getResponse());
        }

        if (property_exists($response->getResponse(), 'access_token')) {
            return new User($response);
        }

        return $response;
    }

    /**
     * Produce an athentication URL
     *
     * @return string
     */
    public function authenticate() {
        return sprintf('%s?%s', $this->getAuthUri(),
            http_build_query( array(
                'client_id' => $this->getClientId(),
                'redirect_uri' => $this->getRedirectUri(),
                'response_type' => static::API_RESPONSE_TYPE,
                'scope' => urldecode($this->getScope()),
            ))
        );
    }

    /**
     * Authorize an authenticated user to get
     * user object and an access token
     *
     * @param string $responseCode
     * @uses Jabran\BaseClient::post
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @return self
     */
    public function authorize($responseCode = null) {

        if (! $this->getResponseCode()) {
            if (null === $responseCode) {
                throw new \InvalidArgumentException('A response code is required to request access token.', 400);
            }

            $this->setResponseCode($responseCode);
        }

        try {
            $request = new Request();
            $request->setMethod(Request::HTTP_POST);
            $request->setUri($this->getAccessTokenUri());
            $request->setBody(array(
                'client_id' => $this->getClientId(),
                'client_secret' => $this->getClientSecret(),
                'grant_type' => static::API_GRANT_TYPE,
                'redirect_uri' => $this->getRedirectUri(),
                'code' => $this->getResponseCode()
            ));

            $response = $request->send();
            $user = $this->handle($response);

            if (! $user instanceof User) {
                throw new UnauthorizedUserException('User authorization failed.', 401);
            }

            $this->setUser($user);

        } catch(\Exception $e) {
            throw $e;
        }

        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getClientId() {
       return $this->clientId;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getClientSecret() {
       return $this->clientSecret;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setClientSecret($clientSecret) {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getRedirectUri() {
       return $this->redirectUri;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setRedirectUri($redirectUri) {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getScope() {
       return $this->scope;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setScope($scope) {
        $this->scope = $scope;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getApiUri() {
       return $this->apiUri;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setApiUri($apiUri) {
        $this->apiUri = $apiUri;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAuthUri() {
       return $this->authUri;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setAuthUri($authUri) {
        $this->authUri = $authUri;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAccessTokenUri() {
       return $this->accessTokenUri;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setAccessTokenUri($accessTokenUri) {
        $this->accessTokenUri = $accessTokenUri;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getResponseCode() {
       return $this->responseCode;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getUser() {
       return $this->user;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
}
