<?php 

namespace App\Core\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClient
{
    public function post(string $uri, array $options = []): ResponseInterface;
}