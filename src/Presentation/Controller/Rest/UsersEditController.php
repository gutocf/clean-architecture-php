<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\Port\User\UpdateUserData;
use App\UseCase\User\UpdateUser;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class UsersEditController implements ControllerInterface
{

    public function __construct(
        private UpdateUser $updateUser,
        private Environment $twig
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $id = intval($args['id']);
        $user = $this->updateUser->get($id);

        if (!$user) {
            $response->getBody()->write(Json::encode(['error' => 'User not found']));

            return $response->withStatus(404);
        }

        $data = Json::decode($request->getBody()->getContents(), Json::TYPE_ARRAY);

        $result = !$this->updateUser->update(new UpdateUserData(
            $user->getId(),
            $data['name'],
            $data['email']
        ));

        if (!$result) {
            $response->getBody()->write(Json::encode(['error' => 'Error updating user']));

            return $response->withStatus(400);
        }

        $response->getBody()->write(Json::encode(['success' => 'User updated']));

        return $response->withStatus(200);
    }
}
