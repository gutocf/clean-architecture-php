<?php

namespace App\Test\UseCase\User;

use App\Entity\User;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\GetUserById;
use PHPUnit\Framework\TestCase;

/**
 * @property \App\UseCase\User\GetUserById $GetUserById
 */
final class GetUserByIdTest extends TestCase
{
    public function testGetExistingUser()
    {
        $expected = User::create(1, 'John Doe', 'johndoe@example.com', 'p@ssw0rd');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($expected);
        $this->GetUserById = new GetUserById($repository);
        $actual = $this->GetUserById->get(1);
        $this->assertEquals(1, $actual->getId(), 'User ID is equal to 1');
        $this->assertEquals('John Doe', $actual->getName(), 'User ID is equal to John Doe');
    }

    public function testGetNonExistingUser()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn(null);
        $this->GetUserById = new GetUserById($repository);
        $this->expectException(UserNotFoundException::class);
        $this->GetUserById->get(1);
    }
}
