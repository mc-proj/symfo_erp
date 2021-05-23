<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\SerpCategories;
use App\Entity\SerpTypeIntervenant;
use App\Entity\SerpTypeIntervention;

use App\Entity\SerpClient;
use App\Entity\SerpIntervenant;
use App\Entity\SerpMachine;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //creation des categories existantes
        $categorie_client = new SerpCategories();
        $categorie_client->setNom("client");
        $manager->persist($categorie_client);

        $categorie_controle_qualite = new SerpCategories();
        $categorie_controle_qualite->setNom("controle qualite");
        $manager->persist($categorie_controle_qualite);

        $categorie_ordre_fabrication = new SerpCategories();
        $categorie_ordre_fabrication->setNom("ordre de fabrication");
        $manager->persist($categorie_ordre_fabrication);

        $categorie_produit = new SerpCategories();
        $categorie_produit->setNom("produit");
        $manager->persist($categorie_produit);

        $categorie_matiere = new SerpCategories();
        $categorie_matiere->setNom("matiere");
        $manager->persist($categorie_matiere);

        $categorie_historique_production = new SerpCategories();
        $categorie_historique_production->setNom("historique de production");
        $manager->persist($categorie_historique_production);

        $categorie_machine = new SerpCategories();
        $categorie_machine->setNom("machine");
        $manager->persist($categorie_machine);

        $categorie_intervention = new SerpCategories();
        $categorie_intervention->setNom("intervention");
        $manager->persist($categorie_intervention);

        $categorie_intervenant = new SerpCategories();
        $categorie_intervenant->setNom("intervenant");
        $manager->persist($categorie_intervenant);

        //creation des types d'intervenants
        $intervenant_operateur = new SerpTypeIntervenant();
        $intervenant_operateur->setIntitule("opérateur");
        $intervenant_operateur->setNiveau(1);
        $manager->persist($intervenant_operateur);

        $intervenant_maintenance = new SerpTypeIntervenant();
        $intervenant_maintenance->setIntitule("technicien maintenance");
        $intervenant_maintenance->setNiveau(2);
        $manager->persist($intervenant_maintenance);

        $intervenant_qualite = new SerpTypeIntervenant();
        $intervenant_qualite->setIntitule("technicien qualité");
        $manager->persist($intervenant_qualite);
        $intervenant_qualite->setNiveau(3);

        $intervenant_magasinier = new SerpTypeIntervenant();
        $intervenant_magasinier->setIntitule("magasinier");
        $intervenant_magasinier->setNiveau(4);
        $manager->persist($intervenant_magasinier);

        $intervenant_conception = new SerpTypeIntervenant();
        $intervenant_conception->setIntitule("bureau d'études");
        $intervenant_conception->setNiveau(5);
        $manager->persist($intervenant_conception);

        //creation des types d'interventions
        $intervention_maintenance = new SerpTypeIntervention();
        $intervention_maintenance->setNom("intervention de maintenance");
        $manager->persist($intervention_maintenance);

        $intervention_autre = new SerpTypeIntervention();
        $intervention_autre->setNom("intervention divers");
        $manager->persist($intervention_autre);

        //--provi pour dev
        $client = new SerpClient();
        $client->setNom("client 1");
        $client->setAdresse("1 rue test");
        $client->setVille("ville 1");
        $client->setCodePostal("12345");
        $client->setPays('FR');
        $manager->persist($client);

        $client2 = new SerpClient();
        $client2->setNom("client 2");
        $client2->setAdresse("2 rue test");
        $client2->setVille("ville 2");
        $client2->setCodePostal("12345");
        $client2->setPays('FR');
        $manager->persist($client2);

        $intervenant1 = new SerpIntervenant();
        $intervenant1->setIdTypeIntervenant($intervenant_operateur);
        $intervenant1->setNom("nom 1");
        $intervenant1->setPrenom("prenom 1");
        $manager->persist($intervenant1);

        $intervenant2 = new SerpIntervenant();
        $intervenant2->setIdTypeIntervenant($intervenant_magasinier);
        $intervenant2->setNom("nom 2");
        $intervenant2->setPrenom("prenom 2");
        $manager->persist($intervenant2);

        $machine1 = new SerpMachine();
        $machine1->setNom("machine 1");
        $manager->persist($machine1);

        $machine2 = new SerpMachine();
        $machine2->setNom("machine 2");
        $manager->persist($machine2);
        //--

        $manager->flush();
    }
}
