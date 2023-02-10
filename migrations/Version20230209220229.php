<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209220229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE channel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matche_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE channel (id INT NOT NULL, first_user_id_id INT NOT NULL, second_user_id_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2F98E47C1E0408 ON channel (first_user_id_id)');
        $this->addSql('CREATE INDEX IDX_A2F98E477ED8859C ON channel (second_user_id_id)');
        $this->addSql('CREATE TABLE matche (id INT NOT NULL, first_user_id_id INT NOT NULL, second_user_id_id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9FCAD510C1E0408 ON matche (first_user_id_id)');
        $this->addSql('CREATE INDEX IDX_9FCAD5107ED8859C ON matche (second_user_id_id)');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47C1E0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E477ED8859C FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD510C1E0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD5107ED8859C FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE channel_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matche_id_seq CASCADE');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47C1E0408');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E477ED8859C');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD510C1E0408');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD5107ED8859C');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE matche');
    }
}
