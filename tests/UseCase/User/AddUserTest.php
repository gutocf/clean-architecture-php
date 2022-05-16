<?php

namespace App\Test\UseCase\User;

use App\Entity\User;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\Port\User\AddUserData;
use App\UseCase\User\AddUser;
use App\UseCase\User\Exception\UserExistsException;
use PHPUnit\Framework\TestCase;

/**
 * @property \App\UseCase\User\AddUser $AddUser
 */
final class AddUserTest extends TestCase
{

    public function testAdd()
    {
        $addUserData = new AddUserData('John Doe', 'johndoe@example.com', 'p@ssw0rd');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $repository->expects($this->once())
            ->method('create')
            ->willReturn(true);
        $this->AddUser = new AddUser($repository);
        $result = $this->AddUser->add($addUserData);
        $this->assertTrue($result);
    }

    public function testAddUserExistsException()
    {
        $user = new User(1, 'John Doe', 'johndoe@example.com', 'p@ssw0rd');
        $addUserData = new AddUserData('John Doe', 'johndoe@example.com', 'p@ssw0rd');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn($user);
        $this->expectException(UserExistsException::class);
        $this->AddUser = new AddUser($repository);
        $this->AddUser->add($addUserData);
    }
}
