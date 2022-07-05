<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
