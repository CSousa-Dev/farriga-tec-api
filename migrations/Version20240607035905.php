<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240607035905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT FK_9E6C24167E3C61F9');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT FK_9E6C24167E3C61F9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.irrigator_type ADD model VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE devices.share DROP CONSTRAINT FK_7E4D8D51CD53EDB6');
        $this->addSql('ALTER TABLE devices.share DROP CONSTRAINT FK_7E4D8D514EE63723');
        $this->addSql('ALTER TABLE devices.share ADD CONSTRAINT FK_7E4D8D51CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.share ADD CONSTRAINT FK_7E4D8D514EE63723 FOREIGN KEY (sharer_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE devices.share DROP CONSTRAINT fk_7e4d8d51cd53edb6');
        $this->addSql('ALTER TABLE devices.share DROP CONSTRAINT fk_7e4d8d514ee63723');
        $this->addSql('ALTER TABLE devices.share ADD CONSTRAINT fk_7e4d8d51cd53edb6 FOREIGN KEY (receiver_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.share ADD CONSTRAINT fk_7e4d8d514ee63723 FOREIGN KEY (sharer_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT fk_9e6c24167e3c61f9');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT fk_9e6c24167e3c61f9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.irrigator_type DROP model');
    }
}
