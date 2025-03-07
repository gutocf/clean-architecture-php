<?php

namespace App\Test\UseCase\User;

use App\Entity\User;
use App\UseCase\User\Exception\UserNotFoundException;
use App\UseCase\User\GetUserById;
use App\UseCase\User\UserRepositoryInterface;
use PHPUnit\Framework\TestCase;

final class GetUserByIdTest extends TestCase
{
    protected GetUserById $useCase;

    public function testGetExistingUser()
    {
        $expected = User::create(1, 'John Doe', 'johndoe@example.com', 'p@ssw0rd');
        /**
 * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface 
*/
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn($expected);
        $this->useCase = new GetUserById($repository);
        $actual = $this->useCase->get(1);
        $this->assertEquals(1, $actual->getId(), 'User ID is equal to 1');
        $this->assertEquals('John Doe', $actual->getName(), 'User ID is equal to John Doe');
    }

    public function testGetNonExistingUser()
    {
        /**
 * @var \PHPUnit\Framework\MockObject\MockObject|\App\UseCase\User\UserRepositoryInterface 
*/
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findById')
            ->willReturn(null);
        $this->useCase = new GetUserById($repository);
        $this->expectException(UserNotFoundException::class);
        $this->useCase->get(1);
    }
}
