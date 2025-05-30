<?php

namespace App\Repository;

use App\Entity\Job;
use App\Entity\ShiftsEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $em
    )
    {
        parent::__construct($registry, Job::class);
    }

    public function findByField(string $field): Pagerfanta
    {
        $query = $this->createQueryBuilder('j')
            ->leftJoin('j.employer', 'e')
            ->addSelect('e')
            ->where('j.field = :field')
            ->setParameter('field', $field)
            ->addOrderBy('j.createdAt', 'ASC')
            ->getQuery();

        return new Pagerfanta(new QueryAdapter($query));
    }

    /**
     * @return Job[]
     */
    public function filterJobs(array $filters): array
    {
        $query = $this->createQueryBuilder('j');

        foreach ($filters as $filter) {
            $query->andWhere('j.' . $filter->getProperty() . ' ' . $filter->getOperator() . ' :' . $filter->getProperty())
                ->setParameter($filter->getProperty(), $filter->getValue());
        }

        return $query->getQuery()
            ->getResult();
    }

    public function createJob(array $jobData): Job
    {
        $newJob = new Job();
        $newJob->setName($jobData['name']);
        $newJob->setDescription($jobData['description']);
        $newJob->setEmployer($jobData['employer']);
        $newJob->setLocation($jobData['location']);
        $newJob->setField($jobData['field']);;
        $newJob->setStartSalary($jobData['startSalary']);
        $newJob->setShifts(ShiftsEnum::from($jobData['shifts']));
        $newJob->setWorkFromHome($jobData['workFromHome']);
        $newJob->setFlexibleHours($jobData['flexibleHours']);
        $newJob->setCreatedAt(new \DateTimeImmutable('now'));

        $this->em->persist($newJob);
        $this->em->flush();

        return $newJob;
    }

    public function updateJob(Job $job, array $newData): Job
    {
        foreach ($newData as $field => $value) {
            $setter = 'set' . ucfirst($field);
            $job->$setter($value);
        }

        $this->em->flush();
        return $job;
    }

    public function deleteJob(Job $job): void
    {
        $this->em->remove($job);
        $this->em->flush();
    }
}
