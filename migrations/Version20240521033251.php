<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521033251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA account');
        $this->addSql('CREATE SCHEMA security');
        $this->addSql('CREATE SCHEMA devices');
        $this->addSql('CREATE SEQUENCE account.address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE security.api_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.device_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE account.document_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE account.email_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.event_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.sensor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.sprinkler_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE account.user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE security.user_security_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account.address (id INT NOT NULL, street VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, neighborhood VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, reference VARCHAR(255) DEFAULT NULL, complement VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE security.api_token (id INT NOT NULL, owned_by_id INT NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, token VARCHAR(68) NOT NULL, scope JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A97C3325E70BCD7 ON security.api_token (owned_by_id)');
        $this->addSql('COMMENT ON COLUMN security.api_token.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devices.device (id INT NOT NULL, owner_id INT NOT NULL, mac_address VARCHAR(55) NOT NULL, alias VARCHAR(55) DEFAULT NULL, model VARCHAR(55) NOT NULL, power_status VARCHAR(55) NOT NULL, usage_mode VARCHAR(55) NOT NULL, waiting_for_power_status_confirmation BOOLEAN NOT NULL, communication_status VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9E6C24167E3C61F9 ON devices.device (owner_id)');
        $this->addSql('CREATE TABLE device_event (device_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(device_id, event_id))');
        $this->addSql('CREATE INDEX IDX_FD2BEAC094A4C7D4 ON device_event (device_id)');
        $this->addSql('CREATE INDEX IDX_FD2BEAC071F7E88B ON device_event (event_id)');
        $this->addSql('CREATE TABLE account.document_type (id INT NOT NULL, type VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE account.email (id INT NOT NULL, address VARCHAR(255) NOT NULL, validated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, validation_code VARCHAR(255) DEFAULT NULL, validation_code_created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, validation_code_sent_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN account.email.validated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN account.email.validation_code_created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN account.email.validation_code_sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devices.event (id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(55) NOT NULL, listen_key VARCHAR(55) DEFAULT NULL, notify_key VARCHAR(55) NOT NULL, can_listen BOOLEAN NOT NULL, can_notify BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AAE51AACC54C8C93 ON devices.event (type_id)');
        $this->addSql('CREATE TABLE devices.event_type (id INT NOT NULL, type VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE devices.sensor (id INT NOT NULL, device_id INT NOT NULL, name VARCHAR(55) NOT NULL, unit_measurement VARCHAR(55) NOT NULL, power_status VARCHAR(55) NOT NULL, can_controll_irrigation BOOLEAN NOT NULL, controll_value VARCHAR(55) NOT NULL, waiting_for_controll_value_confirmation BOOLEAN NOT NULL, communication_status VARCHAR(55) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2BC5852894A4C7D4 ON devices.sensor (device_id)');
        $this->addSql('CREATE TABLE sensor_event (sensor_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(sensor_id, event_id))');
        $this->addSql('CREATE INDEX IDX_7DEA504FA247991F ON sensor_event (sensor_id)');
        $this->addSql('CREATE INDEX IDX_7DEA504F71F7E88B ON sensor_event (event_id)');
        $this->addSql('CREATE TABLE devices.sprinkler (id INT NOT NULL, device_id INT NOT NULL, number INT NOT NULL, type VARCHAR(55) DEFAULT NULL, alias VARCHAR(55) NOT NULL, model VARCHAR(55) DEFAULT NULL, interval_for_actvation INT NOT NULL, last_configured_activation_interval INT NOT NULL, last_activation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, power_status VARCHAR(55) NOT NULL, waiting_for_power_status_confirmation BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A5B0F04B94A4C7D4 ON devices.sprinkler (device_id)');
        $this->addSql('CREATE TABLE sprinkler_event (sprinkler_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(sprinkler_id, event_id))');
        $this->addSql('CREATE INDEX IDX_3794876DEE5D4C7D ON sprinkler_event (sprinkler_id)');
        $this->addSql('CREATE INDEX IDX_3794876D71F7E88B ON sprinkler_event (event_id)');
        $this->addSql('CREATE TABLE account."user" (id INT NOT NULL, document_type_id INT NOT NULL, email_id INT NOT NULL, security_info_id INT DEFAULT NULL, address_id INT DEFAULT NULL, first_name VARCHAR(55) NOT NULL, last_name VARCHAR(55) NOT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, document VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5B2989C61232A4F ON account."user" (document_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989CA832C1C9 ON account."user" (email_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989C3060CAE5 ON account."user" (security_info_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989CF5B7AF75 ON account."user" (address_id)');
        $this->addSql('COMMENT ON COLUMN account."user".birth_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE security.user_security_info (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B35E9CFE7927C74 ON security.user_security_info (email)');
        $this->addSql('ALTER TABLE security.api_token ADD CONSTRAINT FK_A97C3325E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES security.user_security_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT FK_9E6C24167E3C61F9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device_event ADD CONSTRAINT FK_FD2BEAC094A4C7D4 FOREIGN KEY (device_id) REFERENCES devices.device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device_event ADD CONSTRAINT FK_FD2BEAC071F7E88B FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.event ADD CONSTRAINT FK_AAE51AACC54C8C93 FOREIGN KEY (type_id) REFERENCES devices.event_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor ADD CONSTRAINT FK_2BC5852894A4C7D4 FOREIGN KEY (device_id) REFERENCES devices.device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sensor_event ADD CONSTRAINT FK_7DEA504FA247991F FOREIGN KEY (sensor_id) REFERENCES devices.sensor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sensor_event ADD CONSTRAINT FK_7DEA504F71F7E88B FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sprinkler ADD CONSTRAINT FK_A5B0F04B94A4C7D4 FOREIGN KEY (device_id) REFERENCES devices.device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sprinkler_event ADD CONSTRAINT FK_3794876DEE5D4C7D FOREIGN KEY (sprinkler_id) REFERENCES devices.sprinkler (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sprinkler_event ADD CONSTRAINT FK_3794876D71F7E88B FOREIGN KEY (event_id) REFERENCES devices.event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989C61232A4F FOREIGN KEY (document_type_id) REFERENCES account.document_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989CA832C1C9 FOREIGN KEY (email_id) REFERENCES account.email (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989C3060CAE5 FOREIGN KEY (security_info_id) REFERENCES security.user_security_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989CF5B7AF75 FOREIGN KEY (address_id) REFERENCES account.address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE account.address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE security.api_token_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.device_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE account.document_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE account.email_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.event_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.sensor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.sprinkler_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE account.user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE security.user_security_info_id_seq CASCADE');
        $this->addSql('ALTER TABLE security.api_token DROP CONSTRAINT FK_A97C3325E70BCD7');
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT FK_9E6C24167E3C61F9');
        $this->addSql('ALTER TABLE device_event DROP CONSTRAINT FK_FD2BEAC094A4C7D4');
        $this->addSql('ALTER TABLE device_event DROP CONSTRAINT FK_FD2BEAC071F7E88B');
        $this->addSql('ALTER TABLE devices.event DROP CONSTRAINT FK_AAE51AACC54C8C93');
        $this->addSql('ALTER TABLE devices.sensor DROP CONSTRAINT FK_2BC5852894A4C7D4');
        $this->addSql('ALTER TABLE sensor_event DROP CONSTRAINT FK_7DEA504FA247991F');
        $this->addSql('ALTER TABLE sensor_event DROP CONSTRAINT FK_7DEA504F71F7E88B');
        $this->addSql('ALTER TABLE devices.sprinkler DROP CONSTRAINT FK_A5B0F04B94A4C7D4');
        $this->addSql('ALTER TABLE sprinkler_event DROP CONSTRAINT FK_3794876DEE5D4C7D');
        $this->addSql('ALTER TABLE sprinkler_event DROP CONSTRAINT FK_3794876D71F7E88B');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989C61232A4F');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989CA832C1C9');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989C3060CAE5');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989CF5B7AF75');
        $this->addSql('DROP TABLE account.address');
        $this->addSql('DROP TABLE security.api_token');
        $this->addSql('DROP TABLE devices.device');
        $this->addSql('DROP TABLE device_event');
        $this->addSql('DROP TABLE account.document_type');
        $this->addSql('DROP TABLE account.email');
        $this->addSql('DROP TABLE devices.event');
        $this->addSql('DROP TABLE devices.event_type');
        $this->addSql('DROP TABLE devices.sensor');
        $this->addSql('DROP TABLE sensor_event');
        $this->addSql('DROP TABLE devices.sprinkler');
        $this->addSql('DROP TABLE sprinkler_event');
        $this->addSql('DROP TABLE account."user"');
        $this->addSql('DROP TABLE security.user_security_info');
    }
}
