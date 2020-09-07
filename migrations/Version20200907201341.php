<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200907201341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initial query - create tables';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE sources (name CHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, default_weight INT NOT NULL, PRIMARY KEY(name)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rates (from_date DATE NOT NULL COMMENT \'date when the rate was set\', base_currency CHAR(3) NOT NULL COMMENT \'base currency in ISO 4217\', quote_currency CHAR(3) NOT NULL COMMENT \'quote currency in ISO 4217\', source CHAR(50) NOT NULL, rate DOUBLE PRECISION NOT NULL, weight INT NOT NULL COMMENT \'bigger weight will be considered in case of concurrent rates from different sources\', created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_44D4AB3C5F8A7F73 (source), PRIMARY KEY(from_date, base_currency, quote_currency, source)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rates ADD CONSTRAINT FK_44D4AB3C5F8A7F73 FOREIGN KEY (source) REFERENCES sources (name)');
        $this->addSql("INSERT INTO `sources` VALUES ('coindesk', 'BTC to USD rate from https://api.coindesk.com/v1/bpi/historical/close.json', 20), ('ecb', 'EUR rates from https://www.ecb.europa.eu/', 10), ('manual', 'when you know what to do', 100);");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rates DROP FOREIGN KEY FK_44D4AB3C5F8A7F73');
        $this->addSql('DROP TABLE rates');
        $this->addSql('DROP TABLE sources');
    }
}
