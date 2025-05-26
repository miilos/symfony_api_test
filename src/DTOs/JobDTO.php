<?php

namespace App\DTOs;

use App\Entity\Employer;
use App\Entity\Job;

class JobDTO
{
    private int $id;
    private string $name;
    private string $description;
    private string $location;
    private string $field;
    private bool $workFromHome;
    private bool $flexibleHours;
    private \DateTimeImmutable $createdAt;
    private string $slug;
    private ?EmployerDTO $employer;

    public function __construct(Job $job, Employer $employer = null)
    {
        $this->id = $job->getId();
        $this->name = $job->getName();
        $this->description = $job->getDescription();
        $this->location = $job->getLocation();
        $this->field = $job->getField();
        $this->workFromHome = $job->isWorkFromHome();
        $this->flexibleHours = $job->isFlexibleHours();
        $this->createdAt = $job->getCreatedAt();
        $this->slug = $job->getSlug();
        $this->employer = $employer ? new EmployerDTO($employer) : null;
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

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function isWorkFromHome(): bool
    {
        return $this->workFromHome;
    }

    public function isFlexibleHours(): bool
    {
        return $this->flexibleHours;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getEmployer(): ?EmployerDTO
    {
        return $this->employer;
    }
}