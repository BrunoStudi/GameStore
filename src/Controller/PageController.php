<?php

namespace App\Controller;

use App\Repository\PagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/page/{slug}', name: 'app_page')]
    public function index(string $slug, PagesRepository $pageRepo, ): Response
    {
        $page = $pageRepo->findOneBy(["slug"=>$slug]);

        if(!$page)
        {
            // Redirect to error page.
            return $this->render('page/not-found.html.twig', [
                'controller_name' => 'PageController'
            ]);
        }

        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'page' => $page
        ]);
    }

    /*#[Route('/page/notFound', name: 'app_page')]
    public function notFound(): Response
    {
        return $this->render('page/notFound.html.twig', [
            'controller_name' => 'PageController',
            'page' => $page
        ]);*/
}
