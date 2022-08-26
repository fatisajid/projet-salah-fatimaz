<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig'); 
    }
    
      #[Route('/admin/vehicules', name:'admin_vehicules')]
      

      public function adminVehicules(VehiculeRepository $repo, EntityManagerInterface $manager)
      {
        //on utilise le manager pour recuperer le nom des champ de la table vehicule
        $champs = $manager->getClassMetadata(Vehicule::class)->getFieldNames();
        // dd($champs); //dd(): dump & die : afficher des info et arreter l'execution du code

        $vehicule = $repo->findAll();

        return $this->render("admin/admin_vehicules.html.twig",[
      'vehicules' => $vehicule,
      'champs' => $champs
        ]);

    }

    /**
     * @Route("/admin/vehicule/new",name="admin_new_vehicule")
     * @Route("/admin/vehicule/edit/{id}", name="admin_edit_vehicule")
     */

public function vehicule_form(Vehicule $vehicule = null, Request $superglobals, EntityManagerInterface $manager)
{
    if($vehicule == null)
    {
        $vehicule = new Vehicule;
        $vehicule->setDateEnregistrement(new \DateTime());

    }
    $form = $this->createForm(VehiculeType::class, $vehicule);
    $form->handleRequest($superglobals);
    if($form->isSubmitted() && $form->isValid())
    {
        $manager->persist($vehicule);
        $manager->flush();
        return $this->redirectToRoute('admin_vehicules');
    }

    return $this->renderForm("admin/admin-form.html.twig", [
        'formVehicule' => $form,
        'editMode' => $vehicule->getId() !== NULL
    ]);
}
/**
 * @Route ("/admin/vehicule/delete/{id}", name="admin_delete_vehicule")
 */
 public function vehicule_delete(EntityManagerInterface $manager, VehiculeRepository $repo, $id)
    {
        $vehicule = $repo->find($id);
        $manager->remove($vehicule);


        $manager->flush();

        $this->addFlash('success', "vehicule a bien ete supprimé");

        return $this->redirectToRoute("admin_vehicules");
    }
}






















