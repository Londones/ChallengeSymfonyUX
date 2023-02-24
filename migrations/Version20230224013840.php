<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224013840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE deal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE favorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE deal (id INT NOT NULL, first_user_id INT DEFAULT NULL, second_user_id INT DEFAULT NULL, first_user_object_id INT DEFAULT NULL, second_user_object_id INT DEFAULT NULL, status VARCHAR(50) DEFAULT NULL, first_user_response BOOLEAN DEFAULT NULL, seconde_user_response BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E3FEC116B4E2BF69 ON deal (first_user_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC116B02C53F8 ON deal (second_user_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC116C99FE1A1 ON deal (first_user_object_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC11638E1863D ON deal (second_user_object_id)');
        $this->addSql('CREATE TABLE favorite (id INT NOT NULL, fav_sender_id INT NOT NULL, fav_receiver_id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68C58ED95C308120 ON favorite (fav_sender_id)');
        $this->addSql('CREATE INDEX IDX_68C58ED954EFC6D7 ON favorite (fav_receiver_id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116B4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116B02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116C99FE1A1 FOREIGN KEY (first_user_object_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC11638E1863D FOREIGN KEY (second_user_object_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED95C308120 FOREIGN KEY (fav_sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED954EFC6D7 FOREIGN KEY (fav_receiver_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47B4E2BF69');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47B02C53F8');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47B4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47B02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE items DROP CONSTRAINT FK_E11EE94D7E3C61F9');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BAB4E2BF69');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BAB02C53F8');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAB4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAB02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F72F5A1AA');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A94B3C1283');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A93E4E1AC0');
        $this->addSql('ALTER TABLE swipe ALTER swipper_id SET NOT NULL');
        $this->addSql('ALTER TABLE swipe ALTER swipped_id SET NOT NULL');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A94B3C1283 FOREIGN KEY (swipper_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A93E4E1AC0 FOREIGN KEY (swipped_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE deal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE favorite_id_seq CASCADE');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116B4E2BF69');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116B02C53F8');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116C99FE1A1');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC11638E1863D');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED95C308120');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED954EFC6D7');
        $this->addSql('DROP TABLE deal');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('ALTER TABLE items DROP CONSTRAINT fk_e11ee94d7e3c61f9');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT fk_e11ee94d7e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT fk_62615bab4e2bf69');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT fk_62615bab02c53f8');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT fk_62615bab4e2bf69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT fk_62615bab02c53f8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT fk_db59e9a94b3c1283');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT fk_db59e9a93e4e1ac0');
        $this->addSql('ALTER TABLE swipe ALTER swipper_id DROP NOT NULL');
        $this->addSql('ALTER TABLE swipe ALTER swipped_id DROP NOT NULL');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT fk_db59e9a94b3c1283 FOREIGN KEY (swipper_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT fk_db59e9a93e4e1ac0 FOREIGN KEY (swipped_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT fk_a2f98e47b4e2bf69');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT fk_a2f98e47b02c53f8');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT fk_a2f98e47b4e2bf69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT fk_a2f98e47b02c53f8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307ff624b39d');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307f72f5a1aa');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_b6bd307ff624b39d FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_b6bd307f72f5a1aa FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
