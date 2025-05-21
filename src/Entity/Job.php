<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $description = null;

    #[ORM\Column]
    private ?string $employer = null;

    #[ORM\Column]
    private ?string $location = null;

    #[ORM\Column]
    private ?string $field = null;

    #[ORM\Column]
    private ?int $startSalary = null;

    #[ORM\Column(enumType: ShiftsEnum::class)]
    private ?ShiftsEnum $shifts = null;

    #[ORM\Column]
    private ?bool $workFromHome = null;

    #[ORM\Column]
    private ?bool $flexibleHours = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Slug(fields: ['name'])]
    private ?string $slug = null;

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

    public function getEmployer(): ?string
    {
        return $this->employer;
    }

    public function setEmployer(string $employer): static
    {
        $this->employer = $employer;

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
}
