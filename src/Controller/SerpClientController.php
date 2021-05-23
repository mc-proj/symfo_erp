<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpClient;
use App\Form\SerpClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Intl\Countries;

/**
* @Route("/client")
*/

class SerpClientController extends AbstractController
{
    private $serp_client_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpClientRepository $serp_client_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_client_repository = $serp_client_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="client_infos", methods = {"POST"})
     */
    public function infos(): Response
    {
        $clients = $this->serp_client_repository->getAllSortedByNom();
        //tranforme denomination bdd en version lisible : FR => France
        foreach($clients as $client) {

            $client->setPays(Countries::getName($client->getPays()));
        }

        return $this->render('serp_client/infos.html.twig', [
            'clients' => $clients,
        ]);
    }

    /**
     * @Route("/cree", name="cree_client", methods = {"POST"})
     */
    public function baseCreeClient(Request $request) {

        $client = new SerpClient();
        $form = $this->createForm(SerpClientType::class, $client);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $client = $form->getData();
            $this->entity_manager->persist($client);
            $this->entity_manager->flush();
            $response = json_encode($client->getId());
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_client/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_client", methods = {"POST"})
     */
    public function editeClient(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_client_edite", $id);
        }
        
        $client = $this->serp_client_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpClientType::class, $client);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $client_original = $this->serp_client_repository->findOneBy(["id" => $this->session->get("id_client_edite")]);
            $client_edite = $form->getData();
            $client_original->setNom($client_edite->getNom());
            $client_original->setAdresse($client_edite->getAdresse());
            $client_original->setVille($client_edite->getVille());
            $client_original->setCodePostal($client_edite->getCodePostal());
            $client_original->setPays($client_edite->getPays());
            $this->entity_manager->persist($client_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_client_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_client/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_client", methods = {"POST"})
     */
    public function effaceClient(Request $request) {

        $client = $this->serp_client_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($client);
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
