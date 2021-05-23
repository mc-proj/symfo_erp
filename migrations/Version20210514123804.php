<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514123804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serp_historique_production DROP FOREIGN KEY FK_C44A4BADB488E24C');
        $this->addSql('ALTER TABLE serp_historique_production ADD CONSTRAINT FK_C44A4BADB488E24C FOREIGN KEY (id_of_id) REFERENCES serp_of (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serp_historique_production DROP FOREIGN KEY FK_C44A4BADB488E24C');
        $this->addSql('ALTER TABLE serp_historique_production ADD CONSTRAINT FK_C44A4BADB488E24C FOREIGN KEY (id_of_id) REFERENCES serp_of (id)');
    }
}
