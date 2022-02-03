<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\UsersIndexUseCase;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersIndexController implements ControllerInterface
{

    private $useCase;

    private $twig;

    public function __construct(UsersIndexUseCase $useCase, Environment $twig)
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
