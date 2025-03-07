<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\Port\ViewUserParams;
use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\ViewUser;
use Exception;
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
        try {
            $id = intval($args['id']);
            $user = $this->viewUser->view($id);

            $userViewData = new ViewUserParams(
                $user->getId(),
                $user->getName(),
                $user->getEmail(),
            );

            $response->getBody()->write(Json::encode(['user' => $userViewData]));

            return $response;
        } catch (UserNotFoundException $ex) {
            $response->getBody()->write(Json::encode(['error' => $ex->getMessage()]));

            return $response->withStatus(404);
        } catch (Exception $ex) {
            $response->getBody()->write(Json::encode(['error' => $ex->getMessage()]));

            return $response->withStatus(400);
        }
    }
}
