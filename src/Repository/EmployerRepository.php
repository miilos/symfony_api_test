<?php

namespace App\Repository;

use App\Entity\Employer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employer>
 */
class EmployerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employer::class);
    }

    public function getEmployerJobListings(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.jobs', 'j')
            ->addSelect('j')
            ->getQuery()
            ->getResult();
    }
}
