<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219221216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE object_files DROP CONSTRAINT fk_821614bb55e38587');
        $this->addSql('DROP INDEX idx_821614bb55e38587');
        $this->addSql('ALTER TABLE object_files RENAME COLUMN item_id_id TO item_id');
        $this->addSql('ALTER TABLE object_files RENAME COLUMN file TO image');
        $this->addSql('ALTER TABLE object_files ADD CONSTRAINT FK_821614BB126F525E FOREIGN KEY (item_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_821614BB126F525E ON object_files (item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE object_files DROP CONSTRAINT FK_821614BB126F525E');
        $this->addSql('DROP INDEX IDX_821614BB126F525E');
        $this->addSql('ALTER TABLE object_files RENAME COLUMN item_id TO item_id_id');
        $this->addSql('ALTER TABLE object_files RENAME COLUMN image TO file');
        $this->addSql('ALTER TABLE object_files ADD CONSTRAINT fk_821614bb55e38587 FOREIGN KEY (item_id_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_821614bb55e38587 ON object_files (item_id_id)');
    }
}
