<?php

declare(strict_types=1);

namespace App\Repository;

interface UpdatableInterface
{
    /**
     * @param $entity
     */
    public function update($entity): void;

    /**
     * @param array $entities
     */
    public function updateMultiple(array $entities): void;
}
