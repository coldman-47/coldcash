<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226120958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction CHANGE montant montant DOUBLE PRECISION NOT NULL, CHANGE frais frais DOUBLE PRECISION NOT NULL, CHANGE frais_etat frais_etat DOUBLE PRECISION DEFAULT NULL, CHANGE frais_system frais_system DOUBLE PRECISION DEFAULT NULL, CHANGE frais_depot frais_depot DOUBLE PRECISION DEFAULT NULL, CHANGE frais_retrait frais_retrait DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction CHANGE montant montant INT NOT NULL, CHANGE frais frais INT NOT NULL, CHANGE frais_etat frais_etat INT DEFAULT NULL, CHANGE frais_system frais_system INT DEFAULT NULL, CHANGE frais_depot frais_depot INT DEFAULT NULL, CHANGE frais_retrait frais_retrait INT DEFAULT NULL');
    }
}
