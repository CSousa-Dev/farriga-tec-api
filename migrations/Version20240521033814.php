<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521033814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devices.device_event (device_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(device_id, event_id))');
        $this->addSql('CREATE INDEX IDX_D625533894A4C7D4 ON devices.device_event (device_id)');
        $this->addSql('CREATE INDEX IDX_D625533871F7E88B ON devices.device_event (event_id)');
        $this->addSql('CREATE TABLE devices.sensor_event (sensor_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(sensor_id, event_id))');
        $this->addSql('CREATE INDEX IDX_56E4E9B7A247991F ON devices.sensor_event (sensor_id)');
        $this->addSql('CREATE INDEX IDX_56E4E9B771F7E88B ON devices.sensor_event (event_id)');
        $this->addSql('CREATE TABLE devices.sprinkler_event (sprinkler_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(sprinkler_id, event_id))');
        $this->addSql('CREATE INDEX IDX_5EFC9DD8EE5D4C7D ON devices.sprinkler_event (sprinkler_id)');
        $this->addSql('CREATE INDEX IDX_5EFC9DD871F7E88B ON devices.sprinkler_event (event_id)');
        $this->addSql('ALTER TABLE devices.device_event ADD CONSTRAINT FK_D625533894A4C7D4 FOREIGN KEY (device_id) REFERENCES devices.device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device_event ADD CONSTRAINT FK_D625533871F7E88B FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor_event ADD CONSTRAINT FK_56E4E9B7A247991F FOREIGN KEY (sensor_id) REFERENCES devices.sensor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor_event ADD CONSTRAINT FK_56E4E9B771F7E88B FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sprinkler_event ADD CONSTRAINT FK_5EFC9DD8EE5D4C7D FOREIGN KEY (sprinkler_id) REFERENCES devices.sprinkler (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sprinkler_event ADD CONSTRAINT FK_5EFC9DD871F7E88B FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sensor_event DROP CONSTRAINT fk_7dea504fa247991f');
        $this->addSql('ALTER TABLE sensor_event DROP CONSTRAINT fk_7dea504f71f7e88b');
        $this->addSql('ALTER TABLE sprinkler_event DROP CONSTRAINT fk_3794876dee5d4c7d');
        $this->addSql('ALTER TABLE sprinkler_event DROP CONSTRAINT fk_3794876d71f7e88b');
        $this->addSql('ALTER TABLE device_event DROP CONSTRAINT fk_fd2beac094a4c7d4');
        $this->addSql('ALTER TABLE device_event DROP CONSTRAINT fk_fd2beac071f7e88b');
        $this->addSql('DROP TABLE sensor_event');
        $this->addSql('DROP TABLE sprinkler_event');
        $this->addSql('DROP TABLE device_event');
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT FK_9E6C24167E3C61F9');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT FK_9E6C24167E3C61F9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE sensor_event (sensor_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(sensor_id, event_id))');
        $this->addSql('CREATE INDEX idx_7dea504f71f7e88b ON sensor_event (event_id)');
        $this->addSql('CREATE INDEX idx_7dea504fa247991f ON sensor_event (sensor_id)');
        $this->addSql('CREATE TABLE sprinkler_event (sprinkler_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(sprinkler_id, event_id))');
        $this->addSql('CREATE INDEX idx_3794876d71f7e88b ON sprinkler_event (event_id)');
        $this->addSql('CREATE INDEX idx_3794876dee5d4c7d ON sprinkler_event (sprinkler_id)');
        $this->addSql('CREATE TABLE device_event (device_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(device_id, event_id))');
        $this->addSql('CREATE INDEX idx_fd2beac071f7e88b ON device_event (event_id)');
        $this->addSql('CREATE INDEX idx_fd2beac094a4c7d4 ON device_event (device_id)');
        $this->addSql('ALTER TABLE sensor_event ADD CONSTRAINT fk_7dea504fa247991f FOREIGN KEY (sensor_id) REFERENCES devices.sensor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sensor_event ADD CONSTRAINT fk_7dea504f71f7e88b FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sprinkler_event ADD CONSTRAINT fk_3794876dee5d4c7d FOREIGN KEY (sprinkler_id) REFERENCES devices.sprinkler (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sprinkler_event ADD CONSTRAINT fk_3794876d71f7e88b FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device_event ADD CONSTRAINT fk_fd2beac094a4c7d4 FOREIGN KEY (device_id) REFERENCES devices.device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device_event ADD CONSTRAINT fk_fd2beac071f7e88b FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device_event DROP CONSTRAINT FK_D625533894A4C7D4');
        $this->addSql('ALTER TABLE devices.device_event DROP CONSTRAINT FK_D625533871F7E88B');
        $this->addSql('ALTER TABLE devices.sensor_event DROP CONSTRAINT FK_56E4E9B7A247991F');
        $this->addSql('ALTER TABLE devices.sensor_event DROP CONSTRAINT FK_56E4E9B771F7E88B');
        $this->addSql('ALTER TABLE devices.sprinkler_event DROP CONSTRAINT FK_5EFC9DD8EE5D4C7D');
        $this->addSql('ALTER TABLE devices.sprinkler_event DROP CONSTRAINT FK_5EFC9DD871F7E88B');
        $this->addSql('DROP TABLE devices.device_event');
        $this->addSql('DROP TABLE devices.sensor_event');
        $this->addSql('DROP TABLE devices.sprinkler_event');
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT fk_9e6c24167e3c61f9');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT fk_9e6c24167e3c61f9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
