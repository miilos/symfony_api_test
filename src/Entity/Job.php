<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?string $location = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?string $field = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?int $startSalary = null;

    #[ORM\Column(enumType: ShiftsEnum::class)]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?ShiftsEnum $shifts = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?bool $workFromHome = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?bool $flexibleHours = null;

    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_job_listings',
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Slug(fields: ['name'])]
    #[Groups([
        'job_details',
        'employer_job_listings'
    ])]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['job_details'])]
    private ?Employer $employer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
    
    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function getStartSalary(): ?int
    {
        return $this->startSalary;
    }

    public function setStartSalary(int $startSalary): static
    {
        $this->startSalary = $startSalary;

        return $this;
    }

    public function getShifts(): ?ShiftsEnum
    {
        return $this->shifts;
    }

    public function setShifts(ShiftsEnum $shifts): static
    {
        $this->shifts = $shifts;

        return $this;
    }

    public function isWorkFromHome(): ?bool
    {
        return $this->workFromHome;
    }

    public function setWorkFromHome(bool $workFromHome): static
    {
        $this->workFromHome = $workFromHome;

        return $this;
    }

    public function isFlexibleHours(): ?bool
    {
        return $this->flexibleHours;
    }

    public function setFlexibleHours(bool $flexibleHours): static
    {
        $this->flexibleHours = $flexibleHours;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getEmployer(): ?Employer
    {
        return $this->employer;
    }

    public function setEmployer(?Employer $employer): static
    {
        $this->employer = $employer;

        return $this;
    }
}
