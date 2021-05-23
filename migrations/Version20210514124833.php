<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514124833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serp_controle_qualite DROP FOREIGN KEY FK_CB41A60796FCAA10');
        $this->addSql('ALTER TABLE serp_controle_qualite ADD CONSTRAINT FK_CB41A60796FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serp_controle_qualite DROP FOREIGN KEY FK_CB41A60796FCAA10');
        $this->addSql('ALTER TABLE serp_controle_qualite ADD CONSTRAINT FK_CB41A60796FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id)');
    }
}
