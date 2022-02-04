<?php

namespace App\Presentation\Controller\Api;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\UsersViewUseCase;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, ?array $args = null): ResponseInterface
    {
        $user = $this->useCase->execute(intval($args['id']));

        if (!$user) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(Json::encode(compact('user')));

        return $response;
    }
}
