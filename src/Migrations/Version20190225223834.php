<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190225223834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, parent LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', child LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE device ADD categorie_id INT DEFAULT NULL, ADD ip_public VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_92FB68EBCF5E72D ON device (categorie_id)');
        $this->addSql('ALTER TABLE customer ADD lat DOUBLE PRECISION NOT NULL, ADD lng DOUBLE PRECISION NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD postal_code VARCHAR(255) NOT NULL, ADD country VARCHAR(30) DEFAULT NULL, ADD rating INT DEFAULT NULL, ADD email VARCHAR(100) NOT NULL, ADD mobile VARCHAR(100) DEFAULT NULL, ADD contact VARCHAR(100) DEFAULT NULL, ADD contact_title VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68EBCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('ALTER TABLE customer DROP lat, DROP lng, DROP city, DROP postal_code, DROP country, DROP rating, DROP email, DROP mobile, DROP contact, DROP contact_title');
        $this->addSql('DROP INDEX IDX_92FB68EBCF5E72D ON device');
        $this->addSql('ALTER TABLE device DROP categorie_id, DROP ip_public');
    }
}
