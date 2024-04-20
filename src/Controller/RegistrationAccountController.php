<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationAccountController extends AbstractController
{
    #[Route('/account', name: 'app_account', methods: ['POST'])]
    public function registerAccount(UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        dd($userPasswordHasher);
        return $this->json([
            'message' => 'Registro de uma nova conta',
            'path' => 'src/Controller/AccountController.php',
        ]);
    }
}
