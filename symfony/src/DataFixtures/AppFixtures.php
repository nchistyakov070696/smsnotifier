<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $customer = new Customer();
            $customer->setAccessToken('some_hashed_token_'.$i);
            $customer->setName('Customer_'.$i);
            $manager->persist($customer);
        }

        for ($i = 0; $i < 3; ++$i) {
            $provider = new Provider();
            $provider->setName('Provider_'.$i);
            $provider->setRate(($i + 2) / 10);
            $provider->setUrl('http://provider-'.$i.'-host.test/send-sms');
            $manager->persist($provider);
        }

        $manager->flush();
    }
}
