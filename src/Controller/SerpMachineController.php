<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\SerpMachineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpMachine;
use App\Form\SerpMachineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/machine")
*/

class SerpMachineController extends AbstractController
{
    private $serp_machine_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpMachineRepository $serp_machine_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_machine_repository = $serp_machine_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("infos", name="machine_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $machines = $this->serp_machine_repository->getAllSortedByNom();

        return $this->render('serp_machine/infos.html.twig', [
            "machines" => $machines
        ]);
    }

        /**
     * @Route("/cree", name="cree_machine", methods = {"POST"})
     */
    public function baseCreeMachine(Request $request) {

        $machine = new SerpMachine();
        $form = $this->createForm(SerpMachineType::class, $machine);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $machine = $form->getData();
            $this->entity_manager->persist($machine);
            $this->entity_manager->flush();
            $response = json_encode($machine->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_machine/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_machine", methods = {"POST"})
     */
    public function editeMachine(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_machine_edite", $id);
        }
        
        $machine = $this->serp_machine_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpMachineType::class, $machine);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $machine_original = $this->serp_machine_repository->findOneBy(["id" => $this->session->get("id_machine_edite")]);
            $machine_edite = $form->getData();
            $machine_original->setNom($machine_edite->getNom());
            $this->entity_manager->persist($machine_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_machine_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_machine/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_machine", methods = {"POST"})
     */
    public function effaceMachine(Request $request) {

        $machine = $this->serp_machine_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($machine);
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
