<?php

namespace App\Presentation\Controller\Api;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\Port\UserData;
use App\UseCase\UsersIndexUseCase;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersIndexController implements ControllerInterface
{

    private $useCase;

    public function __construct(UsersIndexUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(RequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri();

        $users = collection($this->useCase->execute())
            ->map(function (UserData $user) use ($uri) {
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


        return new JsonResponse(compact('users'));
    }
}
