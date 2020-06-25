<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625073206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, sale_price, retail_price, image_url, quantity_available, uuid FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL COLLATE BINARY, sale_price INTEGER DEFAULT NULL, retail_price INTEGER DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL COLLATE BINARY, quantity_available INTEGER DEFAULT NULL, uuid CHAR(36) DEFAULT NULL --(DC2Type:guid)
        )');
        $this->addSql('INSERT INTO product (id, name, sale_price, retail_price, image_url, quantity_available, uuid) SELECT id, name, sale_price, retail_price, image_url, quantity_available, uuid FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, sale_price, retail_price, image_url, quantity_available, uuid FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, sale_price INTEGER DEFAULT NULL, retail_price INTEGER DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, quantity_available INTEGER DEFAULT NULL, uuid CHAR(36) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO product (id, name, sale_price, retail_price, image_url, quantity_available, uuid) SELECT id, name, sale_price, retail_price, image_url, quantity_available, uuid FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }
}
