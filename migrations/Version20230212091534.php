<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230212091534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE items_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matches_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE swipe_id_seq CASCADE');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items DROP CONSTRAINT fk_e11ee94d7e3c61f9');
        $this->addSql('ALTER TABLE user_category DROP CONSTRAINT fk_e6c1fdc1a76ed395');
        $this->addSql('ALTER TABLE user_category DROP CONSTRAINT fk_e6c1fdc112469de2');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT fk_db59e9a9d2a96cf6');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT fk_db59e9a9d6a7c502');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT fk_62615bac1e0408');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT fk_62615ba7ed8859c');
        $this->addSql('ALTER TABLE items_category DROP CONSTRAINT fk_7137a90f6bb0ae84');
        $this->addSql('ALTER TABLE items_category DROP CONSTRAINT fk_7137a90f12469de2');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE user_category');
        $this->addSql('DROP TABLE swipe');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE items_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE items_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matches_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE swipe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE items (id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_verified BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_e11ee94d7e3c61f9 ON items (owner_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_category (user_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(user_id, category_id))');
        $this->addSql('CREATE INDEX idx_e6c1fdc112469de2 ON user_category (category_id)');
        $this->addSql('CREATE INDEX idx_e6c1fdc1a76ed395 ON user_category (user_id)');
        $this->addSql('CREATE TABLE swipe (id INT NOT NULL, swipper_id_id INT DEFAULT NULL, swipped_id_id INT DEFAULT NULL, is_swipe_right BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_db59e9a9d6a7c502 ON swipe (swipped_id_id)');
        $this->addSql('CREATE INDEX idx_db59e9a9d2a96cf6 ON swipe (swipper_id_id)');
        $this->addSql('CREATE TABLE matches (id INT NOT NULL, first_user_id_id INT NOT NULL, second_user_id_id INT NOT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_62615ba7ed8859c ON matches (second_user_id_id)');
        $this->addSql('CREATE INDEX idx_62615bac1e0408 ON matches (first_user_id_id)');
        $this->addSql('CREATE TABLE items_category (items_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(items_id, category_id))');
        $this->addSql('CREATE INDEX idx_7137a90f12469de2 ON items_category (category_id)');
        $this->addSql('CREATE INDEX idx_7137a90f6bb0ae84 ON items_category (items_id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT fk_e11ee94d7e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT fk_e6c1fdc1a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT fk_e6c1fdc112469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT fk_db59e9a9d2a96cf6 FOREIGN KEY (swipper_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT fk_db59e9a9d6a7c502 FOREIGN KEY (swipped_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT fk_62615bac1e0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT fk_62615ba7ed8859c FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_category ADD CONSTRAINT fk_7137a90f6bb0ae84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_category ADD CONSTRAINT fk_7137a90f12469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE reset_password_request');
    }
}
