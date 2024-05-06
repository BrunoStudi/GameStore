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
            //'products'=> $products,
            'productsBestSeller' => $productRepo->findBy(['isBestSeller'=>true]),
            'productsNewArrival' => $productRepo->findBy(['isNewArrival'=>true]),
            'productsFeatured' => $productRepo->findBy(['isFeatured'=>true]),
            'productsSpecialOffer' => $productRepo->findBy(['isSpecialOffer'=>true])
        ]);
    }

    #[Route('/product/{slug}', name: 'app_product_by_slug')]
    public function showProduct(string $slug, ProductRepository $productRepo) 
    {
        $product = $productRepo->findOneBy(['slug'=>$slug]);

        if(!$product)
        {
            //error
            return $this->redirectToRoute('app_error');
        }

        return $this->render('product\product_slug.html.twig', [
            'product'=>$product
        ]);
    }

    #[Route('/product/get/{id}', name: 'app_product_by_id')]
    public function getProductById(string $id, ProductRepository $productRepo) 
    {
        $product = $productRepo->findOneBy(['id'=>$id]);

        if(!$product)
        {
            //error
            return $this->json(false);
        }

        return $this->json([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'imagesUrls' => $product->getImageUrls(),
            'soldePrice' => $product->getSoldePrice(),
            'regularPrice' => $product->getRegularPrice()
        ]);
    }

    #[Route('/error', name: 'app_error')]
    public function errorPage() 
    {
        return $this->render('page/not-found.html.twig', [
            'controller_name' => 'PageController'
        ]);
    }
}
