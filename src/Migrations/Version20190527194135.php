<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190527194135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE device_net_interface (device_id INT NOT NULL, net_interface_id INT NOT NULL, INDEX IDX_6E2F181694A4C7D4 (device_id), INDEX IDX_6E2F181689263AE6 (net_interface_id), PRIMARY KEY(device_id, net_interface_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE net_interface (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) DEFAULT NULL, type VARCHAR(12) NOT NULL, ip VARCHAR(15) NOT NULL, mac VARCHAR(20) DEFAULT NULL, port INT DEFAULT NULL, mask VARCHAR(15) DEFAULT NULL, gateway VARCHAR(15) DEFAULT NULL, domain VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE device_net_interface ADD CONSTRAINT FK_6E2F181694A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE device_net_interface ADD CONSTRAINT FK_6E2F181689263AE6 FOREIGN KEY (net_interface_id) REFERENCES net_interface (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device_net_interface DROP FOREIGN KEY FK_6E2F181689263AE6');
        $this->addSql('DROP TABLE device_net_interface');
        $this->addSql('DROP TABLE net_interface');
    }
}
