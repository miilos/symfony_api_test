<?php

namespace App\Repository;

use App\DTOs\JobDTO;
use App\Entity\Job;
use App\Entity\ShiftsEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $em
    )
    {
        parent::__construct($registry, Job::class);
    }

    public function toDTOArray(array $jobs): array
    {
        $dtos = [];
        foreach ($jobs as $job) {
            $dtos[] = new JobDTO($job, $job->getEmployer());
        }
        return $dtos;
    }

    /**
     * @return JobDTO[]
     */
    public function findAllJobs(): array
    {
        $jobs = $this->createQueryBuilder('j')
            ->leftJoin('j.employer', 'e')
            ->addSelect('e')
            ->addOrderBy('j.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->toDTOArray($jobs);
    }

    public function findJobBySlug(string $slug): ?JobDTO
    {
        $job = $this->createQueryBuilder('j')
            ->leftJoin('j.employer', 'e')
            ->addSelect('e')
            ->where('j.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();

        return new JobDTO($job, $job->getEmployer());
    }

    public function findByField(string $field): Pagerfanta
    {
        $jobs = $this->createQueryBuilder('j')
            ->leftJoin('j.employer', 'e')
            ->addSelect('e')
            ->where('j.field = :field')
            ->setParameter('field', $field)
            ->addOrderBy('j.createdAt', 'ASC')
            ->getQuery()
            ->getResult();

        return new Pagerfanta(new ArrayAdapter($this->toDTOArray($jobs)));
    }

    /**
     * @return JobDTO[]
     */
    public function filterJobs(array $filters): array
    {
        $query = $this->createQueryBuilder('j');

        foreach ($filters as $filter) {
            $query->andWhere('j.' . $filter->getProperty() . ' ' . $filter->getOperator() . ' :' . $filter->getProperty())
                ->setParameter($filter->getProperty(), $filter->getValue());
        }

        $jobs = $query->getQuery()
            ->getResult();

        return $this->toDTOArray($jobs);
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
