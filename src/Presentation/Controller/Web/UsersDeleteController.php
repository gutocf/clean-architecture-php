<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\DeleteUser;
use App\UseCase\User\Exception\UserNotFoundException;
use Exception;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersDeleteController implements ControllerInterface
{

    public function __construct(
        private DeleteUser $deleteUser,
        private Environment $twig
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, ?array $args = null): ResponseInterface
    {
        try {
            $id = intval($args['id']);
            $this->deleteUser->delete($id);
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/users');
        } catch (UserNotFoundException $ex) {
            $response->getBody()->write(Json::encode(['error' => $ex->getMessage()]));

            return $response->withStatus(404);
        } catch (Exception $ex) {
            $response->getBody()->write(Json::encode(['error' => $ex->getMessage()]));

            return $response->withStatus(400);
        }
    }
}
