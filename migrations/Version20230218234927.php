<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218234927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE verification_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE verification_request (id INT NOT NULL, requested_by_id INT NOT NULL, item_requested_id INT NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_20FDDF4E4DA1E751 ON verification_request (requested_by_id)');
        $this->addSql('CREATE INDEX IDX_20FDDF4E576CD976 ON verification_request (item_requested_id)');
        $this->addSql('ALTER TABLE verification_request ADD CONSTRAINT FK_20FDDF4E4DA1E751 FOREIGN KEY (requested_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE verification_request ADD CONSTRAINT FK_20FDDF4E576CD976 FOREIGN KEY (item_requested_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE verification_request_id_seq CASCADE');
        $this->addSql('ALTER TABLE verification_request DROP CONSTRAINT FK_20FDDF4E4DA1E751');
        $this->addSql('ALTER TABLE verification_request DROP CONSTRAINT FK_20FDDF4E576CD976');
        $this->addSql('DROP TABLE verification_request');
    }
}
