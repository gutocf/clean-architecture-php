<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\CreateUser;
use App\UseCase\User\Port\CreateUserParams;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class UsersAddController implements ControllerInterface
{

    public function __construct(
        private CreateUser $useCase,
        private Environment $twig
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = null): ResponseInterface
    {
        $error = null;

        $data = new CreateUserParams();

        if ($request->getMethod() === 'POST') {
            try {
                $data = $request->getParsedBody();

                $data = new CreateUserParams(
                    $data['name'],
                    $data['email'],
                    $data['password'],
                    $data['password_confirm'],
                );

                $this->useCase->create($data);

                return $response
                    ->withStatus(302)
                    ->withHeader('Location', '/users');
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        }

        $html = $this->twig->render('/users/add.twig', compact('data', 'error'));
        $response->getBody()->write($html);

        return $response;
    }
}
