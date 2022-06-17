<div id="top"></div>
<div align="center"> 
  <h1 align="center">Foodics OAuth 2.0 Client</h1>
</div>

## Overview

To use this package, it will be necessary to have a Foodics client ID and client secret. These are referred to as `{client-id}` and `{client-secret}` in the documentation.


## Installation

You can install the package via composer:

```bash
    composer required shabeer/foodics-ouath2-merchant
```
<p align="right">(<a href="#top">back to top</a>)</p>

## Usage

### Authorization Code Flow

```php
<?php

require_once './vendor/autoload.php';

use Foodics\OAuth2\Client\Provider\Foodics;

$provider = new Foodics([
    'clientId'     => '{client-id}', // The client ID assigned to you by Salla
    'clientSecret' => '{client-secret}', // The client password assigned to you by Salla
    'redirectUri'  => 'https://yourservice.com/callback_url', // the url for current page in your service
]);

if (!isset($_GET['code']) || empty($_GET['code'])) {
    // If we don't have an authorization code then get one
    $authUrl = $provider
        ->setBaseUrl('https://console.foodics.com')
        ->getAuthorizationUrl([
            'scope' => 'general.read',
        ]);

    header('Location: '.$authUrl);
    exit;
}

// Try to obtain an access token by utilizing the authorisations code grant.
try {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    //
    // ## Access Token
    //
    // You should store the access token
    // which may use in authenticated requests against the Salla's API
    echo 'Access Token: '.$token->getToken()."<br>";

    //
    // ## Refresh Token
    //
    // You should store the refresh token somewhere in your system because the access token expired after 14 days
    // so you can use the refresh token after that to generate a new access token without asking any access from the merchant
    //
    // $token = $provider->getAccessToken(new RefreshToken(), ['refresh_token' => $token->getRefreshToken()]);
    //
    echo 'Refresh Token: '.$token->getRefreshToken()."<br>";

    //
    // ## Expire date
    //
    // This helps you to know when the access token will be expired
    // so before that date, you should generate a new access token using the refresh token
    echo 'Expire Date : '.$token->getExpires()."<br>";


    /** @var \Foodics\OAuth2\Client\Provider\FoodicsUser $user */
    $user = $provider->getResourceOwner($token);


    var_export($user->toArray());


} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
    // Failed to get the access token or merchant details.
    // show a error message to the merchant with good UI
    exit($e->getMessage());
}
```
<p align="right">(<a href="#top">back to top</a>)</p>

## Refreshing a Token

Refresh tokens are only provided to applications that request offline access. You can specify offline access by passing the scope option in your getAuthorizationUrl() request.

```php
use Foodics\OAuth2\Client\Provider\Foodics;

$provider = new Foodics([
    'clientId' => '{client-id}',
    'clientSecret' => '{client-secret}',
]);

$refreshToken = 'FromYourStoredData';
$token = $provider->getAccessToken('refresh_token', ['refresh_token' => $refreshToken]);


## Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. 
Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. 
You can also simply open an issue with the tag "enhancement". Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>
