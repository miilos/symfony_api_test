<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526132734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE employer ADD slug VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F841CD9E7A FOREIGN KEY (employer_id) REFERENCES employer (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FBD8E0F841CD9E7A ON job (employer_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE employer DROP slug
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F841CD9E7A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FBD8E0F841CD9E7A ON job
        SQL);
    }
}
