<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\UpdateUser;
use App\UseCase\User\ViewUser;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class UsersEditController implements ControllerInterface
{

    public function __construct(
        private UpdateUser $updateUser,
        private ViewUser $viewUser,
        private Environment $twig
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $user = $this->viewUser->view($args['id']);

        if (!$user) {
            return $response->withStatus(404);
        }

        if ($request->getMethod() !== 'PUT') {
            return $response->withStatus(405);
        }

        $data = Json::decode($request->getBody()->getContents(), Json::TYPE_ARRAY);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $this->updateUser->update($user);

        return $response->withStatus(200);
    }
}
