<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521052310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT FK_9E6C24167E3C61F9');
        $this->addSql('ALTER TABLE devices.device ALTER owner_id DROP NOT NULL');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT FK_9E6C24167E3C61F9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor ALTER unit_measurement DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE devices.sensor ALTER unit_measurement SET NOT NULL');
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT fk_9e6c24167e3c61f9');
        $this->addSql('ALTER TABLE devices.device ALTER owner_id SET NOT NULL');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT fk_9e6c24167e3c61f9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
