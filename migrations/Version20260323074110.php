<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260323074110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create software_version table with fields for firmware management';
    }

    public function up(Schema $schema): void
    {
        // Create software_version table
        $this->addSql('CREATE TABLE software_version (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            system_version VARCHAR(255) NOT NULL,
            system_version_alt VARCHAR(255) NOT NULL,
            link TEXT DEFAULT NULL,
            st TEXT DEFAULT NULL,
            gd TEXT DEFAULT NULL,
            latest TINYINT(1) NOT NULL,
            is_lci TINYINT(1) NOT NULL,
            lci_type VARCHAR(10) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');

        // Keep messenger_messages table if needed by Symfony Messenger
        $this->addSql('CREATE TABLE messenger_messages (
            id BIGINT AUTO_INCREMENT NOT NULL,
            body LONGTEXT NOT NULL,
            headers LONGTEXT NOT NULL,
            queue_name VARCHAR(190) NOT NULL,
            created_at DATETIME NOT NULL,
            available_at DATETIME NOT NULL,
            delivered_at DATETIME DEFAULT NULL,
            INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE software_version');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
