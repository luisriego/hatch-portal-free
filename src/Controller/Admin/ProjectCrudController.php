<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
            TextField::new('subtitle'),
            TextField::new('location'),
            TextField::new('url'),
            ImageField::new('image')
                ->setRequired(false)
                ->setBasePath('media/projects')
                ->setUploadDir('public/media/projects'),
            CollectionField::new('challenges')
//                ->setFormTypeOption('by_reference', false)
                ->hideOnIndex(),
            CollectionField::new('solutions')
                ->setFormTypeOption('by_reference', false)
                ->hideOnIndex(),
            CollectionField::new('highlights')
                ->setFormTypeOption('by_reference', false)
                ->hideOnIndex(),
        ];
    }
}
