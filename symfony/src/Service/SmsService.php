<?php

namespace App\Service;

use App\DTO\StatisticsDTO;
use App\Entity\Customer;
use App\Entity\Sms;
use App\Repository\ProviderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class SmsService
{
    public function __construct(
        private ProviderRepository $providerRepository,
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $em,
    ) {
    }

    public function send(int $fromId, string $phoneNumber, string $text): void
    {
        // use cache?
        $providers = $this->providerRepository->findAll();

        if (!$providers) {
            throw new \Exception('Provider not exists.');
        }

        $customer = $this->em->getReference(Customer::class, $fromId);

        $sms = new Sms();
        $sms->setCustomer($customer);
        $sms->setPhoneNumber($phoneNumber);
        $sms->setIsSent(false);

        $isMessageSent = false;

        foreach ($providers as $provider) {
            $providerSms = clone $sms;
            $providerSms->setProvider($provider);
            $providerSms->setSendingTime();
            $this->em->persist($providerSms);

            // success send message emulation
            if (mt_rand(0, 1)) {
                goto success_scenario;
            }

            try {
                $response = $this->httpClient->request('POST', $provider->getUrl(), ['json' => [
                    'phone_number' => $phoneNumber,
                    'message' => $text,
                ]]);

                if (Response::HTTP_OK !== $response->getStatusCode()) {
                    throw new \Exception();
                }
            } catch (\Exception $e) {
                continue;
            }

            success_scenario:
            $isMessageSent = true;
            $providerSms->setIsSent(true);
            $this->em->persist($providerSms);

            // success send message emulation
            break;
        }

        $this->em->detach($sms);
        $this->em->flush();

        if (!$isMessageSent) {
            throw new \Exception('No one provider is available.');
        }
    }

    public function getStatistics(StatisticsDTO $statisticDTO): array
    {
        $customer = $this->em->getRepository(Customer::class)
            ->findOneBy(['accessToken' => $statisticDTO->accessToken]);

        return $this->providerRepository->statisticsByDateRange(
            $customer->getId(),
            $statisticDTO->dateFrom,
            $statisticDTO->dateTo
        );
    }
}
