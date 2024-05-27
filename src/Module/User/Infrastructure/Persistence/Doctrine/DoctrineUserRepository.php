<?php

declare(strict_types=1);

namespace BetaReaders\Module\User\Infrastructure\Persistence\Doctrine;

use BetaReaders\Module\User\Domain\User;
use BetaReaders\Module\User\Domain\UserAlreadyExist;
use BetaReaders\Module\User\Domain\UserRepository;
use BetaReaders\Shared\Domain\User\Email;
use BetaReaders\Shared\Infrastructure\Doctrine\Repository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\QueryBuilder;

final class DoctrineUserRepository extends Repository implements UserRepository
{
    private const ALIAS = 'u';

    public function entityClass(): string
    {
        return User::class;
    }

    public function queryBuilder(): QueryBuilder
    {
        return $this->repository()->createQueryBuilder(self::ALIAS);
    }

    public function save(User $user): void
    {
        try {
            $this->persist($user);
        } catch (UniqueConstraintViolationException) {
            throw UserAlreadyExist::withIdAndEmail($user->id(), $user->email());
        }
    }

    public function searchByEmail(Email $email): ?User
    {
        /** @var User|null $user */
        $user = $this->queryBuilder()
            ->andWhere(self::ALIAS.'.email = :email')
            ->setParameter('email', $email->value())
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }
}
