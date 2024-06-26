<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpKernel\KernelInterface;

class Data extends Fixture
{
    /** KernelInterface $appKernel */
    private $appKernel;
    private $rootDir;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
        $this->rootDir = $appKernel->getProjectDir();
    }
    
    public function load(ObjectManager $manager): void
    {
        $filename = $this->rootDir.'/src/DataFixtures/Data/products.json';
        $data = file_get_contents($filename);

        $products_json = json_decode($data);
        $products = [];
        foreach ($products_json as $product_item)
        {
            $product = new Product();
            $product->setName($product_item->name)
                    ->setDescription($product_item->description)
                    ->setMoreDescription($product_item->more_description)
                    ->setImageUrls($product_item->imageUrls)
                    ->setSoldePrice($product_item->solde_price*100)
                    ->setRegularPrice($product_item->regular_price*100)
            ;
            $products[] = $product_item;  
            $manager->persist($product); 
        }
        $manager->flush();
    }
}
