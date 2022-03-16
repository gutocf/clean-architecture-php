<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\DeleteUser;
use App\UseCase\User\Exception\UserNotFoundException;
use Exception;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersDeleteController implements ControllerInterface
{

    public function __construct(private DeleteUser $deleteUser)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, ?array $args = null): ResponseInterface
    {
        try {
            $id = intval($args['id']);

            $this->deleteUser->delete($id);

            $response->getBody()->write(Json::encode(['message' => 'User deleted']));

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
