<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpControleQualiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\SerpControleQualite;
use App\Form\SerpControleQualiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use DateTime;

/**
* @Route("/qualite")
*/

class SerpControleQualiteController extends AbstractController
{
    private $serp_controle_qualite_repository;
    private $session;
    private $entity_manager;

    public function __construct(
            SerpControleQualiteRepository $serp_controle_qualite_repository,
            SessionInterface $session,
            EntityManagerInterface $entity_manager
        ) {
        $this->serp_controle_qualite_repository = $serp_controle_qualite_repository;
        $this->session = $session;
        $this->entity_manager = $entity_manager;
    }

    /**
     * @Route("/infos", name="qualite_infos", methods = {"POST"})
     */
    public function index(): Response
    {
        $controles = $this->serp_controle_qualite_repository->getAllSortedByDate();

        return $this->render('serp_controle_qualite/infos.html.twig', [
            'qualites' => $controles
        ]);
    }

    //cree_qualite
    /**
     * @Route("/cree", name="cree_qualite", methods = {"POST"})
     */
    public function baseCreeControleQualite(Request $request) {

        $controle = new SerpControleQualite();
        $form = $this->createForm(SerpControleQualiteType::class, $controle);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $controle = $form->getData();
            $maintenant = new DateTime('NOW');
            $controle->setDate($maintenant);
            $this->entity_manager->persist($controle);
            $this->entity_manager->flush();
            $retour = ['id' => $controle->getId(), 'date' => $maintenant->format("d/m/Y H:i")];
            $response = new JsonResponse($retour);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_controle_qualite/form_nouveau.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edite", name="edite_qualite", methods = {"POST"})
     */
    public function editeControleQualite(Request $request) {

        $id = $request->request->get("id");

        if($id != null) {
            $this->session->set("id_qualite_edite", $id);
        }
        
        $controle = $this->serp_controle_qualite_repository->findOneBy(["id" => $id]);
        $form = $this->createForm(SerpControleQualiteType::class, $controle);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $controle_original = $this->serp_controle_qualite_repository->findOneBy(["id" => $this->session->get("id_qualite_edite")]);
            $controle_edite = $form->getData();
            $controle_original->setQuantiteControlee($controle_edite->getQuantiteControlee());
            $controle_original->setIdIntervenant($controle_edite->getIdIntervenant());
            $controle_original->setOfId($controle_edite->getOfId());
            $this->entity_manager->persist($controle_original);
            $this->entity_manager->flush();
            $response = json_encode($this->session->get("id_qualite_edite"));
            $response = new JsonResponse($response);
            return $response;

        } else if($form->isSubmitted()) {

            return $this->RecupereErreursForm($form);
        }

        return $this->render('serp_controle_qualite/form_edition.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/efface", name="efface_qualite", methods = {"POST"})
     */
    public function effaceControleQualite(Request $request) {

        $controle = $this->serp_controle_qualite_repository->findOneBy(["id" => $request->request->get("id")]);
        $this->entity_manager->remove($controle);
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
