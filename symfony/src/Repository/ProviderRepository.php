<?php

namespace App\Repository;

use App\Entity\Provider;
use App\Entity\Sms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Provider>
 *
 * @method Provider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Provider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Provider[]    findAll()
 * @method Provider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProviderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Provider::class);
    }

    public function statisticsByDateRange(int $customerId, string $dateFrom, string $dateTo): array
    {
        return $this->createQueryBuilder('p')
            ->select([
                'p.name as providerName',
                'p.rate',
                'COUNT(s.id) AS totalDelivered',
                'SUM(p.rate) AS totalPrice',
            ])
            ->leftJoin(Sms::class, 's', Join::WITH, 'p.id = s.provider')
            ->andWhere('s.isSent = true')
            ->andWhere('s.customer = :customer')
            ->andWhere('s.sendingTime BETWEEN :date_from AND :date_to')
            ->setParameters([
                'customer' => $customerId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ])
            ->groupBy('p.name')
            ->addGroupBy('p.rate')
            ->getQuery()
            ->getResult();
    }
}
