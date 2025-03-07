<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\Port\CreateUserParams;
use App\UseCase\User\CreateUser;
use Exception;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UsersAddController implements ControllerInterface
{
    public function __construct(private CreateUser $addUser)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        try {
            $data = $request->getParsedBody();

            $addUserData = new CreateUserParams(
                $data['name'] ?? null,
                $data['email'] ?? null,
                $data['password'] ?? null
            );

            $this->addUser->create($addUserData);

            $response->getBody()->write(Json::encode(['success' => 'User added']));

            return $response->withStatus(200);
        } catch (Exception $ex) {
            $response->getBody()->write(Json::encode(['error' => $ex->getMessage()]));

            return $response->withStatus(400);
        }
    }
}
