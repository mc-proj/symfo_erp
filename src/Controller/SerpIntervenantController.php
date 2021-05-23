<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpIntervenantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpIntervenant;
use App\Form\SerpIntervenantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/intervenant")
*/

class SerpIntervenantController extends AbstractController
{
    private $serp_intervenant_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpIntervenantRepository $serp_intervenant_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_intervenant_repository = $serp_intervenant_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="intervenant_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $intervenants = $this->serp_intervenant_repository->getAllSortedByNom();

        return $this->render('serp_intervenant/infos.html.twig', [
            "intervenants" => $intervenants
        ]);
    }

    /**
     * @Route("/cree", name="cree_intervenant", methods = {"POST"})
     */
    public function baseCreeIntervenant(Request $request) {

        $intervenant = new SerpIntervenant();
        $form = $this->createForm(SerpIntervenantType::class, $intervenant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $intervenant = $form->getData();
            $this->entity_manager->persist($intervenant);
            $this->entity_manager->flush();
            $response = json_encode($intervenant->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_intervenant/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_intervenant", methods = {"POST"})
     */
    public function editeIntervenant(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_intervenant_edite", $id);
        }
        
        $intervenant = $this->serp_intervenant_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpintervenantType::class, $intervenant);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $intervenant_original = $this->serp_intervenant_repository->findOneBy(["id" => $this->session->get("id_intervenant_edite")]);
            $intervenant_edite = $form->getData();
            $intervenant_original->setNom($intervenant_edite->getNom());
            $intervenant_original->setPrenom($intervenant_edite->getPrenom());
            $intervenant_original->setIdTypeIntervenant($intervenant_edite->getIdTypeIntervenant());
            $this->entity_manager->persist($intervenant_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_intervenant_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_intervenant/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_intervenant", methods = {"POST"})
     */
    public function effaceIntervenant(Request $request) {

        $intervenant = $this->serp_intervenant_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($intervenant);
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
