<?php

namespace App\Services\Notify;

use App\Core\Http\HttpClient;

use Illuminate\Http\JsonResponse;

class NotifyUsersService extends HttpClient
{
    private $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function send(string $message): JsonResponse
    {
        
    }
}