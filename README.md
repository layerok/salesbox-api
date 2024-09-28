# Salesbox API

```php

$api = new \Layerok\SalesboxApi\SalesboxApi([
    'openapi_api_id' => 'frer33fd',
    'company' => 'google',
    'phone' => '+38xxxxxxxxxx',
    'lang' => 'uk'
]);

// authenticate
$authToken = $api->getAccessToken()['data']['token'];
$api->setAccessToken($authToken);

// offers
$api->getOffers();
$api->createManyOffers();
$api->deleteManyOffers();
$api->getOrderById();

// categories
$api->getCategories();
$api->createCategory();
$api->deleteCategory();
$api->deleteManyCategories();

$apiV4 = new \Layerok\SalesboxApi\SalesboxApiV4();

// authenticated
$apiV4->setAccessToken($api->getAccessToken()['data']['token']);

$apiV4->getOffers();

```