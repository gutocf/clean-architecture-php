<?php

declare(strict_types=1);

namespace App\Test\UseCase\User;

use App\Entity\User;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\Port\UpdateUserParams;
use App\UseCase\User\UpdateUser;
use App\UseCase\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UpdateUserTest extends TestCase
{
    protected UpdateUser $useCase;

    public function testSuccess()
    {
        $data = new UpdateUserParams(1, 'John Doe Jr', 'johndoejr@example.com');
        $user = User::create(1, 'John Doe', 'johndoe@example.com', 'password');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($user);
        $repository->expects($this->once())
            ->method('update')
            ->willReturn(new User(1, 'John Doe', 'johndoe@example.com', 'p@ssw0rd'));
        $this->useCase = new UpdateUser($repository);
        $user = $this->useCase->update($data);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserNotFound()
    {
        $data = new UpdateUserParams(1, 'John Doe Jr', 'johndoejr@example.com');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn(null);
        $this->useCase = new UpdateUser($repository);
        $this->expectException(UserNotFoundException::class);
        $this->useCase->update($data);
    }

    public function testInvalidName()
    {
        $user = User::create(1, 'John Doe', 'johndoe@example.com', 'password');
        $data = new UpdateUserParams(1, null, 'johndoejr@example.com');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($user);
        $this->useCase = new UpdateUser($repository);
        $this->expectException(InvalidNameException::class);
        $this->useCase->update($data);
    }

    public function testInvalidEmail()
    {
        $user = User::create(1, 'John Doe', 'johndoe@example.com', 'password');
        $data = new UpdateUserParams(1, 'John Doe', null);
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($user);
        $this->useCase = new UpdateUser($repository);
        $this->expectException(InvalidEmailException::class);
        $this->useCase->update($data);
    }
}
