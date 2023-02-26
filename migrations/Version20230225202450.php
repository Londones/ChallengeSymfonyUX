<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225202450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE verification_request ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE verification_request ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE verification_request ADD CONSTRAINT FK_20FDDF4EB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE verification_request ADD CONSTRAINT FK_20FDDF4E896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_20FDDF4EB03A8386 ON verification_request (created_by_id)');
        $this->addSql('CREATE INDEX IDX_20FDDF4E896DBBDE ON verification_request (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE verification_request DROP CONSTRAINT FK_20FDDF4EB03A8386');
        $this->addSql('ALTER TABLE verification_request DROP CONSTRAINT FK_20FDDF4E896DBBDE');
        $this->addSql('DROP INDEX IDX_20FDDF4EB03A8386');
        $this->addSql('DROP INDEX IDX_20FDDF4E896DBBDE');
        $this->addSql('ALTER TABLE verification_request DROP created_by_id');
        $this->addSql('ALTER TABLE verification_request DROP updated_by_id');
    }
}
