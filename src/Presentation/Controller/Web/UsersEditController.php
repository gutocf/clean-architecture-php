<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\UpdateUser;
use App\UseCase\User\ViewUser;
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

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $this->updateUser->update($user);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/users');
        }

        $html = $this->twig->render('/users/edit.html', compact('user'));
        $response->getBody()->write($html);

        return $response;
    }
}
