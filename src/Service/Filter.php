<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints as Assert;

class Filter
{
    #[Assert\Choice(
        choices: ['name', 'employer', 'startSalary'],
        message: 'invalid property name on filter',
    )]
    private string $property;

    #[Assert\NotBlank]
    private mixed $value;

    #[Assert\Choice(
        choices: ['=', '>', '>=', '<', '<=', '<>'],
        message: 'invalid operator on filter',
    )]
    private string $operator;

    public function __construct(string $property, mixed $value, string $operator)
    {
        $this->property = $property;
        $this->value = $value;
        $this->operator = $operator;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}