<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514130012 extends AbstractMigration
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
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC23533DDBF1');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC23756A5DB3');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC2396FCAA10');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC23533DDBF1 FOREIGN KEY (id_machine_id) REFERENCES serp_machine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC23756A5DB3 FOREIGN KEY (id_type_intervention_id) REFERENCES serp_type_intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC2396FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serp_of DROP FOREIGN KEY FK_D1AC429A56CB5D24');
        $this->addSql('ALTER TABLE serp_of DROP FOREIGN KEY FK_D1AC429A99DED506');
        $this->addSql('ALTER TABLE serp_of ADD CONSTRAINT FK_D1AC429A56CB5D24 FOREIGN KEY (machine_id_id) REFERENCES serp_machine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serp_of ADD CONSTRAINT FK_D1AC429A99DED506 FOREIGN KEY (id_client_id) REFERENCES serp_client (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serp_controle_qualite DROP FOREIGN KEY FK_CB41A60796FCAA10');
        $this->addSql('ALTER TABLE serp_controle_qualite ADD CONSTRAINT FK_CB41A60796FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id)');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC23756A5DB3');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC23533DDBF1');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC2396FCAA10');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC23756A5DB3 FOREIGN KEY (id_type_intervention_id) REFERENCES serp_type_intervention (id)');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC23533DDBF1 FOREIGN KEY (id_machine_id) REFERENCES serp_machine (id)');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC2396FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id)');
        $this->addSql('ALTER TABLE serp_of DROP FOREIGN KEY FK_D1AC429A99DED506');
        $this->addSql('ALTER TABLE serp_of DROP FOREIGN KEY FK_D1AC429A56CB5D24');
        $this->addSql('ALTER TABLE serp_of ADD CONSTRAINT FK_D1AC429A99DED506 FOREIGN KEY (id_client_id) REFERENCES serp_client (id)');
        $this->addSql('ALTER TABLE serp_of ADD CONSTRAINT FK_D1AC429A56CB5D24 FOREIGN KEY (machine_id_id) REFERENCES serp_machine (id)');
    }
}
