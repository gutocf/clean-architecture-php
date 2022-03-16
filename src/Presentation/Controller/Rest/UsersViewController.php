<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\ViewUser;
use App\UseCase\UsersViewUseCase;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersViewController implements ControllerInterface
{

    public function __construct(private ViewUser $viewUser)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, ?array $args = null): ResponseInterface
    {
        $user = $this->viewUser->view(intval($args['id']));

        if (!$user) {
            return $response->withStatus(404);
        }

        $response->getBody()->write(Json::encode(compact('user')));

        return $response;
    }
}
