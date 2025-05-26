<?php

namespace App\Controller;

use App\Repository\EmployerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class EmployerController extends AbstractController
{
    public function __construct(
        private EmployerRepository $employerRepository,
    ) {}

    #[Route('/api/employers', name: 'get_all_employers', methods: ['GET'])]
    public function getAllEmployers(): Response
    {
        $employers = $this->employerRepository->findAll();

        return $this->json([
            'status' => 'success',
            'results' => count($employers),
            'data' => [
                'employers' => $employers,
            ]
        ], context: ['groups' => 'employer_details']);
    }

    #[Route('/api/employers/listings', name: 'get_employer_jobs', methods: ['GET'])]
    public function getEmployerJobListings(): Response
    {
        $employers = $this->employerRepository->getEmployerJobListings();

        return $this->json([
            'status' => 'success',
            'data' => [
                'employers' => $employers,
            ]
        ], context: ['groups' => 'employer_job_listings']);
    }
}