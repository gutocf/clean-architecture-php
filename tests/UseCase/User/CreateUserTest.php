<?php

namespace App\Test\UseCase\User;

use App\Entity\User;
use App\UseCase\User\CreateUser;
use App\UseCase\User\Exception\InvalidEmailException;
use App\UseCase\User\Exception\InvalidNameException;
use App\UseCase\User\Exception\InvalidPasswordConfirmationException;
use App\UseCase\User\Exception\InvalidPasswordException;
use App\UseCase\User\Exception\UserExistsException;
use App\UseCase\User\Port\CreateUserParams;
use App\UseCase\User\Port\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class CreateUserTest extends TestCase
{
    protected CreateUser $useCase;

    public function testCreate()
    {
        $data = new CreateUserParams('John Doe', 'johndoe@example.com', 'p@ssw0rd', 'p@ssw0rd');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $repository->expects($this->once())
            ->method('create')
            ->willReturn(new User(1, 'John Doe', 'johndoe@example.com', 'p@ssw0rd'));
        $this->useCase = new CreateUser($repository);
        $user = $this->useCase->create($data);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(1, $user->getId());
        $this->assertSame('John Doe', $user->getName());
        $this->assertSame('johndoe@example.com', $user->getEmail());
        $this->assertSame('p@ssw0rd', $user->getPassword());
    }

    public function testCreateUserExistsException()
    {
        $data = new CreateUserParams('John Doe', 'johndoe@example.com', 'p@ssw0rd', 'p@ssw0rd');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(new User(1, 'John Doe', 'johndoe@example.com', 'p@ssw0rd'));
        $this->expectException(UserExistsException::class);
        $this->useCase = new CreateUser($repository);
        $this->useCase->create($data);
    }

    public function testCreateInvalidName()
    {
        $data = new CreateUserParams(null, 'johndoe@example.com', 'p@ssw0rd', 'p@ssw0rd');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $this->useCase = new CreateUser($repository);
        $this->expectException(InvalidNameException::class);
        $this->useCase->create($data);
    }

    public function testCreateInvalidEmail()
    {
        $data = new CreateUserParams('John Doe', null, 'p@ssw0rd', 'p@ssw0rd');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $this->useCase = new CreateUser($repository);
        $this->expectException(InvalidEmailException::class);
        $this->useCase->create($data);
    }

    public function testCreateInvalidPassword()
    {
        $data = new CreateUserParams('John Doe', 'johndoe@example.com');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $this->useCase = new CreateUser($repository);
        $this->expectException(InvalidPasswordException::class);
        $this->useCase->create($data);
    }

    public function testCreateInvalidPasswordConfirmation()
    {
        $data = new CreateUserParams('John Doe', 'johndoe@example.com', '123456', 'abcde');
        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface
         */
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);
        $this->useCase = new CreateUser($repository);
        $this->expectException(InvalidPasswordConfirmationException::class);
        $this->useCase->create($data);
    }
}
