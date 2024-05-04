<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PagesRepository;
use App\Repository\SettingRepository;
use App\Repository\SlidersRepository;
use App\Repository\CollectionsRepository;
use App\Repository\ProductRepository;
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
        CategoryRepository $categoryRepo,
        PagesRepository $pagesRepo,
        ProductRepository $productRepo,
        Request $request): Response
    {
        $session = $request->getSession();
        $data = $settingRepo->findAll();
        $sliders = $slidersRepo->findAll();
        $collections = $collectionsRepo->findBy(['isMega'=>false]);
        $megaCollections = $collectionsRepo->findBy(['isMega'=>true]);
        //$pages = $pagesRepo->findAll();
        //$products = $productRepo->findAll();
        $headerPages = $pagesRepo->findBy(['isHead' => true]);
        $footerPages = $pagesRepo->findBy(['isFoot' => true]);
        $categories = $categoryRepo->findBy(['isMega'=>true]);

        $session->set("setting", $data[0]);
        $session->set("headerPages", $headerPages);
        $session->set("footerPages", $footerPages);
        $session->set("categories", $categories);
        $session->set("megaCollections", $megaCollections);
        

        return $this->render('home/accueil.html.twig', [
            'controller_name' => 'HomeController',
            'sliders' => $sliders,
            'collections' => $collections,
            'productsBestSeller' => $productRepo->findBy(['isBestSeller'=>true]),
            'productsNewArrival' => $productRepo->findBy(['isNewArrival'=>true]),
            'productsFeatured' => $productRepo->findBy(['isFeatured'=>true]),
            'productsSpecialOffer' => $productRepo->findBy(['isSpecialOffer'=>true])
        ]);
    }
}
