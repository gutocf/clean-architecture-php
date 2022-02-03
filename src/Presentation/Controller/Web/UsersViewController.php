<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\UsersViewUseCase;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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

    public function handle(RequestInterface $request): ResponseInterface
    {
        $id = $this->getId($request);
        $user = $this->useCase->execute($id);

        if (!$user) {
            return new EmptyResponse(404);
        }

        $html = $this->twig->render('/users/view.html', compact('user'));

        return new HtmlResponse($html);
    }

    private function getId(RequestInterface $request): int
    {
        preg_match('/^\/users\/(?<id>\d+)\/?$/', $request->getUri()->getPath(), $matches);
        return intval($matches['id']);
    }
}
