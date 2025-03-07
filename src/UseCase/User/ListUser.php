<?php

namespace App\UseCase\User;

use App\Entity\User;
use App\UseCase\User\Port\ListUserParams;
use App\UseCase\User\Port\UserRepositoryInterface;
use App\Util\Pagination\PageInfo;

class ListUser
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    /**
     * Retrieves all users data.
     *
     * @return ListUserParams[]
     */
    public function list(PageInfo $pageInfo): array
    {
        $users = $this->repository->findAll($pageInfo->getStart(), $pageInfo->getPerPage());

        return collection($users)
            ->map(
                function (User $user) {
                    return new ListUserParams(
                        $user->getId(),
                        $user->getName(),
                        $user->getEmail(),
                    );
                }
            )->toArray();
    }
}
