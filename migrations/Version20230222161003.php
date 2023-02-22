<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222161003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE favorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE favorite (id INT NOT NULL, fav_sender_id INT NOT NULL, fav_receiver_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68C58ED95C308120 ON favorite (fav_sender_id)');
        $this->addSql('CREATE INDEX IDX_68C58ED954EFC6D7 ON favorite (fav_receiver_id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED95C308120 FOREIGN KEY (fav_sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED954EFC6D7 FOREIGN KEY (fav_receiver_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE favorite_id_seq CASCADE');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED95C308120');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED954EFC6D7');
        $this->addSql('DROP TABLE favorite');
    }
}
