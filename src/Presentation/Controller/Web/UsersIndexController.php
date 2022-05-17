<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\CountUser;
use App\UseCase\User\ListUser;
use App\Util\Pagination\PageInfo;
use App\Util\Pagination\PageInfoFactory;
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
        private CountUser $countUser,
        private Environment $twig
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $pageInfo = PageInfoFactory::create($request, $this->countUser->count());
        $users = $this->listUser->list($pageInfo);
        $html = $this->twig->render('/users/index.twig', compact('users', 'pageInfo'));
        $response->getBody()->write($html);

        return $response;
    }
}
