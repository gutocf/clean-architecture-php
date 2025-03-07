<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\Port\UpdateUserParams;
use App\UseCase\User\UpdateUser;
use Exception;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class UsersEditController implements ControllerInterface
{

    public function __construct(private UpdateUser $updateUser)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $id = intval($args['id']);

        try {
            $data = $request->getParsedBody();

            $updateUserData = new UpdateUserParams(
                $id,
                $data['name'] ?? null,
                $data['email'] ?? null,
            );

            $this->updateUser->update($updateUserData);

            $response->getBody()->write(Json::encode(['success' => 'User updated']));

            return $response->withStatus(200);
        } catch (Exception $ex) {
            $response->getBody()->write(Json::encode(['error' => $ex->getMessage()]));

            return $response->withStatus(400);
        }
    }
}
