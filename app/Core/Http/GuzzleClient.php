<?php 

namespace App\Core\Http;

use GuzzleHttp\Client;

use Psr\Http\Message\ResponseInterface;

class GuzzleClient implements HttpClient
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function post(string $uri, array $options = []): ResponseInterface
    {
        return $this->client->post($uri, $options);
    }
}