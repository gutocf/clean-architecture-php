<?php

namespace App\Presentation\Web\Controller;

use App\UseCase\LoadUsersUseCase;
use Twig\Environment;

/**
 * @property \App\UseCase\LoadUsersUseCase $useCase
 */
class LoadUsersController
{

    private $useCase;

    private $twig;

    public function __construct(LoadUsersUseCase $useCase, Environment $twig)
    {
        $this->useCase = $useCase;
        $this->twig = $twig;
    }

    public function index()
    {
        $users = $this->useCase->execute();
        echo $this->twig->render('users/index.html', compact('users'));
    }
}
