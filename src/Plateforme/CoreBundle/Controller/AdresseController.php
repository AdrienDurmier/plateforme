<?php
namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Plateforme\CoreBundle\Entity\Adresse;
use Plateforme\CoreBundle\Form\AdresseType;

class AdresseController extends Controller
{
    /**
     * Gestion des adresses
     */
    public function crudAction()
    {
      $em = $this->getDoctrine()->getManager();
      $client = $this->get('security.token_storage')->getToken()->getUser();
      $adresses = $em->getRepository('PlateformeCoreBundle:Adresse')->findByClient($client);
      return $this->render('PlateformeCoreBundle:Adresse:crud.html.twig', array(
        'adresses'   => $adresses,
      ));
    }
    
  
    /**
     * Formulaire de création d'une adresse
     */
    public function addAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      
      $adresse = new Adresse();
      $form = $this->get('form.factory')->create(AdresseType::class, $adresse);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $client = $this->get('security.token_storage')->getToken()->getUser();
          $adresse->setClient($client);
          $em->persist($adresse);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Adresse créée avec succès");
          return $this->redirectToRoute('plateforme_core_page_adresses');
        }
      }
      return $this->render('PlateformeCoreBundle:Adresse:add.html.twig', array(
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire d'édition d'une adresse
     */
    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $adresse = $em->getRepository('PlateformeCoreBundle:Adresse')->find($id);
      if (null === $adresse) {
        throw new NotFoundHttpException("L'adresse ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create(AdresseType::class, $adresse);
      
      if ($request->isMethod('POST')) {
        $form->handleRequest($request);
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $client = $this->get('security.token_storage')->getToken()->getUser();
          $adresse->setClient($client);
          $em->persist($adresse);
          $em->flush();
          $request->getSession()->getFlashBag()->add('info', "Adresse modifiée avec succès");
          return $this->redirectToRoute('plateforme_core_page_adresses');
        }
      }
      
      return $this->render('PlateformeCoreBundle:Adresse:edit.html.twig', array(
        'adresse' => $adresse,
        'form' => $form->createView(),
      ));
    }
    
    /**
     * Formulaire de suppression d'une adresse
     */
    public function deleteAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $adresse = $em->getRepository('PlateformeCoreBundle:Adresse')->find($id);
      if (null === $adresse) {
        throw new NotFoundHttpException("L'adresse ayant l'identifiant ".$id." n'existe pas.");
      }
      $form = $this->get('form.factory')->create();
      
      if ($request->isMethod('POST')) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($adresse);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Adresse supprimée avec succès");
        return $this->redirectToRoute('plateforme_core_page_adresses');
      }
      
      return $this->render('PlateformeCoreBundle:Adresse:delete.html.twig', array(
        'adresse' => $adresse,
        'form' => $form->createView(),
      ));
    }
    
    
}
