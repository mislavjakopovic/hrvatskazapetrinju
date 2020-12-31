<?php

declare(strict_types=1);

namespace App\Repository;

interface DeletableInterface
{
    /**
     * @param $entity
     */
    public function delete($entity): void;

    /**
     * @param array $entities
     */
    public function deleteMultiple(array $entities): void;
}
