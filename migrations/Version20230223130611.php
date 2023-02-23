<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223130611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE deal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE deal (id INT NOT NULL, first_user_id INT DEFAULT NULL, second_user_id INT DEFAULT NULL, first_user_object_id INT DEFAULT NULL, second_user_object_id INT DEFAULT NULL, status VARCHAR(50) DEFAULT NULL, first_user_response BOOLEAN DEFAULT NULL, seconde_user_response BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E3FEC116B4E2BF69 ON deal (first_user_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC116B02C53F8 ON deal (second_user_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC116C99FE1A1 ON deal (first_user_object_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC11638E1863D ON deal (second_user_object_id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116B4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116B02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116C99FE1A1 FOREIGN KEY (first_user_object_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC11638E1863D FOREIGN KEY (second_user_object_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE deal_id_seq CASCADE');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116B4E2BF69');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116B02C53F8');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116C99FE1A1');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC11638E1863D');
        $this->addSql('DROP TABLE deal');
    }
}
