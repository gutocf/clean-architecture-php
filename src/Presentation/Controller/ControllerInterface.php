<?php

namespace App\Presentation\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ControllerInterface
{
    public function handle(RequestInterface $request): ResponseInterface;
}
