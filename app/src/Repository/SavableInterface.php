<?php

declare(strict_types=1);

namespace App\Repository;

interface SavableInterface
{
    /**
     * @param $entity
     */
    public function save($entity): void;

    /**
     * @param array $entities
     */
    public function saveMultiple(array $entities): void;
}
