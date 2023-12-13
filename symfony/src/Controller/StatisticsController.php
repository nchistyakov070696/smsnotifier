<?php

namespace App\Controller;

use App\DTO\StatisticsDTO;
use App\Service\SmsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/statistics', name: 'api_statistics_')]
class StatisticsController extends AbstractController
{
    #[Route('/by-providers',
        name: 'provider_statistics',
        methods: ['POST']
    )]
    public function statisticsByProviders(
        #[MapRequestPayload] StatisticsDTO $statisticDTO,
        SmsService $smsService,
    ): JsonResponse {
        return $this->json([
            'data' => $smsService->getStatistics($statisticDTO),
        ]);
    }
}
