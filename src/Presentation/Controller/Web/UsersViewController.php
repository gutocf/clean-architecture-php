<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\UsersViewUseCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersViewController implements ControllerInterface
{

    private $useCase;

    private $twig;

    public function __construct(UsersViewUseCase $useCase, Environment $twig)
    {
        $this->useCase = $useCase;
        $this->twig = $twig;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $user = $this->useCase->execute(intval($args['id']));

        if (!$user) {
            return $response->withStatus(404);
        }

        $html = $this->twig->render('/users/view.html', compact('user'));
        $response->getBody()->write($html);

        return $response;
    }
}
