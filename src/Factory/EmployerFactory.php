<?php

namespace App\Factory;

use App\Entity\Employer;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Employer>
 */
final class EmployerFactory extends PersistentProxyObjectFactory
{
    public const EMPLOYERS = [
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
        return Employer::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'basedIn' => self::faker()->randomElement(self::LOCATIONS),
            'description' => self::faker()->text(),
            'name' => self::faker()->randomElement(self::EMPLOYERS),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Employer $employer): void {})
        ;
    }
}
