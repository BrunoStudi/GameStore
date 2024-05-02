<?php

namespace App\Controller\Admin;

use App\Entity\Setting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Setting::class;
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
            IdField::new('id')->hideOnForm(),
            TextField::new('website_name'),
            TextField::new('description'),
            IntegerField::new('taxe_rate'),
            ImageField::new('logo')
            -> setBasePath("assets/images/setting")
            -> setUploadDir("/public/assets/images/setting")
            -> setUploadedFileNamePattern('[randomhash].[extension]')
            -> setRequired($pageName === Crud::PAGE_NEW),
            ChoiceField::new('currency')->setChoices([
                'EUR' => 'EUR',
                'USD' => 'USD',
                'JPY' => 'JPY'
            ]),
            UrlField::new('facebookLink'),
            UrlField::new('youtubeLink'),
            UrlField::new('instaLink'),
            TelephoneField::new('phone'),
            TextField::new('street'),
            TextField::new('city'),
            TextField::new('zip_code'),
            TextField::new('state')
        ];
    }
    
}
