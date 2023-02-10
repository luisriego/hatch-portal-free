<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\DoctrineTopicRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomepageService
{
    public function __construct(private readonly DoctrineTopicRepository $topicRepository)
    {
    }

    public function handle(): array
    {
//        if (null === $result = $this->topicRepository->findRandomTreeOrFail()) {
//            throw new NotFoundHttpException();
//        }
//
//        return $result;
        return [];
//        return [
//            [
//                'title' => 'Inovar na transição energética',
//                'subtitle' => 'Defendendo um futuro de baixo carbono.',
//                'case_study' => 'Eletrolizadores de membrana de intercambio de prótons (PEM) 20MW'
//            ],
//            [
//                'title' => 'Inovar nas soluções urbanas',
//                'subtitle' => 'Cidades mais inteligentes não são só ideais sociais, são um imperativo econômico',
//                'case_study' => 'O impacto socioeconômico do estudo Gautrain'
//            ],
//            [
//                'title' => 'Inovação na mineração',
//                'subtitle' => 'Abordagens para uma nova era da mineração',
//                'case_study' => 'Planta piloto produz 40% a mais de alumínio'
//            ]
//        ];
    }
}
