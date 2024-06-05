<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604210804 extends AbstractMigration
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
        $this->addSql('CREATE SEQUENCE device_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE account.document_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE account.email_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.event_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.irrigator_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.irrigator_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.measure_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.permissions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.sensor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.sensor_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.share_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.treshold_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE account.user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE security.user_security_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devices.zone_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account.address (id INT NOT NULL, street VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, neighborhood VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, reference VARCHAR(255) DEFAULT NULL, complement VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE security.api_token (id INT NOT NULL, owned_by_id INT NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, token VARCHAR(68) NOT NULL, scope JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A97C3325E70BCD7 ON security.api_token (owned_by_id)');
        $this->addSql('COMMENT ON COLUMN security.api_token.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devices.device (id INT NOT NULL, owner_id INT DEFAULT NULL, device_type_id INT DEFAULT NULL, alias VARCHAR(255) DEFAULT NULL, mac_address VARCHAR(255) NOT NULL, power BOOLEAN NOT NULL, position INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9E6C24167E3C61F9 ON devices.device (owner_id)');
        $this->addSql('CREATE INDEX IDX_9E6C24164FFA550E ON devices.device (device_type_id)');
        $this->addSql('CREATE TABLE device_type (id INT NOT NULL, use_bluetooth BOOLEAN NOT NULL, use_wifi_connection BOOLEAN NOT NULL, can_power_controll BOOLEAN NOT NULL, can_manual_controll BOOLEAN NOT NULL, model VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE account.document_type (id INT NOT NULL, type VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE account.email (id INT NOT NULL, address VARCHAR(255) NOT NULL, validated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, validation_code VARCHAR(255) DEFAULT NULL, validation_code_created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, validation_code_sent_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN account.email.validated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN account.email.validation_code_created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN account.email.validation_code_sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devices.event_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, can_listen BOOLEAN NOT NULL, can_emit BOOLEAN NOT NULL, listen_key VARCHAR(255) DEFAULT NULL, emit_key VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE devices.sensor_event (event_type_id INT NOT NULL, sensor_type_id INT NOT NULL, PRIMARY KEY(event_type_id, sensor_type_id))');
        $this->addSql('CREATE INDEX IDX_56E4E9B7401B253C ON devices.sensor_event (event_type_id)');
        $this->addSql('CREATE INDEX IDX_56E4E9B7D8550BD9 ON devices.sensor_event (sensor_type_id)');
        $this->addSql('CREATE TABLE devices.irrigator_event (event_type_id INT NOT NULL, irrigator_type_id INT NOT NULL, PRIMARY KEY(event_type_id, irrigator_type_id))');
        $this->addSql('CREATE INDEX IDX_7648E9C1401B253C ON devices.irrigator_event (event_type_id)');
        $this->addSql('CREATE INDEX IDX_7648E9C1AB387479 ON devices.irrigator_event (irrigator_type_id)');
        $this->addSql('CREATE TABLE devices.device_event (event_type_id INT NOT NULL, device_type_id INT NOT NULL, PRIMARY KEY(event_type_id, device_type_id))');
        $this->addSql('CREATE INDEX IDX_D6255338401B253C ON devices.device_event (event_type_id)');
        $this->addSql('CREATE INDEX IDX_D62553384FFA550E ON devices.device_event (device_type_id)');
        $this->addSql('CREATE TABLE devices.irrigator (id INT NOT NULL, zone_id INT NOT NULL, irrigator_type_id INT NOT NULL, number INT NOT NULL, position INT NOT NULL, alias VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_540CA78E9F2C3FAB ON devices.irrigator (zone_id)');
        $this->addSql('CREATE INDEX IDX_540CA78EAB387479 ON devices.irrigator (irrigator_type_id)');
        $this->addSql('CREATE TABLE devices.irrigator_type (id INT NOT NULL, can_manual_control_irrigation BOOLEAN NOT NULL, can_change_watering_time BOOLEAN NOT NULL, can_change_check_interval BOOLEAN NOT NULL, can_turn_on_turn_off BOOLEAN NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE devices.measure (id INT NOT NULL, sensor_id INT NOT NULL, value VARCHAR(255) NOT NULL, timestamp TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E4441C1A247991F ON devices.measure (sensor_id)');
        $this->addSql('COMMENT ON COLUMN devices.measure.timestamp IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devices.permissions (id INT NOT NULL, share_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_970EA6D52AE63FDB ON devices.permissions (share_id)');
        $this->addSql('CREATE TABLE devices.sensor (id INT NOT NULL, zone_id INT NOT NULL, sensor_type_id INT NOT NULL, treshold_id INT DEFAULT NULL, position INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2BC585289F2C3FAB ON devices.sensor (zone_id)');
        $this->addSql('CREATE INDEX IDX_2BC58528D8550BD9 ON devices.sensor (sensor_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2BC58528D396CE97 ON devices.sensor (treshold_id)');
        $this->addSql('CREATE TABLE devices.sensor_type (id INT NOT NULL, model VARCHAR(255) NOT NULL, can_controll_start_stop BOOLEAN NOT NULL, can_change_treshold BOOLEAN NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, unit VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE devices.share (id INT NOT NULL, receiver_id INT NOT NULL, sharer_id INT DEFAULT NULL, device_id INT NOT NULL, shared_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E4D8D51CD53EDB6 ON devices.share (receiver_id)');
        $this->addSql('CREATE INDEX IDX_7E4D8D514EE63723 ON devices.share (sharer_id)');
        $this->addSql('CREATE INDEX IDX_7E4D8D5194A4C7D4 ON devices.share (device_id)');
        $this->addSql('COMMENT ON COLUMN devices.share.shared_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE devices.treshold (id INT NOT NULL, type VARCHAR(255) NOT NULL, configured_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, value VARCHAR(255) DEFAULT NULL, min_value VARCHAR(255) DEFAULT NULL, max_value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN devices.treshold.configured_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE account."user" (id INT NOT NULL, document_type_id INT NOT NULL, email_id INT NOT NULL, security_info_id INT DEFAULT NULL, address_id INT DEFAULT NULL, first_name VARCHAR(55) NOT NULL, last_name VARCHAR(55) NOT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, document VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5B2989C61232A4F ON account."user" (document_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989CA832C1C9 ON account."user" (email_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989C3060CAE5 ON account."user" (security_info_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989CF5B7AF75 ON account."user" (address_id)');
        $this->addSql('COMMENT ON COLUMN account."user".birth_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE security.user_security_info (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B35E9CFE7927C74 ON security.user_security_info (email)');
        $this->addSql('CREATE TABLE devices.zone (id INT NOT NULL, device_id INT NOT NULL, position INT NOT NULL, alias VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8F975C4994A4C7D4 ON devices.zone (device_id)');
        $this->addSql('ALTER TABLE security.api_token ADD CONSTRAINT FK_A97C3325E70BCD7 FOREIGN KEY (owned_by_id) REFERENCES security.user_security_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT FK_9E6C24167E3C61F9 FOREIGN KEY (owner_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device ADD CONSTRAINT FK_9E6C24164FFA550E FOREIGN KEY (device_type_id) REFERENCES device_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor_event ADD CONSTRAINT FK_56E4E9B7401B253C FOREIGN KEY (event_type_id) REFERENCES devices.event_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor_event ADD CONSTRAINT FK_56E4E9B7D8550BD9 FOREIGN KEY (sensor_type_id) REFERENCES devices.sensor_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.irrigator_event ADD CONSTRAINT FK_7648E9C1401B253C FOREIGN KEY (event_type_id) REFERENCES devices.event_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.irrigator_event ADD CONSTRAINT FK_7648E9C1AB387479 FOREIGN KEY (irrigator_type_id) REFERENCES devices.irrigator_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device_event ADD CONSTRAINT FK_D6255338401B253C FOREIGN KEY (event_type_id) REFERENCES devices.event_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.device_event ADD CONSTRAINT FK_D62553384FFA550E FOREIGN KEY (device_type_id) REFERENCES device_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.irrigator ADD CONSTRAINT FK_540CA78E9F2C3FAB FOREIGN KEY (zone_id) REFERENCES devices.zone (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.irrigator ADD CONSTRAINT FK_540CA78EAB387479 FOREIGN KEY (irrigator_type_id) REFERENCES devices.irrigator_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.measure ADD CONSTRAINT FK_7E4441C1A247991F FOREIGN KEY (sensor_id) REFERENCES devices.sensor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.permissions ADD CONSTRAINT FK_970EA6D52AE63FDB FOREIGN KEY (share_id) REFERENCES devices.share (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor ADD CONSTRAINT FK_2BC585289F2C3FAB FOREIGN KEY (zone_id) REFERENCES devices.zone (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor ADD CONSTRAINT FK_2BC58528D8550BD9 FOREIGN KEY (sensor_type_id) REFERENCES devices.sensor_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.sensor ADD CONSTRAINT FK_2BC58528D396CE97 FOREIGN KEY (treshold_id) REFERENCES devices.treshold (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.share ADD CONSTRAINT FK_7E4D8D51CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.share ADD CONSTRAINT FK_7E4D8D514EE63723 FOREIGN KEY (sharer_id) REFERENCES account."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.share ADD CONSTRAINT FK_7E4D8D5194A4C7D4 FOREIGN KEY (device_id) REFERENCES devices.device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989C61232A4F FOREIGN KEY (document_type_id) REFERENCES account.document_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989CA832C1C9 FOREIGN KEY (email_id) REFERENCES account.email (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989C3060CAE5 FOREIGN KEY (security_info_id) REFERENCES security.user_security_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account."user" ADD CONSTRAINT FK_C5B2989CF5B7AF75 FOREIGN KEY (address_id) REFERENCES account.address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devices.zone ADD CONSTRAINT FK_8F975C4994A4C7D4 FOREIGN KEY (device_id) REFERENCES devices.device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE account.address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE security.api_token_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.device_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE device_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE account.document_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE account.email_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.event_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.irrigator_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.irrigator_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.measure_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.permissions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.sensor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.sensor_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.share_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.treshold_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE account.user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE security.user_security_info_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devices.zone_id_seq CASCADE');
        $this->addSql('ALTER TABLE security.api_token DROP CONSTRAINT FK_A97C3325E70BCD7');
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT FK_9E6C24167E3C61F9');
        $this->addSql('ALTER TABLE devices.device DROP CONSTRAINT FK_9E6C24164FFA550E');
        $this->addSql('ALTER TABLE devices.sensor_event DROP CONSTRAINT FK_56E4E9B7401B253C');
        $this->addSql('ALTER TABLE devices.sensor_event DROP CONSTRAINT FK_56E4E9B7D8550BD9');
        $this->addSql('ALTER TABLE devices.irrigator_event DROP CONSTRAINT FK_7648E9C1401B253C');
        $this->addSql('ALTER TABLE devices.irrigator_event DROP CONSTRAINT FK_7648E9C1AB387479');
        $this->addSql('ALTER TABLE devices.device_event DROP CONSTRAINT FK_D6255338401B253C');
        $this->addSql('ALTER TABLE devices.device_event DROP CONSTRAINT FK_D62553384FFA550E');
        $this->addSql('ALTER TABLE devices.irrigator DROP CONSTRAINT FK_540CA78E9F2C3FAB');
        $this->addSql('ALTER TABLE devices.irrigator DROP CONSTRAINT FK_540CA78EAB387479');
        $this->addSql('ALTER TABLE devices.measure DROP CONSTRAINT FK_7E4441C1A247991F');
        $this->addSql('ALTER TABLE devices.permissions DROP CONSTRAINT FK_970EA6D52AE63FDB');
        $this->addSql('ALTER TABLE devices.sensor DROP CONSTRAINT FK_2BC585289F2C3FAB');
        $this->addSql('ALTER TABLE devices.sensor DROP CONSTRAINT FK_2BC58528D8550BD9');
        $this->addSql('ALTER TABLE devices.sensor DROP CONSTRAINT FK_2BC58528D396CE97');
        $this->addSql('ALTER TABLE devices.share DROP CONSTRAINT FK_7E4D8D51CD53EDB6');
        $this->addSql('ALTER TABLE devices.share DROP CONSTRAINT FK_7E4D8D514EE63723');
        $this->addSql('ALTER TABLE devices.share DROP CONSTRAINT FK_7E4D8D5194A4C7D4');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989C61232A4F');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989CA832C1C9');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989C3060CAE5');
        $this->addSql('ALTER TABLE account."user" DROP CONSTRAINT FK_C5B2989CF5B7AF75');
        $this->addSql('ALTER TABLE devices.zone DROP CONSTRAINT FK_8F975C4994A4C7D4');
        $this->addSql('DROP TABLE account.address');
        $this->addSql('DROP TABLE security.api_token');
        $this->addSql('DROP TABLE devices.device');
        $this->addSql('DROP TABLE device_type');
        $this->addSql('DROP TABLE account.document_type');
        $this->addSql('DROP TABLE account.email');
        $this->addSql('DROP TABLE devices.event_type');
        $this->addSql('DROP TABLE devices.sensor_event');
        $this->addSql('DROP TABLE devices.irrigator_event');
        $this->addSql('DROP TABLE devices.device_event');
        $this->addSql('DROP TABLE devices.irrigator');
        $this->addSql('DROP TABLE devices.irrigator_type');
        $this->addSql('DROP TABLE devices.measure');
        $this->addSql('DROP TABLE devices.permissions');
        $this->addSql('DROP TABLE devices.sensor');
        $this->addSql('DROP TABLE devices.sensor_type');
        $this->addSql('DROP TABLE devices.share');
        $this->addSql('DROP TABLE devices.treshold');
        $this->addSql('DROP TABLE account."user"');
        $this->addSql('DROP TABLE security.user_security_info');
        $this->addSql('DROP TABLE devices.zone');
    }
}
