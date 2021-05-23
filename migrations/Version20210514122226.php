<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514122226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serp_categories (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(25) NOT NULL, pays VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_controle_qualite (id INT AUTO_INCREMENT NOT NULL, id_intervenant_id INT NOT NULL, of_id_id INT NOT NULL, date DATETIME NOT NULL, quantite_controlee INT NOT NULL, INDEX IDX_CB41A60796FCAA10 (id_intervenant_id), INDEX IDX_CB41A607C031C7C9 (of_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_historique_production (id INT AUTO_INCREMENT NOT NULL, id_of_id INT DEFAULT NULL, id_intervenant_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME DEFAULT NULL, quantite_debut INT NOT NULL, quantite_fin INT DEFAULT NULL, INDEX IDX_C44A4BADB488E24C (id_of_id), INDEX IDX_C44A4BAD96FCAA10 (id_intervenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_intervenant (id INT AUTO_INCREMENT NOT NULL, id_type_intervenant_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_8CE1DC77BBB3A249 (id_type_intervenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_intervention (id INT AUTO_INCREMENT NOT NULL, id_type_intervention_id INT NOT NULL, id_machine_id INT NOT NULL, id_intervenant_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME DEFAULT NULL, observation VARCHAR(255) DEFAULT NULL, INDEX IDX_7D5BDC23756A5DB3 (id_type_intervention_id), INDEX IDX_7D5BDC23533DDBF1 (id_machine_id), INDEX IDX_7D5BDC2396FCAA10 (id_intervenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_machine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_matiere (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, quantite_stock INT NOT NULL, limite_basse_stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_matiere_produit (id INT AUTO_INCREMENT NOT NULL, id_produit_id INT NOT NULL, id_matiere_id INT NOT NULL, quantite_matiere INT NOT NULL, INDEX IDX_49536423AABEFE2C (id_produit_id), INDEX IDX_4953642351E6528F (id_matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_of (id INT AUTO_INCREMENT NOT NULL, id_client_id INT NOT NULL, machine_id_id INT NOT NULL, quantite_commandee INT NOT NULL, date_commande DATE NOT NULL, INDEX IDX_D1AC429A99DED506 (id_client_id), INDEX IDX_D1AC429A56CB5D24 (machine_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_type_intervenant (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, niveau INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serp_type_intervention (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE serp_controle_qualite ADD CONSTRAINT FK_CB41A60796FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id)');
        $this->addSql('ALTER TABLE serp_controle_qualite ADD CONSTRAINT FK_CB41A607C031C7C9 FOREIGN KEY (of_id_id) REFERENCES serp_of (id)');
        $this->addSql('ALTER TABLE serp_historique_production ADD CONSTRAINT FK_C44A4BADB488E24C FOREIGN KEY (id_of_id) REFERENCES serp_of (id)');
        $this->addSql('ALTER TABLE serp_historique_production ADD CONSTRAINT FK_C44A4BAD96FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id)');
        $this->addSql('ALTER TABLE serp_intervenant ADD CONSTRAINT FK_8CE1DC77BBB3A249 FOREIGN KEY (id_type_intervenant_id) REFERENCES serp_type_intervenant (id)');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC23756A5DB3 FOREIGN KEY (id_type_intervention_id) REFERENCES serp_type_intervention (id)');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC23533DDBF1 FOREIGN KEY (id_machine_id) REFERENCES serp_machine (id)');
        $this->addSql('ALTER TABLE serp_intervention ADD CONSTRAINT FK_7D5BDC2396FCAA10 FOREIGN KEY (id_intervenant_id) REFERENCES serp_intervenant (id)');
        $this->addSql('ALTER TABLE serp_matiere_produit ADD CONSTRAINT FK_49536423AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES serp_produit (id)');
        $this->addSql('ALTER TABLE serp_matiere_produit ADD CONSTRAINT FK_4953642351E6528F FOREIGN KEY (id_matiere_id) REFERENCES serp_matiere (id)');
        $this->addSql('ALTER TABLE serp_of ADD CONSTRAINT FK_D1AC429A99DED506 FOREIGN KEY (id_client_id) REFERENCES serp_client (id)');
        $this->addSql('ALTER TABLE serp_of ADD CONSTRAINT FK_D1AC429A56CB5D24 FOREIGN KEY (machine_id_id) REFERENCES serp_machine (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serp_of DROP FOREIGN KEY FK_D1AC429A99DED506');
        $this->addSql('ALTER TABLE serp_controle_qualite DROP FOREIGN KEY FK_CB41A60796FCAA10');
        $this->addSql('ALTER TABLE serp_historique_production DROP FOREIGN KEY FK_C44A4BAD96FCAA10');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC2396FCAA10');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC23533DDBF1');
        $this->addSql('ALTER TABLE serp_of DROP FOREIGN KEY FK_D1AC429A56CB5D24');
        $this->addSql('ALTER TABLE serp_matiere_produit DROP FOREIGN KEY FK_4953642351E6528F');
        $this->addSql('ALTER TABLE serp_controle_qualite DROP FOREIGN KEY FK_CB41A607C031C7C9');
        $this->addSql('ALTER TABLE serp_historique_production DROP FOREIGN KEY FK_C44A4BADB488E24C');
        $this->addSql('ALTER TABLE serp_matiere_produit DROP FOREIGN KEY FK_49536423AABEFE2C');
        $this->addSql('ALTER TABLE serp_intervenant DROP FOREIGN KEY FK_8CE1DC77BBB3A249');
        $this->addSql('ALTER TABLE serp_intervention DROP FOREIGN KEY FK_7D5BDC23756A5DB3');
        $this->addSql('DROP TABLE serp_categories');
        $this->addSql('DROP TABLE serp_client');
        $this->addSql('DROP TABLE serp_controle_qualite');
        $this->addSql('DROP TABLE serp_historique_production');
        $this->addSql('DROP TABLE serp_intervenant');
        $this->addSql('DROP TABLE serp_intervention');
        $this->addSql('DROP TABLE serp_machine');
        $this->addSql('DROP TABLE serp_matiere');
        $this->addSql('DROP TABLE serp_matiere_produit');
        $this->addSql('DROP TABLE serp_of');
        $this->addSql('DROP TABLE serp_produit');
        $this->addSql('DROP TABLE serp_type_intervenant');
        $this->addSql('DROP TABLE serp_type_intervention');
    }
}
