<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230209223250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT fk_a2f98e47c1e0408');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT fk_a2f98e477ed8859c');
        $this->addSql('DROP INDEX idx_a2f98e477ed8859c');
        $this->addSql('DROP INDEX idx_a2f98e47c1e0408');
        $this->addSql('ALTER TABLE channel ADD first_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE channel ADD second_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE channel DROP first_user_id_id');
        $this->addSql('ALTER TABLE channel DROP second_user_id_id');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47B4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47B02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A2F98E47B4E2BF69 ON channel (first_user_id)');
        $this->addSql('CREATE INDEX IDX_A2F98E47B02C53F8 ON channel (second_user_id)');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT fk_9fcad510c1e0408');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT fk_9fcad5107ed8859c');
        $this->addSql('DROP INDEX idx_9fcad5107ed8859c');
        $this->addSql('DROP INDEX idx_9fcad510c1e0408');
        $this->addSql('ALTER TABLE matche ADD first_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE matche ADD second_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE matche DROP first_user_id_id');
        $this->addSql('ALTER TABLE matche DROP second_user_id_id');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD510B4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT FK_9FCAD510B02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9FCAD510B4E2BF69 ON matche (first_user_id)');
        $this->addSql('CREATE INDEX IDX_9FCAD510B02C53F8 ON matche (second_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47B4E2BF69');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47B02C53F8');
        $this->addSql('DROP INDEX IDX_A2F98E47B4E2BF69');
        $this->addSql('DROP INDEX IDX_A2F98E47B02C53F8');
        $this->addSql('ALTER TABLE channel ADD first_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE channel ADD second_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE channel DROP first_user_id');
        $this->addSql('ALTER TABLE channel DROP second_user_id');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT fk_a2f98e47c1e0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT fk_a2f98e477ed8859c FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a2f98e477ed8859c ON channel (second_user_id_id)');
        $this->addSql('CREATE INDEX idx_a2f98e47c1e0408 ON channel (first_user_id_id)');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD510B4E2BF69');
        $this->addSql('ALTER TABLE matche DROP CONSTRAINT FK_9FCAD510B02C53F8');
        $this->addSql('DROP INDEX IDX_9FCAD510B4E2BF69');
        $this->addSql('DROP INDEX IDX_9FCAD510B02C53F8');
        $this->addSql('ALTER TABLE matche ADD first_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE matche ADD second_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE matche DROP first_user_id');
        $this->addSql('ALTER TABLE matche DROP second_user_id');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT fk_9fcad510c1e0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matche ADD CONSTRAINT fk_9fcad5107ed8859c FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9fcad5107ed8859c ON matche (second_user_id_id)');
        $this->addSql('CREATE INDEX idx_9fcad510c1e0408 ON matche (first_user_id_id)');
    }
}
