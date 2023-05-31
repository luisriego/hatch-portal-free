<?php

namespace App\Controller\Admin;

use App\Entity\Topic;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TopicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Topic::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnDetail(),
            AssociationField::new('type')
                ->autocomplete(),
            TextField::new('title'),
            TextField::new('subtitle'),
            TextField::new('caseStudy'),
            TextField::new('location'),
            ImageField::new('image')
                ->setRequired(false)
                ->setBasePath('media/topic')
                ->setUploadDir('public/media/topic'),
            TextEditorField::new('challenges')
                ->hideOnIndex(),
            TextEditorField::new('solutions')
                ->hideOnIndex(),
            TextEditorField::new('highlights')
                ->hideOnIndex(),
            BooleanField::new('toPublish'),
        ];
    }
}
