<?php

namespace App\Factory;

use App\Entity\Job;
use App\Entity\ShiftsEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Job>
 */
final class JobFactory extends PersistentProxyObjectFactory
{
    private const JOB_NAMES = [
      'Software engineer',
      'Back-end web developer',
      'Front-end web developer',
      'Desktop application developer',
      'Quality assurance',
      'Social media manager',
      'Social media content director',
      'Advertising director',
      'UI/UX designer',
      'PR manager',
      'HR manager',
      'Data analyst',
      'Project manager',
      'Creative director',
      'Lead designer',
      'Content writer'
    ];

    private const EMPLOYERS = [
        'Google',
        'Microsoft',
        'Mozilla',
        'Laguna',
        'Vulkan',
        'Inspira'
    ];

    private const LOCATIONS = [
      'Subotica',
      'Novi Sad',
      'Beograd',
      'Nis',
      'Kragujevac',
      'Sombor',
      'Backa Topola'
    ];

    public const FIELDS = [
        'IT',
        'Management',
        'Marketing',
        'Design',
        'HR'
    ];

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Job::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 year')),
            'description' => self::faker()->text(),
            'employer' => self::faker()->randomElement(self::EMPLOYERS),
            'field' => self::faker()->randomElement(self::FIELDS),
            'flexibleHours' => self::faker()->boolean(),
            'location' => self::faker()->randomElement(self::LOCATIONS),
            'name' => self::faker()->randomElement(self::JOB_NAMES),
            'shifts' => self::faker()->randomElement(ShiftsEnum::cases()),
            //'slug' => self::faker()->text(),
            'startSalary' => self::faker()->numberBetween(10, 20) * 10000,
            'workFromHome' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Job $job): void {})
        ;
    }
}
