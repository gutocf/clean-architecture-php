<?php

namespace App\Presentation\Controller\Web;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\Port\UpdateUserParams;
use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\UpdateUser;
use Exception;
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

        $error = null;

        try {
            $user = $this->updateUser->get($id);

            $updateUserData = new UpdateUserParams(
                $id,
                $user->getName(),
                $user->getEmail()
            );

            if (!$user) {
                throw new UserNotFoundException();
            }

            if ($request->getMethod() === 'POST') {
                $data = $request->getParsedBody();

                $updateUserData->name = $data['name'];
                $updateUserData->email = $data['email'];

                $this->updateUser->update($updateUserData);

                return $response
                    ->withStatus(302)
                    ->withHeader('Location', '/users');
            }
        } catch (Exception $ex) {
            $error = $ex->getMessage();
        }

        $html = $this->twig->render('/users/edit.twig', compact('updateUserData', 'error'));
        $response->getBody()->write($html);

        return $response;
    }
}
