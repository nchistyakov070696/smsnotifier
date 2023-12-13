<?php

namespace App\Entity;

use App\Repository\SmsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SmsRepository::class)]
class Sms
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'smses')]
    private Customer $customer;

    #[ORM\ManyToOne(targetEntity: Provider::class, inversedBy: 'smses')]
    private Provider $provider;

    #[ORM\Column(length: 15)]
    private ?string $phoneNumber = null;

    #[ORM\Column(options: [
        'default' => false,
    ])]
    private ?bool $isSent = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $sendingTime;

    public function __clone()
    {
        if ($this->id) {
            $this->setId(null);
            $this->customer = clone $this->customer;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getProvider(): Provider
    {
        return $this->provider;
    }

    public function setProvider(Provider $provider): void
    {
        $this->provider = $provider;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function isIsSent(): ?bool
    {
        return $this->isSent;
    }

    public function setIsSent(bool $isSent): static
    {
        $this->isSent = $isSent;

        return $this;
    }

    public function setSendingTime(): void
    {
        $this->sendingTime = new \DateTime('now');
    }
}
