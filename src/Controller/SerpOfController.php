<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpOfRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpOf;
use App\Form\SerpOfType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* @Route("/of")
*/

class SerpOfController extends AbstractController
{
    private $serp_of_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpOfRepository $serp_of_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_of_repository = $serp_of_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="of_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $ofs = $this->serp_of_repository->getAllSortedByDateCommande();

        return $this->render('serp_of/infos.html.twig', [
            'ofs' => $ofs
        ]);
    }

    /**
     * @Route("/cree", name="cree_of", methods = {"POST"})
     */
    public function baseCreeOf(Request $request) {

        $of = new SerpOf();
        $form = $this->createForm(SerpOfType::class, $of);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $of = $form->getData();
            $this->entity_manager->persist($of);
            $this->entity_manager->flush();
            $response = json_encode($of->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {
            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_of/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_of", methods = {"POST"})
     */
    public function editeOf(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_of_edite", $id);
        }
        
        $of = $this->serp_of_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpOfType::class, $of);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $of_original = $this->serp_of_repository->findOneBy(["id" => $this->session->get("id_of_edite")]);
            $of_edite = $form->getData();
            $of_original->setDateCommande($of_edite->getDateCommande());
            $of_original->setIdClient($of_edite->getIdClient());
            $of_original->setMachineId($of_edite->getMachineId());
            $of_original->setQuantiteCommandee($of_edite->getQuantiteCommandee());
            $this->entity_manager->persist($of_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_of_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_of/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_of", methods = {"POST"})
     */
    public function effaceOf(Request $request) {

        $of = $this->serp_of_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($of);
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
