<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    public const int PER_PAGE = 10;
    public function __construct(
        private readonly Security $security
    ){

    }

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $user = $this->security->getUser();

        return $this->render('app/index.html.twig', [
            'user' => $user,
        ]);
    }
}
