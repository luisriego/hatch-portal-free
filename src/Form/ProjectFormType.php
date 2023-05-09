<?php

namespace App\Form;

use App\Entity\Project;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('area', EntityType::class, array(
                'class' => 'App\Entity\Area',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a');
                },
            ))
//            ->add('area', ChoiceType::class, [
//                'mapped' => false,
//                'choices' => [
//                    'Selecione uma... ' => null,
//                    'Energia' => '1',
//                    'Infraestrutura' => '2',
//                    'Metais e Minerais' => '3',
//                ],
//            ])
            ->add('title')
            ->add('subtitle')
            ->add('location')
            ->add('photo', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image(['maxSize' => '4096k']),
                ],
            ])
            ->add('next', SubmitType::class)
//            ->add('addChallenge', ButtonType::class,)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
