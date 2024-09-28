<?php

namespace Layerok\SalesboxApi;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;

class SalesboxApiV4
{
    protected $guzzleClient;

    protected $openApiId;

    protected $companyId;

    protected $phone;

    protected $lang;

    protected $accessToken;

    public function __construct(array $config = [])
    {
        $this->openApiId = $config['open_api_id'];
        $this->phone = $config['phone'];
        $this->companyId = $config['company_id'];
        $this->lang = $config['lang'];

        $baseUrl = 'https://prod.salesbox.me/api/v4/companies/'.$this->companyId.'/';

        $handler = HandlerStack::create();

        $handler->push(Middleware::mapRequest(function (RequestInterface $request) {
            if ($this->accessToken) {
                return Utils::modifyRequest($request, [
                    'set_headers' => [
                        'Authorization' => sprintf('Bearer %s', $this->accessToken),
                    ],
                ]);
            }

            return $request;
        }));

        $baseConfig = [
            'base_uri' => $baseUrl,
            'handler' => $handler,
        ];
        $this->guzzleClient = new Client($baseConfig);
    }

    public function setAccessToken($token): void
    {
        $this->accessToken = $token;
    }

    public function getOffers(array $params = [], array $guzzleOptions = [])
    {
        // onlyAvailable, isGrouped, page, pageSize - query params
        $query = [
            'lang' => $this->lang,
        ];
        $options = [
            'query' => array_merge($query, $params),
        ];

        $mergedOptions = array_merge($options, $guzzleOptions);
        $response = $this->guzzleClient->get('offers/filter', $mergedOptions);

        // note: if you forgot to authorize this request, then this endpoint will return different response structure
        // seems like it is the structure of previous api version
        // or maybe it is made on purpose
        return json_decode($response->getBody(), true);
    }
}
