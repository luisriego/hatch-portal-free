<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnDetail(),
            AssociationField::new('area')
                ->autocomplete(),
            TextField::new('title'),
            TextField::new('subtitle')
                ->onlyOnForms(),
            TextField::new('location'),
            TextField::new('url')
                ->onlyOnForms(),
            BooleanField::new('is_active'),
            BooleanField::new('is_accepted')
                ->renderAsSwitch(false)
                ->onlyOnDetail(),
            DateTimeField::new('accepted_on')
                ->onlyOnDetail(),
            TextField::new('image'),
//            ImageField::new('image')
//                ->setRequired(false)
//                ->setBasePath('media/projects')
//                ->setUploadDir('public/media/projects'),
            TextField::new('sumary')
                ->onlyOnForms(),
            TextField::new('slug')
                ->onlyOnDetail(),
            DateTimeField::new('created_on')
                ->onlyOnDetail(),
            DateTimeField::new('updated_on')
                ->onlyOnDetail(),
        ];
    }
}
