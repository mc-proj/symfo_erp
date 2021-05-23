<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpProduitRepository;
use App\Repository\SerpMatiereProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpMatiereProduit;
use App\Form\SerpMatiereProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/matiere_produit")
*/

class SerpMatiereProduitController extends AbstractController
{

    private $serp_produit_repository;
    private $serp_matiere_produit_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpMatiereProduitRepository $serp_matiere_produit_repository,
            SerpProduitRepository $serp_produit_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_produit_repository = $serp_produit_repository;
        $this->serp_matiere_produit_repository = $serp_matiere_produit_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }


    /**
     * @Route("/cree", name="lie_nouvelle_matiere", methods = {"POST"})
     */
    public function LieMatiereAProduit(Request $request)
    {
        $id_produit = $request->request->get("id_produit");

        if($id_produit != null) {
            $this->session->set("id_produit_lie", $id_produit);
        }

        $matiere_produit = new SerpMatiereProduit();
        $form = $this->createForm(SerpMatiereProduitType::class, $matiere_produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $matiere_produit_soumis = $form->getData();
            $produit = $this->serp_produit_repository->findOneBy(["id" => $this->session->get("id_produit_lie")]);
            $liaison_existante = $this->serp_matiere_produit_repository->findOneBy(
                ['id_matiere' => $matiere_produit_soumis->getIdMatiere(),
                 'id_produit' => $produit
                ]);

            if($liaison_existante == null) {

                $matiere_produit_soumis->setIdProduit($produit);
                $this->entity_manager->persist($matiere_produit_soumis);
                $this->entity_manager->flush();
                $response = json_encode($matiere_produit_soumis->getId());
            } else {
                $response = json_encode("securite double");
            }
            
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_matiere_produit/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/edite", name="edite_matiere_liee", methods = {"POST"})
    */
    public function EditeMatiereLieeAProduit(Request $request) {

        $id_produit = $request->request->get("id_produit");
        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_liaison_matiere_produit", $id);
        }

        if($id_produit != null) {
            $this->session->set("id_produit_lie", $id_produit);
        }
        
        $liaison = $this->serp_matiere_produit_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpMatiereProduitType::class, $liaison);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $response = null;
            $liaison_originale = $this->serp_matiere_produit_repository->findOneBy(["id" => $this->session->get("id_liaison_matiere_produit")]);
            $liaison_editee = $form->getData();


            $produit = $this->serp_produit_repository->findOneBy(["id" => $this->session->get("id_produit_lie")]);
            $liaison_existante = $this->serp_matiere_produit_repository->findOneBy(
                ['id_matiere' => $liaison_editee->getIdMatiere(),
                 'id_produit' => $produit
                ]);

            if($liaison_existante != null && ($liaison_existante->getId() != $liaison_originale->getId())) {

                $response = json_encode("securite double");
            } else {

                $liaison_originale->setIdMatiere($liaison_editee->getIdMatiere());
                $liaison_originale->setQuantiteMatiere($liaison_editee->getQuantiteMatiere());
                $this->entity_manager->persist($liaison_originale);
                $this->entity_manager->flush();
                $response = json_encode($this->session->get("id_liaison_matiere_produit"));
            }

            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_matiere_produit/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="supprime_matiere_liee", methods = {"POST"})
     */
    public function effaceProduit(Request $request) {

        $liaison = $this->serp_matiere_produit_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($liaison);
        $this->entity_manager->flush();
        $response = json_encode("done");
        $response = new JsonResponse($response);
        return $response;
    }

    private function RecupereErreursForm($form) {

        $erreurs = [];

        foreach($form->getErrors(true) as $error) {

            $erreurs[$error->getOrigin()->getName()] = $error->getMessage();
        }

        $response = json_encode($erreurs);
        $response = new JsonResponse($response);
        return $response;
    }
}
