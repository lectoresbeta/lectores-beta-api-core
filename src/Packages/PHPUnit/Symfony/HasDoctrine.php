<?php

declare(strict_types=1);

namespace BetaReaders\Packages\PHPUnit\Symfony;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

trait HasDoctrine
{
    /**
     * @param class-string<object> $entityClass
     * @return ObjectRepository
     */
    protected function repositoryFor(string $entityClass): ObjectRepository
    {
        return $this->entityManager()->getRepository($entityClass);
    }

    protected function entityManager(): EntityManagerInterface
    {
        /** @var EntityManagerInterface $em */
        $em = $this->container()->get(EntityManagerInterface::class);

        return $em;
    }

    protected function persist(mixed ...$aggregatesOrEntities): void
    {
        $em = $this->entityManager();

        foreach ($aggregatesOrEntities as $aggregateOrEntity) {
            $em->persist($aggregateOrEntity);
            $em->flush();
        }
    }
}
