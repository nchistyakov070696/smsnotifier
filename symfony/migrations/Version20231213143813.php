<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231213143813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE provider_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sms_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, name VARCHAR(255) NOT NULL, access_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE provider (id INT NOT NULL, name VARCHAR(255) NOT NULL, rate NUMERIC(8, 2) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sms (id INT NOT NULL, customer_id INT DEFAULT NULL, provider_id INT DEFAULT NULL, phone_number VARCHAR(15) NOT NULL, is_sent BOOLEAN DEFAULT false NOT NULL, sending_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B0A93A779395C3F3 ON sms (customer_id)');
        $this->addSql('CREATE INDEX IDX_B0A93A77A53A8AA ON sms (provider_id)');
        $this->addSql('ALTER TABLE sms ADD CONSTRAINT FK_B0A93A779395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sms ADD CONSTRAINT FK_B0A93A77A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE provider_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sms_id_seq CASCADE');
        $this->addSql('ALTER TABLE sms DROP CONSTRAINT FK_B0A93A779395C3F3');
        $this->addSql('ALTER TABLE sms DROP CONSTRAINT FK_B0A93A77A53A8AA');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE sms');
    }
}
