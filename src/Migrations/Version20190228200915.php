<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190228200915 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer ADD customer_num INT DEFAULT NULL');
        $this->addSql('ALTER TABLE device ADD maker VARCHAR(255) DEFAULT NULL, ADD model VARCHAR(255) DEFAULT NULL, ADD port INT DEFAULT NULL, ADD port_public INT DEFAULT NULL, ADD serial VARCHAR(255) DEFAULT NULL, ADD os_version VARCHAR(255) DEFAULT NULL, ADD mac_adress VARCHAR(100) DEFAULT NULL, ADD domain VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP customer_num');
        $this->addSql('ALTER TABLE device DROP maker, DROP model, DROP port, DROP port_public, DROP serial, DROP os_version, DROP mac_adress, DROP domain');
    }
}
