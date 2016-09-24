# Instagram PHP Client [![Build Status](https://travis-ci.org/jabranr/instagram-php-client.svg)](https://travis-ci.org/jabranr/instagram-php-client) [![Analytics](https://ga-beacon.appspot.com/UA-50688851-1/instagram-php-client)](https://github.com/igrigorik/ga-beacon)

A easy to use PHP client for Instagram API.

> **Disclaimer:** Unofficial client.


## Install & Usage

1. Add following to your project's `composer.json`

```json
{
  "require": {
    "jabranr/instagram-php-client": "~1.0.*"
  }
}
```

2. Install using [Composer](http://getcomposer.org)

```shell
$ comsposer install
```

3. Register a client at [Instagram Developers](http://instagram.com/developer/clients/register/) and get `client_id`, `client_secret` and `redirect_uri`.

4. Here is a basic use case:

```php
require('path/to/vendor/autoload.php');

$client = new Jabran\Client($client_id = 'string', $secret = 'string', $redirect_uri = 'string', $scope = 'basic+public_content');

// Get an user authentication URL
$authUrl = $client->authenticate();

if (! isset($_GET['code'])) {
	printf('<a href="%s">Login with Instagram</a>', $authUrl);
} else {
    try {

    	// Authorize an authenticated user
        $client = $client->authorize($code);

        // Get user info
        $user = $client->getUser();

        // Get access token
        $token = $client->getUser()->getAccessToken();

    } catch(Jabran\Exception\UnauthorizedUserException $e) {

		// print error message
        echo $e->getMessage();
    }

	// User authorized. Make API calls
	try {

		$response = $client->get('/recent/media', array('count' => 10));

		// Get meta
		$meta = $response->getMeta();

		// Get data
		$data = $response->getData();

		// Get pagination
		$pagination = $response->getPagination();

		// Get raw response
		$raw = $response->getRawResponse();

	} catch(Jabran\Exception\ErrorResponseException $e) {

		// print error message
		echo $e->getMessage();
	}
}

```


## API

This client exposes following API to make calls to Instagram API. If user is authenticated and authorized then a valid access token will automatically be part of any calls made through following API.

#### Make a GET call

```php
$client->get('/path/to/instagram/resource/endpoint', array(parameters));

// i.e.

$client->get('/media/recent', array('count' => 20));
```

#### Make a POST call

```php
$client->post('/path/to/instagram/resource/endpoint', array(postfields));

// i.e.

$client->post('/media/1234567890/likes', array('foo' => 'bar'));
```

#### Make a Search call

```php
$client->search($lat, $lng, $distance = 10, $count = 30, $min_timestamp = null, $max_timestamp = null);

// i.e.

$client->search(20.123123, -123.12321, 5, 50);
```

## Issues / Contribution

If you find an issue, bug or any case that you think can make this library any better then please feel free to open an issue in [issue tracker](https://github.com/jabranr/instagram-php-client/issues).

## License

MIT License - &copy; [Jabran Rafique](http://jabran.me) 2016
