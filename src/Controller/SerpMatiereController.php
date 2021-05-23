<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpMatiereRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpMatiere;
use App\Form\SerpMatiereType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/matiere")
**/

class SerpMatiereController extends AbstractController
{
    private $serp_matiere_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpMatiereRepository $serp_matiere_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_matiere_repository = $serp_matiere_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="matiere_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $matieres = $this->serp_matiere_repository->getAllSortedByNom();

        return $this->render('serp_matiere/infos.html.twig', [
            "matieres" => $matieres
        ]);
    }

    /**
     * @Route("/cree", name="cree_matiere", methods = {"POST"})
     */
    public function baseCreeMatiere(Request $request) {

        $matiere = new SerpMatiere();
        $form = $this->createForm(SerpMatiereType::class, $matiere);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $matiere = $form->getData();
            $this->entity_manager->persist($matiere);
            $this->entity_manager->flush();
            $response = json_encode($matiere->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_matiere/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_matiere", methods = {"POST"})
     */
    public function editeMatiere(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_matiere_edite", $id);
        }
        
        $matiere = $this->serp_matiere_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpMatiereType::class, $matiere);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $matiere_original = $this->serp_matiere_repository->findOneBy(["id" => $this->session->get("id_matiere_edite")]);
            $matiere_edite = $form->getData();
            $matiere_original->setNom($matiere_edite->getNom());
            $matiere_original->setPrix($matiere_edite->getPrix());
            $matiere_original->setQuantiteStock($matiere_edite->getQuantiteStock());
            $matiere_original->setLimiteBasseStock($matiere_edite->getLimiteBasseStock());
            $this->entity_manager->persist($matiere_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_matiere_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_matiere/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_matiere", methods = {"POST"})
     */
    public function effaceMatiere(Request $request) {

        $matiere = $this->serp_matiere_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($matiere);
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
