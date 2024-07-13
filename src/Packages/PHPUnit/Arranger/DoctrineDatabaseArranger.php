<?php

declare(strict_types=1);

namespace BetaReaders\Packages\PHPUnit\Arranger;

use Doctrine\ORM\EntityManagerInterface;

use function Lambdish\Phunctional\first;
use function Lambdish\Phunctional\map;

final class DoctrineDatabaseArranger implements Arranger
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly array $ignoreTables
    ) {
    }

    public function arrange(): void
    {
        $this->clean();
    }

    private function clean(): void
    {
        try {
            $connection = $this->entityManager->getConnection();
            $tables = $connection->executeQuery('SHOW TABLES')->fetchAllAssociative();
            $truncateTables = map($this->truncateTableSql(), $tables);
            $truncateTablesSql = sprintf(
                'SET FOREIGN_KEY_CHECKS = 0; %s SET FOREIGN_KEY_CHECKS = 1;',
                implode(' ', array_filter($truncateTables))
            );
            $connection->executeQuery($truncateTablesSql);
        } catch (\Exception) {
        }
    }

    private function truncateTableSql(): callable
    {
        return function (array $table): ?string {
            if (!in_array($tableName = first($table), $this->ignoreTables)) {
                return sprintf('TRUNCATE TABLE `%s`;', $tableName);
            }

            return null;
        };
    }
}
