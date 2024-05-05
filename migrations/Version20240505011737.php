<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505011737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA account');
        $this->addSql('CREATE SEQUENCE "account"."address_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "account"."document_type_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "account"."email_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "account"."user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "account"."address" (id INT NOT NULL, street VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, neighborhood VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, reference VARCHAR(255) DEFAULT NULL, complement VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "account"."document_type" (id INT NOT NULL, type VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "account"."email" (id INT NOT NULL, address VARCHAR(255) NOT NULL, validated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, validation_code VARCHAR(255) DEFAULT NULL, validation_code_created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, validation_code_sent_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "account"."email".validated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "account"."email".validation_code_created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "account"."email".validation_code_sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "account"."user" (id INT NOT NULL, document_type_id INT NOT NULL, email_id INT NOT NULL, security_info_id INT DEFAULT NULL, address_id INT DEFAULT NULL, first_name VARCHAR(55) NOT NULL, last_name VARCHAR(55) NOT NULL, document VARCHAR(55) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5B2989C61232A4F ON "account"."user" (document_type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989CA832C1C9 ON "account"."user" (email_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989C3060CAE5 ON "account"."user" (security_info_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C5B2989CF5B7AF75 ON "account"."user" (address_id)');
        $this->addSql('ALTER TABLE "account"."user" ADD CONSTRAINT FK_C5B2989C61232A4F FOREIGN KEY (document_type_id) REFERENCES "account"."document_type" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "account"."user" ADD CONSTRAINT FK_C5B2989CA832C1C9 FOREIGN KEY (email_id) REFERENCES "account"."email" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "account"."user" ADD CONSTRAINT FK_C5B2989C3060CAE5 FOREIGN KEY (security_info_id) REFERENCES user_security_info (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "account"."user" ADD CONSTRAINT FK_C5B2989CF5B7AF75 FOREIGN KEY (address_id) REFERENCES "account"."address" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "account"."address_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "account"."document_type_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "account"."email_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "account"."user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "account"."user" DROP CONSTRAINT FK_C5B2989C61232A4F');
        $this->addSql('ALTER TABLE "account"."user" DROP CONSTRAINT FK_C5B2989CA832C1C9');
        $this->addSql('ALTER TABLE "account"."user" DROP CONSTRAINT FK_C5B2989C3060CAE5');
        $this->addSql('ALTER TABLE "account"."user" DROP CONSTRAINT FK_C5B2989CF5B7AF75');
        $this->addSql('DROP TABLE "account"."address"');
        $this->addSql('DROP TABLE "account"."document_type"');
        $this->addSql('DROP TABLE "account"."email"');
        $this->addSql('DROP TABLE "account"."user"');
    }
}
