<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions 
    {
        return $actions
        ->add(Crud::PAGE_EDIT, Action::INDEX)
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_EDIT, Action::DETAIL);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id') 
                ->hideOnForm()
                ->hideOnIndex(),
            AssociationField::new('categories'),
            TextField::new('name'),
            SlugField::new('slug') 
                ->setTargetFieldName('name')
                ->hideOnIndex(),
            ImageField::new('imageUrls')
            -> setFormTypeOptions([
                "multiple" => true,
                'attr' => [
                    'accept' => 'image/x-png, image/gif, image/jpeg, image/jpg, image/webp'
                ]
            ])
            -> setBasePath("assets/images/produits")
            -> setUploadDir("/public/assets/images/produits")
            -> setUploadedFileNamePattern('[randomhash].[extension]')
            -> setRequired($pageName === Crud::PAGE_NEW),
            TextField::new('description'),
            TextEditorField::new('more_description')->hideOnIndex(),
            TextEditorField::new('additionnal_infos')->hideOnIndex(),
            MoneyField::new('solde_price') -> setCurrency("EUR"),
            MoneyField::new('regular_price') -> setCurrency("EUR"),
            IntegerField::new('Stock'),
            AssociationField::new('relatedProducts')->hideOnIndex(),
            BooleanField::new('isBestSeller'),
            BooleanField::new('isNewArrival'),
            BooleanField::new('isFeatured'),
            BooleanField::new('isSpecialOffer'),
        ];
    }
}
