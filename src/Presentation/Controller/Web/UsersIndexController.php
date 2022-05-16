<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\ListUser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersIndexController implements ControllerInterface
{

    public function __construct(
        private ListUser $listUser,
        private Environment $twig
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $s

        $users = $this->listUser->list();
        $html = $this->twig->render('/users/index.html', compact('users'));
        $response->getBody()->write($html);

        return $response;
    }
}
