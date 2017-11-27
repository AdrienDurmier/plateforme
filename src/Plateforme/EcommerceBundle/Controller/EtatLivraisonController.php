<?php

namespace Plateforme\EcommerceBundle\Controller;

use Plateforme\EcommerceBundle\Entity\EtatLivraison;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EtatLivraisonController extends Controller {

  /**
   * Gestion des états de livraison
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $etats = $em->getRepository('PlateformeEcommerceBundle:EtatLivraison')->findAll();

    return $this->render('PlateformeEcommerceBundle:EtatLivraison:crud.html.twig', array(
          'etats' => $etats,
    ));
  }

  /**
   * Formulaire de création d'un état de livraison
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $etat = new EtatLivraison();
      $etat->setLabel($valeurs_recu['label']);
      $etat->setColor($valeurs_recu['color']);
      $em->persist($etat);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "État de livraison créé avec succès");
      return $this->redirectToRoute('plateforme_ecommerce_etatslivraison_crud');
    }
    return $this->render('PlateformeEcommerceBundle:EtatLivraison:add.html.twig');
  }

  /**
   * Formulaire d'édition d'une etat
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $etat = $em->getRepository('PlateformeEcommerceBundle:EtatLivraison')->find($id);
    if (null === $etat) {
      throw new NotFoundHttpException("L'état ayant l'identifiant " . $id . " n'existe pas.");
    }
    
    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $etat->setLabel($valeurs_recu['label']);
      $etat->setColor($valeurs_recu['color']);
      $em->persist($etat);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "État de livraison créé avec succès");
      return $this->redirectToRoute('plateforme_ecommerce_etatslivraison_crud');
    }
    
    return $this->render('PlateformeEcommerceBundle:EtatLivraison:edit.html.twig', array(
          'etat' => $etat,
    ));
  }

  /**
   * Formulaire de suppression d'une etat
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $etat = $em->getRepository('PlateformeEcommerceBundle:EtatLivraison')->find($id);
    if (null === $etat) {
      throw new NotFoundHttpException("L'état de livraison ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($etat);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "État de livraison supprimé avec succès");
    return $this->redirectToRoute('plateforme_ecommerce_etatslivraison_crud');
  }

}
