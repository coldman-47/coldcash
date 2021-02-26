<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225225037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, cni INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD envoyeur_id INT NOT NULL, ADD receveur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14795A786 FOREIGN KEY (envoyeur_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B967E626 FOREIGN KEY (receveur_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_723705D14795A786 ON transaction (envoyeur_id)');
        $this->addSql('CREATE INDEX IDX_723705D1B967E626 ON transaction (receveur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14795A786');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B967E626');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP INDEX IDX_723705D14795A786 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1B967E626 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP envoyeur_id, DROP receveur_id');
    }
}
