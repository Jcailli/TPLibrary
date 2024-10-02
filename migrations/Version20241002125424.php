<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002125424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX author ON author');
        $this->addSql('ALTER TABLE borrowing DROP INDEX UNIQ_226E5897D4116DB6, ADD INDEX IDX_226E5897D4116DB6 (book_version_id)');
        $this->addSql('ALTER TABLE borrowing CHANGE book_version_id book_version_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP INDEX UNIQ_42C84955D4116DB6, ADD INDEX IDX_42C84955D4116DB6 (book_version_id)');
        $this->addSql('ALTER TABLE reservation CHANGE book_version_id book_version_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX author ON author (first_name, name)');
        $this->addSql('ALTER TABLE reservation DROP INDEX IDX_42C84955D4116DB6, ADD UNIQUE INDEX UNIQ_42C84955D4116DB6 (book_version_id)');
        $this->addSql('ALTER TABLE reservation CHANGE book_version_id book_version_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE borrowing DROP INDEX IDX_226E5897D4116DB6, ADD UNIQUE INDEX UNIQ_226E5897D4116DB6 (book_version_id)');
        $this->addSql('ALTER TABLE borrowing CHANGE book_version_id book_version_id INT DEFAULT NULL');
    }
}
