<?php

namespace App\Test\UseCase\User;

use App\Entity\User;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\Port\User\AddUserData;
use App\UseCase\User\AddUser;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\InvalidPasswordException;
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

    public function testAddInvalidName()
    {
        $addUserData = new AddUserData(null, 'johndoe@example.com', 'p@ssw0rd');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $this->AddUser = new AddUser($repository);
        $this->expectException(InvalidNameException::class);
        $this->AddUser->add($addUserData);
    }

    public function testAddInvalidEmail()
    {
        $addUserData = new AddUserData('John Doe', null, 'p@ssw0rd');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $this->AddUser = new AddUser($repository);
        $this->expectException(InvalidEmailException::class);
        $this->AddUser->add($addUserData);
    }

    public function testAddInvalidPassword()
    {
        $addUserData = new AddUserData('John Doe', 'johndoe@example.com', null);
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $this->AddUser = new AddUser($repository);
        $this->expectException(InvalidPasswordException::class);
        $this->AddUser->add($addUserData);
    }
}
