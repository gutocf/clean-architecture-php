<?php

namespace App\Presentation\Controller\Api;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\LoadUsersUseCase;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @property \App\UseCase\LoadUsersUseCase $useCase
 */
class LoadUsersController implements ControllerInterface
{

    private $useCase;

    public function __construct(LoadUsersUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $users = $this->useCase->execute();

        return new JsonResponse($users);
    }
}
