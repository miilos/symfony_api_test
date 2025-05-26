<?php

namespace App\Repository;

use App\DTOs\EmployerDTO;
use App\DTOs\JobDTO;
use App\Entity\Employer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employer>
 */
class EmployerRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employer::class);
    }

    /**
     * @return EmployerDTO[]
     */
    public function toDTOArray(array $employers): array
    {
        $dtos = [];
        foreach ($employers as $employer) {
            $dtos[] = new EmployerDTO($employer);
        }
        return $dtos;
    }

    /**
     * @return EmployerDTO[]
     */
    public function findAllEmployers(): array
    {
        $employers = $this->createQueryBuilder('e')
                ->getQuery()
                ->getResult();

        return $this->toDTOArray($employers);
    }

    public function getEmployerJobListings(): array
    {
        $employers = $this->createQueryBuilder('e')
            ->join('e.jobs', 'j')
            ->addSelect('j')
            ->getQuery()
            ->getResult();

        $listings = [];
        foreach ($employers as $employer) {
            $jobs = [];
            foreach ($employer->getJobs() as $job) {
                $jobs[] = new JobDTO($job);
            }

            $listings[] = new EmployerDTO($employer, $jobs);
        }

        return $listings;
    }
}
