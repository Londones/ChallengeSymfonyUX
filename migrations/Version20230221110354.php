<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221110354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT fk_e3fec1166936d70c');
        $this->addSql('DROP INDEX idx_e3fec1166936d70c');
        $this->addSql('ALTER TABLE deal ADD second_user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deal ADD first_user_object_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deal ADD second_user_object_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deal DROP seconde_user_id_id');
        $this->addSql('ALTER TABLE deal DROP first_user_object_id');
        $this->addSql('ALTER TABLE deal DROP seconde_user_object_id');
        $this->addSql('ALTER TABLE deal ALTER first_user_id_id DROP NOT NULL');
        $this->addSql('ALTER TABLE deal ALTER status TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC1167ED8859C FOREIGN KEY (second_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116992EBED6 FOREIGN KEY (first_user_object_id_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116F0265EE8 FOREIGN KEY (second_user_object_id_id) REFERENCES items (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E3FEC1167ED8859C ON deal (second_user_id_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC116992EBED6 ON deal (first_user_object_id_id)');
        $this->addSql('CREATE INDEX IDX_E3FEC116F0265EE8 ON deal (second_user_object_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC1167ED8859C');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116992EBED6');
        $this->addSql('ALTER TABLE deal DROP CONSTRAINT FK_E3FEC116F0265EE8');
        $this->addSql('DROP INDEX IDX_E3FEC1167ED8859C');
        $this->addSql('DROP INDEX IDX_E3FEC116992EBED6');
        $this->addSql('DROP INDEX IDX_E3FEC116F0265EE8');
        $this->addSql('ALTER TABLE deal ADD seconde_user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE deal ADD first_user_object_id VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE deal ADD seconde_user_object_id VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE deal DROP second_user_id_id');
        $this->addSql('ALTER TABLE deal DROP first_user_object_id_id');
        $this->addSql('ALTER TABLE deal DROP second_user_object_id_id');
        $this->addSql('ALTER TABLE deal ALTER first_user_id_id SET NOT NULL');
        $this->addSql('ALTER TABLE deal ALTER status TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT fk_e3fec1166936d70c FOREIGN KEY (seconde_user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e3fec1166936d70c ON deal (seconde_user_id_id)');
    }
}
