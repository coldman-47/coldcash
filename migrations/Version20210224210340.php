<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224210340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_agence ADD agence_id INT NOT NULL');
        $this->addSql('ALTER TABLE admin_agence ADD CONSTRAINT FK_3909AB50D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3909AB50D725330D ON admin_agence (agence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_agence DROP FOREIGN KEY FK_3909AB50D725330D');
        $this->addSql('DROP INDEX UNIQ_3909AB50D725330D ON admin_agence');
        $this->addSql('ALTER TABLE admin_agence DROP agence_id');
    }
}
