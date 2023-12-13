<?php

namespace App\Controller;

use App\DTO\SmsDTO;
use App\Processor\SmsNotificationProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/sms', name: 'api_')]
class SmsController extends AbstractController
{
    #[Route('/send',
        name: 'send_sms',
        methods: ['POST']
    )]
    public function send(
        #[MapRequestPayload] SmsDTO $smsDTO,
        SmsNotificationProcessor $smsNotificationProcessor,
    ): JsonResponse {
        $smsNotificationProcessor->handle($smsDTO);

        return $this->json([
            'status' => 'accepted',
        ]);
    }
}
