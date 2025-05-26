<?php

namespace App\Repository;

interface RepositoryInterface
{
    public function toDTOArray(array $entities): array;
}