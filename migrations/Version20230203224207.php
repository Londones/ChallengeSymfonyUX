<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203224207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE items_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matches_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE swipe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE items (id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_verified BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E11EE94D7E3C61F9 ON items (owner_id)');
        $this->addSql('CREATE TABLE items_category (items_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(items_id, category_id))');
        $this->addSql('CREATE INDEX IDX_7137A90F6BB0AE84 ON items_category (items_id)');
        $this->addSql('CREATE INDEX IDX_7137A90F12469DE2 ON items_category (category_id)');
        $this->addSql('CREATE TABLE matches (id INT NOT NULL, first_user_id_id INT NOT NULL, second_user_id_id INT NOT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62615BAC1E0408 ON matches (first_user_id_id)');
        $this->addSql('CREATE INDEX IDX_62615BA7ED8859C ON matches (second_user_id_id)');
        $this->addSql('CREATE TABLE swipe (id INT NOT NULL, swipper_id_id INT DEFAULT NULL, swipped_id_id INT DEFAULT NULL, is_swipe_right BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB59E9A9D2A96CF6 ON swipe (swipper_id_id)');
        $this->addSql('CREATE INDEX IDX_DB59E9A9D6A7C502 ON swipe (swipped_id_id)');
        $this->addSql('CREATE TABLE user_category (user_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(user_id, category_id))');
        $this->addSql('CREATE INDEX IDX_E6C1FDC1A76ED395 ON user_category (user_id)');
        $this->addSql('CREATE INDEX IDX_E6C1FDC112469DE2 ON user_category (category_id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_category ADD CONSTRAINT FK_7137A90F6BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_category ADD CONSTRAINT FK_7137A90F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAC1E0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA7ED8859C FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A9D2A96CF6 FOREIGN KEY (swipper_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A9D6A7C502 FOREIGN KEY (swipped_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC1A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE items_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matches_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE swipe_id_seq CASCADE');
        $this->addSql('ALTER TABLE items DROP CONSTRAINT FK_E11EE94D7E3C61F9');
        $this->addSql('ALTER TABLE items_category DROP CONSTRAINT FK_7137A90F6BB0AE84');
        $this->addSql('ALTER TABLE items_category DROP CONSTRAINT FK_7137A90F12469DE2');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BAC1E0408');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BA7ED8859C');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A9D2A96CF6');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A9D6A7C502');
        $this->addSql('ALTER TABLE user_category DROP CONSTRAINT FK_E6C1FDC1A76ED395');
        $this->addSql('ALTER TABLE user_category DROP CONSTRAINT FK_E6C1FDC112469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE items_category');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE swipe');
        $this->addSql('DROP TABLE user_category');
    }
}
