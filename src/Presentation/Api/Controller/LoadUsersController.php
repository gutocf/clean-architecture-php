<?php

namespace App\Presentation\Api\Controller;

use Laminas\Json\Json;
use App\UseCase\LoadUsersUseCase;

/**
 * @property \App\UseCase\LoadUsersUseCase $useCase
 */
class LoadUsersController
{

    private $useCase;

    public function __construct(LoadUsersUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function index()
    {
        $users = $this->useCase->execute();

        header('Content-Type: application/json');

        echo Json::encode(compact('users'));
    }
}
