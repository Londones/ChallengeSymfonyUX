<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230213155602.php
final class Version20230213155602 extends AbstractMigration
========
final class Version20230215152536 extends AbstractMigration
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE channel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE items_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matches_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
<<<<<<<< HEAD:migrations/Version20230213155602.php
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE swipe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
========
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE swipe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE channel (id INT NOT NULL, first_user_id INT NOT NULL, second_user_id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2F98E47B4E2BF69 ON channel (first_user_id)');
        $this->addSql('CREATE INDEX IDX_A2F98E47B02C53F8 ON channel (second_user_id)');
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
        $this->addSql('CREATE TABLE items (id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_verified BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E11EE94D7E3C61F9 ON items (owner_id)');
        $this->addSql('CREATE TABLE items_category (items_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(items_id, category_id))');
        $this->addSql('CREATE INDEX IDX_7137A90F6BB0AE84 ON items_category (items_id)');
        $this->addSql('CREATE INDEX IDX_7137A90F12469DE2 ON items_category (category_id)');
        $this->addSql('CREATE TABLE matches (id INT NOT NULL, first_user_id_id INT NOT NULL, second_user_id_id INT NOT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62615BAC1E0408 ON matches (first_user_id_id)');
        $this->addSql('CREATE INDEX IDX_62615BA7ED8859C ON matches (second_user_id_id)');
<<<<<<<< HEAD:migrations/Version20230213155602.php
========
        $this->addSql('CREATE TABLE message (id INT NOT NULL, sender_id INT NOT NULL, channel_id INT NOT NULL, content TEXT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F72F5A1AA ON message (channel_id)');
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE swipe (id INT NOT NULL, swipper_id_id INT DEFAULT NULL, swipped_id_id INT DEFAULT NULL, is_swipe_right BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB59E9A9D2A96CF6 ON swipe (swipper_id_id)');
        $this->addSql('CREATE INDEX IDX_DB59E9A9D6A7C502 ON swipe (swipped_id_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, is_email_verified BOOLEAN NOT NULL, profil_picture_path VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE user_category (user_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(user_id, category_id))');
        $this->addSql('CREATE INDEX IDX_E6C1FDC1A76ED395 ON user_category (user_id)');
        $this->addSql('CREATE INDEX IDX_E6C1FDC112469DE2 ON user_category (category_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
<<<<<<<< HEAD:migrations/Version20230213155602.php
========
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47B4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47B02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_category ADD CONSTRAINT FK_7137A90F6BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items_category ADD CONSTRAINT FK_7137A90F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAC1E0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA7ED8859C FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
<<<<<<<< HEAD:migrations/Version20230213155602.php
========
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A9D2A96CF6 FOREIGN KEY (swipper_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A9D6A7C502 FOREIGN KEY (swipped_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC1A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_category ADD CONSTRAINT FK_E6C1FDC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE channel_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE items_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matches_id_seq CASCADE');
<<<<<<<< HEAD:migrations/Version20230213155602.php
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE swipe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
========
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE swipe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47B4E2BF69');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47B02C53F8');
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
        $this->addSql('ALTER TABLE items DROP CONSTRAINT FK_E11EE94D7E3C61F9');
        $this->addSql('ALTER TABLE items_category DROP CONSTRAINT FK_7137A90F6BB0AE84');
        $this->addSql('ALTER TABLE items_category DROP CONSTRAINT FK_7137A90F12469DE2');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BAC1E0408');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BA7ED8859C');
<<<<<<<< HEAD:migrations/Version20230213155602.php
========
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F72F5A1AA');
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A9D2A96CF6');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A9D6A7C502');
        $this->addSql('ALTER TABLE user_category DROP CONSTRAINT FK_E6C1FDC1A76ED395');
        $this->addSql('ALTER TABLE user_category DROP CONSTRAINT FK_E6C1FDC112469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE items_category');
        $this->addSql('DROP TABLE matches');
<<<<<<<< HEAD:migrations/Version20230213155602.php
========
        $this->addSql('DROP TABLE message');
>>>>>>>> 9e4b258c25fb27ecec39efe6f27d4c2192f137ff:migrations/Version20230215152536.php
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE swipe');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_category');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
