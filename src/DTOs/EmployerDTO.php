<?php

namespace App\DTOs;

use App\Entity\Employer;

class EmployerDTO
{
    private int $id;
    private string $name;
    private string $description;
    private string $basedIn;
    private ?array $jobs;

    public function __construct(Employer $employer, array $jobs = null)
    {
        $this->id = $employer->getId();
        $this->name = $employer->getName();
        $this->description = $employer->getDescription();
        $this->basedIn = $employer->getBasedIn();
        $this->jobs = $jobs;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBasedIn(): string
    {
        return $this->basedIn;
    }

    public function getJobs(): ?array
    {
        return $this->jobs;
    }
}