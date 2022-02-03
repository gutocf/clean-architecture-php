<?php

namespace App\Main\Adapter\Http;

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ResponseInterface;

class ResponseEmitter
{
    private $emitter;

    public function __construct()
    {
        $this->emitter = new SapiEmitter();
    }

    public function emit(ResponseInterface $response): bool
    {
        return $this->emitter->emit($response);
    }
}
