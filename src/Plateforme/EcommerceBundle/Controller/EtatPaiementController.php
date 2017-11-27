<?php

namespace Plateforme\EcommerceBundle\Controller;

use Plateforme\EcommerceBundle\Entity\EtatPaiement;
use Plateforme\EcommerceBundle\Form\EtatPaiementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EtatPaiementController extends Controller {

  /**
   * Gestion des états de paiement
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $etats = $em->getRepository('PlateformeEcommerceBundle:EtatPaiement')->findAll();

    return $this->render('PlateformeEcommerceBundle:EtatPaiement:crud.html.twig', array(
          'etats' => $etats,
    ));
  }

  /**
   * Formulaire de création d'un état de paiement
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    if ($request->isMethod('POST')) {
      $valeurs_recu = $request->request->all();
      $etat = new EtatPaiement();
      $etat->setLabel($valeurs_recu['label']);
      $etat->setColor($valeurs_recu['color']);
      $em->persist($etat);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "État de livraison créé avec succès");
      return $this->redirectToRoute('plateforme_ecommerce_etatspaiement_crud');
    }
    return $this->render('PlateformeEcommerceBundle:EtatPaiement:add.html.twig');
  }

  /**
   * Formulaire d'édition d'une etat
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $etat = $em->getRepository('PlateformeEcommerceBundle:EtatPaiement')->find($id);
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
      return $this->redirectToRoute('plateforme_ecommerce_etatspaiement_crud');
    }
    
    return $this->render('PlateformeEcommerceBundle:EtatPaiement:edit.html.twig', array(
          'etat' => $etat,
    ));
  }

  /**
   * Formulaire de suppression d'une etat
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $etat = $em->getRepository('PlateformeEcommerceBundle:EtatPaiement')->find($id);
    if (null === $etat) {
      throw new NotFoundHttpException("L'état de paiement ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($etat);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "État de paiement supprimé avec succès");
    return $this->redirectToRoute('plateforme_ecommerce_etatspaiement_crud');
  }

}
