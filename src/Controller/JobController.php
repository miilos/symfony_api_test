<?php

namespace App\Controller;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Service\Filter;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JobController extends AbstractController
{
    public function __construct(
        private JobRepository $jobRepository
    ) {}

    #[Route('/api/jobs', name: 'get_all_jobs', methods: ['GET'])]
    public function getAll(Request $request, SerializerInterface $serializer): Response
    {
        $jobs = $this->jobRepository->findAllJobs();

        return $this->json([
            'status' => 'success',
            'results' => count($jobs),
            'data' => [
                'jobs' => $jobs
            ]
        ]);
    }

    #[Route('/api/jobs/{slug}', name: 'get_job', methods: ['GET'])]
    public function getOne(string $slug): Response
    {
        $job = $this->jobRepository->findJobBySlug($slug);

        return $this->json([
            'status' => 'success',
            'data' => [
                'job' => $job
            ]
        ]);
    }

    #[Route('/api/jobs/filter', name: 'filter_jobs', methods: ['POST'])]
    public function filterJobs(ValidatorInterface $validator, Request $request): Response
    {
        $reqFilters = $request->toArray();
        $filters = [];
        foreach ($reqFilters as $field => $value) {
            $filter = null;

            if (is_array($value)) {
                $filter = new Filter($field, $value['value'], $value['operator']);
            }
            else {
                $filter = new Filter($field, $value, '=');
            }

            $errors = $validator->validate($filter);
            if (count($errors) > 0) {
                return $this->json([
                    'status' => 'error',
                    'message' => 'filter error',
                    'errors' => $errors
                ], 400);
            }

            $filters[] = $filter;
        }

        $jobs = $this->jobRepository->filterJobs($filters);

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

//    private function getSerializeContext(): array
//    {
//        return [
//          AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, ?string $format, array $context): string {
//            if (!$object instanceof Job) {
//                throw new CircularReferenceException('A circular reference has been detected when serializing the object of class "'.get_debug_type($object));
//            }
//
//            return $object->getName();
//          }
//        ];
//    }
}