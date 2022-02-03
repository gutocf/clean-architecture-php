<?php

namespace App\Presentation\Controller\Api;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\UsersViewUseCase;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersViewController implements ControllerInterface
{

    private $useCase;

    public function __construct(UsersViewUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $id = $this->getId($request);
        $user = $this->useCase->execute($id);

        if (!$user) {
            return new EmptyResponse(404);
        }

        return new JsonResponse(compact('user'));
    }

    private function getId(RequestInterface $request): int
    {
        preg_match('/^\/api\/users\/(?<id>\d+)\/?$/', $request->getUri()->getPath(), $matches);
        return intval($matches['id']);
    }
}
