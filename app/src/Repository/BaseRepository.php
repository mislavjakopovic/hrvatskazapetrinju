<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\Mapping\MappingException;

abstract class BaseRepository extends ServiceEntityRepository implements SavableInterface, UpdatableInterface, DeletableInterface
{
    /**
     * @param $entity
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($entity): void
    {
        $this->saveMultiple([$entity]);
    }

    /**
     * @param array $entities
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveMultiple(array $entities): void
    {
        foreach ($entities as $entity) {
            if (!$entity->getId()) {
                $this->getEntityManager()->persist($entity);
            }
        }
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }

    /**
     * @param $entity
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update($entity): void
    {
        $this->updateMultiple([$entity]);
    }

    /**
     * @param array $entities
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateMultiple(array $entities): void
    {
        foreach ($entities as $entity) {
            if ($entity->getId()) {
                $this->getEntityManager()->merge($entity);
            }
        }
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }

    /**
     * @param $entity
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete($entity): void
    {
        $this->deleteMultiple([$entity]);
    }

    /**
     * @param array $entities
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteMultiple(array $entities): void
    {
        foreach ($entities as $entity) {
            if ($entity->getId()) {
                $this->getEntityManager()->remove($entity);
            }
        }
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }
}
