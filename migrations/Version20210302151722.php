<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302151722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A498D443 FOREIGN KEY (agence_depot_id) REFERENCES agence (id)');
        $this->addSql('CREATE INDEX IDX_723705D1A498D443 ON transaction (agence_depot_id)');
        $this->addSql('ALTER TABLE transaction_termine ADD agence_retrait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction_termine ADD CONSTRAINT FK_6026366DBA1790A5 FOREIGN KEY (agence_retrait_id) REFERENCES agence (id)');
        $this->addSql('CREATE INDEX IDX_6026366DBA1790A5 ON transaction_termine (agence_retrait_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A498D443');
        $this->addSql('DROP INDEX IDX_723705D1A498D443 ON transaction');
        $this->addSql('ALTER TABLE transaction_termine DROP FOREIGN KEY FK_6026366DBA1790A5');
        $this->addSql('DROP INDEX IDX_6026366DBA1790A5 ON transaction_termine');
        $this->addSql('ALTER TABLE transaction_termine DROP agence_retrait_id');
    }
}
