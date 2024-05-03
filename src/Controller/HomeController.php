<?php

namespace App\Controller;

use App\Repository\PagesRepository;
use App\Repository\SettingRepository;
use App\Repository\SlidersRepository;
use App\Repository\CollectionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        SettingRepository $settingRepo, 
        SlidersRepository $slidersRepo, 
        CollectionsRepository $collectionsRepo,
        PagesRepository $pagesRepo,
        Request $request): Response
    {
        $session = $request->getSession();
        $data = $settingRepo->findAll();
        $sliders = $slidersRepo->findAll();
        $collections = $collectionsRepo->findAll();
        $pages = $pagesRepo->findAll();

        $session->set("setting", $data[0]);

        $headerPages = $pagesRepo->findBy(['isHead' => true]);
        $footerPages = $pagesRepo->findBy(['isFoot' => true]);
       
        $session->set("headerPages", $headerPages);
        $session->set("footerPages", $footerPages);

        return $this->render('home/accueil.html.twig', [
            'controller_name' => 'HomeController',
            'sliders' => $sliders,
            'collections' => $collections
        ]);
    }
}
