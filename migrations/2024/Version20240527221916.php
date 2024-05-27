<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240527221916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE user (
                id VARCHAR(26) NOT NULL COMMENT \'(DC2Type:ulid_type)\',
                email VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                roles JSON NOT NULL COMMENT \'(DC2Type:json)\', 
                PRIMARY KEY(`id`),
                UNIQUE user_email_uniq_idx (`email`),
                UNIQUE user_username_uniq_idx (`username`)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `user`');
    }
}
