<?php

declare(strict_types=1);

namespace BetaReaders\Shared\Infrastructure\Doctrine;

use BetaReaders\Shared\Domain\Type\Collection\Collection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\QueryBuilder;

use function Lambdish\Phunctional\each;

abstract class Repository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly bool $flushOnSave = true
    ) {
    }

    /**
     * @return class-string<object>
     */
    abstract public function entityClass(): string;

    abstract public function queryBuilder(): QueryBuilder;

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws UniqueConstraintViolationException
     */
    protected function persist(mixed $object): void
    {
        $this->entityManager->persist($object);

        if ($this->flushOnSave) {
            $this->entityManager->flush();
        }
    }

    protected function persistMultiple(Collection $collection): void
    {
        each(
            function (mixed $entity) {
                $this->persist($entity);
            },
            $collection->items()
        );

        $this->entityManager->flush();
    }

    protected function repository(): EntityRepository
    {
        return $this->entityManager->getRepository($this->entityClass());
    }
}
