<?php

namespace App\Form;

use App\Entity\Author;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AuthorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('avatar', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image(['maxSize' => '512k']),
                ],
            ])
            ->add('resume', CKEditorType::class)
            ->add('position')
            ->add('email')
            ->add('next', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
