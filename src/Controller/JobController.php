<?php

namespace App\Controller;

use App\Entity\Job;
use App\Repository\JobRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JobController extends AbstractController
{
    public function __construct(
        private JobRepository $jobRepository
    ) {}

    #[Route('/api/jobs', name: 'get_all_jobs', methods: ['GET'])]
    public function getAll(Request $request): Response
    {
        $jobs = $this->jobRepository->findAll();

        return $this->json([
            'status' => 'success',
            'results' => count($jobs),
            'data' => [
                'jobs' => $jobs
            ]
        ]);
    }

    #[Route('/api/jobs/{slug}', name: 'get_job', methods: ['GET'])]
    public function getOne(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Job $job,
    ): Response
    {
        return $this->json([
            'status' => 'success',
            'data' => [
                'job' => $job
            ]
        ]);
    }

    #[Route('/api/jobs/filter', name: 'filter_jobs', methods: ['POST'])]
    public function filterJobs(Request $request): Response
    {
        $jobs = $this->jobRepository->filterJobs($request->toArray());

        return $this->json([
            'status' => 'success',
            'results' => count($jobs),
            'data' => [
                'jobs' => $jobs
            ]
        ]);
    }

    #[Route('/api/jobs/field/{field}', name: 'get_jobs_by_field', methods: ['GET'])]
    public function getJobsByField(Request $request, string $field): Response
    {
        $data = $this->jobRepository->findByField($field);
        $data->setMaxPerPage(5);
        $data->setCurrentPage($request->query->get('page', 1));
        $jobs = $data->getCurrentPageResults();

        return $this->json([
            'status' => 'success',
            'results' => count($jobs),
            'data' => [
                'jobs' => $jobs
            ]
        ]);
    }

    #[Route('/api/jobs', name: 'create_job', methods: ['POST'])]
    public function createJob(Request $request): Response
    {
        $newJob = $this->jobRepository->createJob($request->toArray());

        return $this->json([
           'status' => 'success',
           'data' => [
               'job' => $newJob
           ]
        ], 201);
    }

    #[Route('/api/jobs/{id}', name: 'update_job', methods: ['PATCH'])]
    public function updateJob(Job $job, Request $request): Response
    {
        $updatedJob = $this->jobRepository->updateJob($job, $request->toArray());

        return $this->json([
            'status' => 'success',
            'data' => [
                'job' => $updatedJob
            ]
        ]);
    }

    #[Route('/api/jobs/{id}', name: 'delete_job', methods: ['DELETE'])]
    public function deleteJob(Job $job): Response
    {
        $this->jobRepository->deleteJob($job);

        return $this->json([
            'status' => 'success',
            'message' => 'job deleted!'
        ], 204);
    }
}