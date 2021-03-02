<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302205134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depot CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE transaction CHANGE date_depot date_depot DATETIME NOT NULL, CHANGE date_retrait date_retrait DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depot CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE transaction CHANGE date_depot date_depot DATE NOT NULL, CHANGE date_retrait date_retrait DATE DEFAULT NULL');
    }
}
