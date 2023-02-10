<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230210000544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE matche_id_seq CASCADE');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT fk_9fcad510b4e2bf69');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT fk_9fcad510b02c53f8');
        $this->addSql('DROP TABLE matche');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE matche_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE matche (id INT NOT NULL, first_user_id INT NOT NULL, second_user_id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9fcad510b02c53f8 ON matche (second_user_id)');
        $this->addSql('CREATE INDEX idx_9fcad510b4e2bf69 ON matche (first_user_id)');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT fk_9fcad510b4e2bf69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT fk_9fcad510b02c53f8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
