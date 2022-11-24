<?php

declare(strict_types=1);

namespace App\Test\UseCase\User;

use App\Entity\User;
use App\UseCase\Port\User\UpdateUserData;
use App\UseCase\Port\UserRepositoryInterface;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\UpdateUser;
use PHPUnit\Framework\TestCase;

class UpdateUserTest extends TestCase
{

    public function testSuccess()
    {
        $user = User::create(1, 'John Doe', 'johndoe@example.com', 'password');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($user);
        $repository->expects($this->once())
            ->method('update')
            ->willReturn(true);
        $this->UpdateUser = new UpdateUser($repository);
        $data = new UpdateUserData(1, 'John Doe Jr', 'johndoejr@example.com');
        $result = $this->UpdateUser->update($data);
        $this->assertTrue($result);
    }

    public function testUserNotFound()
    {
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn(null);
        $this->UpdateUser = new UpdateUser($repository);
        $this->expectException(UserNotFoundException::class);
        $data = new UpdateUserData(1, 'John Doe Jr', 'johndoejr@example.com');
        $this->UpdateUser->update($data);
    }

    public function testInvalidName()
    {
        $user = User::create(1, 'John Doe', 'johndoe@example.com', 'password');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($user);
        $this->UpdateUser = new UpdateUser($repository);
        $this->expectException(InvalidNameException::class);
        $data = new UpdateUserData(1, null, 'johndoejr@example.com');
        $result = $this->UpdateUser->update($data);
    }

    public function testInvalidEmail()
    {
        $user = User::create(1, 'John Doe', 'johndoe@example.com', 'password');
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($user);
        $this->UpdateUser = new UpdateUser($repository);
        $this->expectException(InvalidEmailException::class);
        $data = new UpdateUserData(1, 'John Doe', null);
        $result = $this->UpdateUser->update($data);
    }
}
