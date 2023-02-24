<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217172639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT fk_62615bac1e0408');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT fk_62615ba7ed8859c');
        $this->addSql('DROP INDEX idx_62615ba7ed8859c');
        $this->addSql('DROP INDEX idx_62615bac1e0408');
        $this->addSql('ALTER TABLE matches ADD first_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE matches ADD second_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE matches DROP first_user_id_id');
        $this->addSql('ALTER TABLE matches DROP second_user_id_id');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAB4E2BF69 FOREIGN KEY (first_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAB02C53F8 FOREIGN KEY (second_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_62615BAB4E2BF69 ON matches (first_user_id)');
        $this->addSql('CREATE INDEX IDX_62615BAB02C53F8 ON matches (second_user_id)');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT fk_db59e9a9d2a96cf6');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT fk_db59e9a9d6a7c502');
        $this->addSql('DROP INDEX idx_db59e9a9d6a7c502');
        $this->addSql('DROP INDEX idx_db59e9a9d2a96cf6');
        $this->addSql('ALTER TABLE swipe ADD swipper_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE swipe ADD swipped_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE swipe DROP swipper_id_id');
        $this->addSql('ALTER TABLE swipe DROP swipped_id_id');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A94B3C1283 FOREIGN KEY (swipper_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT FK_DB59E9A93E4E1AC0 FOREIGN KEY (swipped_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DB59E9A94B3C1283 ON swipe (swipper_id)');
        $this->addSql('CREATE INDEX IDX_DB59E9A93E4E1AC0 ON swipe (swipped_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BAB4E2BF69');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BAB02C53F8');
        $this->addSql('DROP INDEX IDX_62615BAB4E2BF69');
        $this->addSql('DROP INDEX IDX_62615BAB02C53F8');
        $this->addSql('ALTER TABLE matches ADD first_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE matches ADD second_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE matches DROP first_user_id');
        $this->addSql('ALTER TABLE matches DROP second_user_id');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT fk_62615bac1e0408 FOREIGN KEY (first_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT fk_62615ba7ed8859c FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_62615ba7ed8859c ON matches (second_user_id_id)');
        $this->addSql('CREATE INDEX idx_62615bac1e0408 ON matches (first_user_id_id)');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A94B3C1283');
        $this->addSql('ALTER TABLE swipe DROP CONSTRAINT FK_DB59E9A93E4E1AC0');
        $this->addSql('DROP INDEX IDX_DB59E9A94B3C1283');
        $this->addSql('DROP INDEX IDX_DB59E9A93E4E1AC0');
        $this->addSql('ALTER TABLE swipe ADD swipper_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE swipe ADD swipped_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE swipe DROP swipper_id');
        $this->addSql('ALTER TABLE swipe DROP swipped_id');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT fk_db59e9a9d2a96cf6 FOREIGN KEY (swipper_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE swipe ADD CONSTRAINT fk_db59e9a9d6a7c502 FOREIGN KEY (swipped_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_db59e9a9d6a7c502 ON swipe (swipped_id_id)');
        $this->addSql('CREATE INDEX idx_db59e9a9d2a96cf6 ON swipe (swipper_id_id)');
    }
}
