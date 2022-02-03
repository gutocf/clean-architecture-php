<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\LoadUsersUseCase;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

/**
 * @property \App\UseCase\LoadUsersUseCase $useCase
 */
class LoadUsersController implements ControllerInterface
{

    private $useCase;

    private $twig;

    public function __construct(LoadUsersUseCase $useCase, Environment $twig)
    {
        $this->useCase = $useCase;
        $this->twig = $twig;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $users = $this->useCase->execute();
        $html = $this->twig->render('/users/index.html', compact('users'));

        return new HtmlResponse($html);
    }
}
