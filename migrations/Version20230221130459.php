<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221130459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT fk_e3fec116992ebed6');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT fk_e3fec116f0265ee8');
        $this->addSql('DROP INDEX idx_e3fec116f0265ee8');
        $this->addSql('DROP INDEX idx_e3fec116992ebed6');
        $this->addSql('ALTER TABLE deal ADD first_user_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deal ADD second_user_object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deal DROP first_user_object_id_id');
        $this->addSql('ALTER TABLE deal DROP second_user_object_id_id');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116C99FE1A1 FOREIGN KEY (first_user_object_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC11638E1863D FOREIGN KEY (second_user_object_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E3FEC116C99FE1A1 ON deal (first_user_object_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC11638E1863D ON deal (second_user_object_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116C99FE1A1');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC11638E1863D');
        $this->addSql('DROP INDEX IDX_E3FEC116C99FE1A1');
        $this->addSql('DROP INDEX IDX_E3FEC11638E1863D');
        $this->addSql('ALTER TABLE deal ADD first_user_object_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deal ADD second_user_object_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deal DROP first_user_object_id');
        $this->addSql('ALTER TABLE deal DROP second_user_object_id');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT fk_e3fec116992ebed6 FOREIGN KEY (first_user_object_id_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT fk_e3fec116f0265ee8 FOREIGN KEY (second_user_object_id_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e3fec116f0265ee8 ON deal (second_user_object_id_id)');
        $this->addSql('CREATE INDEX idx_e3fec116992ebed6 ON deal (first_user_object_id_id)');
    }
}
