<?php
namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CompareService {

    public function __construct(
        private RequestStack $requestStack,
        private ProductRepository $productRepo,
        )
    {
        $this->session = $requestStack->getSession();
        $this->productRepo = $productRepo;
    }

    public function getCompare()
    {
        return $this->session->get("compare", []);
    }

    public function updateCompare($compare)
    {
        return $this->session->set("compare", $compare);
    }

    public function addToCompare($productId)
    {
        $compare = $this->getCompare();

        if(!isset($compare[$productId]))
        {
            // le produit existe dans le panier
            $compare[$productId] = 1;
            $this->updateCompare($compare);
        }
    }

    public function removeToCompare($productId)
    {
        $compare = $this->getCompare();

        if(isset($compare[$productId]))
        {
            unset($compare[$productId]);
            $this->updateCompare($compare);
        }   
    }

    public function ClearCompare()
    {
        $this->updateCompare([]);
    }

    public function getCompareDetails()
    {
        $compare = $this->getCompare();
        $result = [];

        foreach ($compare as $productId => $quantity)
        {
            $product = $this->productRepo->find($productId);
            if($product)
            {
                $result[] = $product;
            }
            else
            {
                unset($compare[$productId]);
                $this->updateCompare($compare);
            }
        }

        return $result;
    }
}