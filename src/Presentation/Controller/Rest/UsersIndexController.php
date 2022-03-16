<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\Port\User\ListUserData;
use App\UseCase\Port\UserData;
use App\UseCase\User\ListUser;
use App\UseCase\UsersIndexUseCase;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersIndexController implements ControllerInterface
{

    public function __construct(private ListUser $listUser)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, ?array $args = null): ResponseInterface
    {
        $uri = $request->getUri();

        $users = collection($this->listUser->list())
            ->map(function (ListUserData $user) use ($uri) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    '_links' => [
                        'href' => $uri
                            ->withPath($uri->getPath() . '/' . $user->id)
                            ->__toString(),
                        'type' => 'GET',
                        'rel'  => 'self',
                    ],
                ];
            })
            ->toArray();

        $response->getBody()->write(Json::encode(compact('users')));

        return $response;
    }
}
