<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\Port\User\ViewUserData;
use App\UseCase\User\ViewUser;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersViewController implements ControllerInterface
{

    public function __construct(
        private ViewUser $viewUser,
        private Environment $twig
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $id = intval($args['id']);

        try {
            $user = $this->viewUser->view($id);

            $userViewData = new ViewUserData(
                $user->getId(),
                $user->getName(),
                $user->getEmail()
            );

            $html = $this->twig->render('/users/view.html', compact('userViewData'));
            $response->getBody()->write($html);

            return $response;
        } catch (Exception $ex) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/users');
        }
    }
}
