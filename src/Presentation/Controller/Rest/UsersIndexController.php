<?php

namespace App\Presentation\Controller\Rest;

use App\Presentation\Controller\ControllerInterface;
use App\UseCase\User\Port\ListUserParams;
use App\UseCase\User\CountUser;
use App\UseCase\User\ListUser;
use App\Util\Pagination\Exception\PaginationException;
use App\Util\Pagination\PageInfoFactory;
use Laminas\Json\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @property \App\UseCase\UsersIndexUseCase $useCase
 */
class UsersIndexController implements ControllerInterface
{

    public function __construct(
        private ListUser $listUser,
        private CountUser $countUser
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, ?array $args = null): ResponseInterface
    {
        try {
            $pageInfo = PageInfoFactory::create($request, $this->countUser->count());
            $users = $this->listUser->list($pageInfo);
            $users = $this->formatOutput($request, $users);
            $response->getBody()->write(Json::encode(compact('users', 'pageInfo')));
        } catch (PaginationException $ex) {
            $response->getBody()->write(
                Json::encode(
                    [
                    'error' => $ex->getMessage(),
                    'code' => $ex->getCode(),
                    ]
                )
            );
        }

        return $response;
    }

    /**
     * Formats the output data.
     *
     * @param  ServerRequestInterface $request
     * @param  ListUserParams[]       $users
     * @return array
     */
    private function formatOutput(ServerRequestInterface $request, array $users): array
    {
        $uri = $request->getUri();

        return collection($users)
            ->map(
                function (ListUserParams $user) use ($uri) {
                    return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    '_links' => [
                        'href' => $uri
                            ->withPath($uri->getPath() . '/' . $user->id)
                            ->withQuery('')
                            ->__toString(),
                        'type' => 'GET',
                        'rel'  => 'self',
                    ],
                    ];
                }
            )
            ->toArray();
    }
}
