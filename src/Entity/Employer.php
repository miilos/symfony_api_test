<?php

namespace App\Entity;

use App\Repository\EmployerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: EmployerRepository::class)]
class Employer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'job_details',
        'employer_details',
        'employer_job_listings'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'job_details',
        'employer_details',
        'employer_job_listings'
    ])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups([
        'job_details',
        'employer_details',
        'employer_job_listings'
    ])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups([
        'job_details',
        'employer_details',
        'employer_job_listings'
    ])]
    private ?string $basedIn = null;

    /**
     * @var Collection<int, Job>
     */
    #[ORM\OneToMany(targetEntity: Job::class, mappedBy: 'employer')]
    #[Groups([
        'employer_job_listings'
    ])]
    private Collection $jobs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

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

    public function getBasedIn(): ?string
    {
        return $this->basedIn;
    }

    public function setBasedIn(string $basedIn): static
    {
        $this->basedIn = $basedIn;

        return $this;
    }

    /**
     * @return Collection<int, Job>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): static
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
            $job->setEmployer($this);
        }

        return $this;
    }

    public function removeJob(Job $job): static
    {
        if ($this->jobs->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getEmployer() === $this) {
                $job->setEmployer(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
