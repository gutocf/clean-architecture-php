<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\Port\User\UpdateUserData;
use App\UseCase\User\UpdateUser;
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
            return $response->withStatus(404);
        }

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $updateUserData = new UpdateUserData(
                $id,
                $data['name'],
                $data['email']
            );

            $this->updateUser->update($updateUserData);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/users');
        }

        $html = $this->twig->render('/users/edit.html', compact('user'));
        $response->getBody()->write($html);

        return $response;
    }
}
