<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpHistoriqueProductionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpHistoriqueProduction;
use App\Form\SerpHistoriqueProductionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/historique")
*/

class SerpHistoriqueProductionController extends AbstractController
{
    private $serp_historique_production_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpHistoriqueProductionRepository $serp_historique_production_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_historique_production_repository = $serp_historique_production_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="historique_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $historiques = $this->serp_historique_production_repository->getAllSortedByDateDebut();

        return $this->render('serp_historique_production/infos.html.twig', [
            'historiques' => $historiques
        ]);
    }

    /**
     * @Route("/cree", name="cree_historique", methods = {"POST"})
     */
    public function baseCreeHistorique(Request $request) {

        $historique = new SerpHistoriqueProduction();
        $form = $this->createForm(SerpHistoriqueProductionType::class, $historique);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $historique = $form->getData();
            $this->entity_manager->persist($historique);
            $this->entity_manager->flush();
            $response = json_encode($historique->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_historique_production/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_historique", methods = {"POST"})
     */
    public function editeHistorique(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_historique_edite", $id);
        }
        
        $historique = $this->serp_historique_production_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpHistoriqueProductionType::class, $historique);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $historique_original = $this->serp_historique_production_repository->findOneBy(["id" => $this->session->get("id_historique_edite")]);
            $historique_edite = $form->getData();
            $historique_original->setIdOf($historique_edite->getIdOf());
            $historique_original->setDateDebut($historique_edite->getDateDebut());
            $historique_original->setDateFin($historique_edite->getDateFin());
            $historique_original->setIdIntervenant($historique_edite->getIdIntervenant());
            $historique_original->setQuantiteDebut($historique_edite->getQuantiteDebut());
            $historique_original->setQuantiteFin($historique_edite->getQuantiteFin());
            $this->entity_manager->persist($historique_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_historique_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_historique_production/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_historique", methods = {"POST"})
     */
    public function effaceHistorique(Request $request) {

        $historique = $this->serp_historique_production_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($historique);
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
