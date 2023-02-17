<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217215638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE deal_id_seq CASCADE');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT fk_e3fec116b4e2bf69');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT fk_e3fec116b02c53f8');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT fk_e3fec1163f961ac5');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT fk_e3fec116b00494ab');
        $this->addSql('DROP TABLE deal');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE deal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE deal (id INT NOT NULL, first_user_id INT NOT NULL, second_user_id INT NOT NULL, first_user_item_id INT NOT NULL, second_user_item_id INT NOT NULL, status BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_e3fec116b00494ab ON deal (second_user_item_id)');
        $this->addSql('CREATE INDEX idx_e3fec1163f961ac5 ON deal (first_user_item_id)');
        $this->addSql('CREATE INDEX idx_e3fec116b02c53f8 ON deal (second_user_id)');
        $this->addSql('CREATE INDEX idx_e3fec116b4e2bf69 ON deal (first_user_id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT fk_e3fec116b4e2bf69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT fk_e3fec116b02c53f8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT fk_e3fec1163f961ac5 FOREIGN KEY (first_user_item_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT fk_e3fec116b00494ab FOREIGN KEY (second_user_item_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
