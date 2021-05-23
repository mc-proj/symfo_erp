<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpProduit;
use App\Form\SerpProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/produit")
*/

class SerpProduitController extends AbstractController
{
    private $serp_produit_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpProduitRepository $serp_produit_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_produit_repository = $serp_produit_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="produit_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $produits = $this->serp_produit_repository->getAllSortedByNom();

        return $this->render('serp_produit/infos.html.twig', [
            "produits" => $produits
        ]);
    }

    /**
     * @Route("/cree", name="cree_produit", methods = {"POST"})
     */
    public function baseCreeProduit(Request $request) {

        $produit = new SerpProduit();
        $form = $this->createForm(SerpProduitType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $produit = $form->getData();
            $this->entity_manager->persist($produit);
            $this->entity_manager->flush();
            $response = json_encode($produit->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_produit/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_produit", methods = {"POST"})
     */
    public function editeProduit(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_produit_edite", $id);
        }
        
        $produit = $this->serp_produit_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpProduitType::class, $produit);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $produit_original = $this->serp_produit_repository->findOneBy(["id" => $this->session->get("id_produit_edite")]);
            $produit_edite = $form->getData();
            $produit_original->setNom($produit_edite->getNom());
            $this->entity_manager->persist($produit_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_produit_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_produit/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_produit", methods = {"POST"})
     */
    public function effaceProduit(Request $request) {

        $produit = $this->serp_produit_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($produit);
        $this->entity_manager->flush();
        $response = json_encode("done");
        $response = new JsonResponse($response);
        return $response;
    }

    /**
     * @Route("/infos_matiere", name="info_matiere_produit", methods = {"POST"})
     */
    public function infosMatiereProduit(Request $request) {

        $produit = $this->serp_produit_repository->findOneBy(["id" => $request->request->get("id")]);
        $matieres_produits = $produit->getIdMatiereProduit();

        return $this->render('serp_produit/infos_matiere.html.twig', [
            'matieres_produits' => $matieres_produits,
            'id_produit' => $request->request->get("id"),
        ]);
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
