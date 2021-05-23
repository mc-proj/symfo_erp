<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpInterventionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpMachine;
use App\Entity\SerpIntervenant;
use App\Entity\SerpIntervention;
use App\Entity\SerpTypeIntervention;
use App\Form\SerpInterventionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/intervention")
*/

class SerpInterventionController extends AbstractController
{
    private $serp_intervention_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpInterventionRepository $serp_intervention_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_intervention_repository = $serp_intervention_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="intervention_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $interventions = $this->serp_intervention_repository->getAllSortedByDateDebut();

        return $this->render('serp_intervention/infos.html.twig', [
            'interventions' => $interventions
        ]);
    }

    /**
     * @Route("/cree", name="cree_intervention", methods = {"POST"})
     */
    public function baseCreeIntervention(Request $request) {

        $intervention = new SerpIntervention();
        $form = $this->createForm(SerpInterventionType::class, $intervention);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $intervention = $form->getData();
            $this->entity_manager->persist($intervention);
            $this->entity_manager->flush();
            $response = json_encode($intervention->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_intervention/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_intervention", methods = {"POST"})
     */
    public function editeIntervention(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_intervention_edite", $id);
        }
        
        $intervention = $this->serp_intervention_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpinterventionType::class, $intervention);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $intervention_original = $this->serp_intervention_repository->findOneBy(["id" => $this->session->get("id_intervention_edite")]);
            $intervention_edite = $form->getData();
            $intervention_original->setIdTypeIntervention($intervention_edite->getIdTypeIntervention());
            $intervention_original->setIdMachine($intervention_edite->getIdMachine());
            $intervention_original->setIdIntervenant($intervention_edite->getIdIntervenant());
            $intervention_original->setDateDebut($intervention_edite->getDateDebut());
            $intervention_original->setDateFin($intervention_edite->getDateFin());
            $intervention_original->setObservation($intervention_edite->getObservation());
            $this->entity_manager->persist($intervention_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_intervention_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_intervention/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_intervention", methods = {"POST"})
     */
    public function effaceIntervention(Request $request) {

        $intervention = $this->serp_intervention_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($intervention);
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
