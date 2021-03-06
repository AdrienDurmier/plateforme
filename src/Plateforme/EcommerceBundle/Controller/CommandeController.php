<?php

namespace Plateforme\EcommerceBundle\Controller;

use Plateforme\EcommerceBundle\Entity\Commande;
use Plateforme\EcommerceBundle\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommandeController extends Controller {

  /**
   * Gestion des commandes
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $commandes = $em->getRepository('PlateformeEcommerceBundle:Commande')->findAll();

    return $this->render('PlateformeEcommerceBundle:Commande:crud.html.twig', array(
          'commandes' => $commandes,
    ));
  }

  /**
   * Formulaire de création d'une commande
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $commande = new Commande();
    $form = $this->get('form.factory')->create(CommandeType::class, $commande);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($commande);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Commande créée avec succès");
        return $this->redirectToRoute('plateforme_ecommerce_commandes_crud');
      }
    }
    return $this->render('PlateformeEcommerceBundle:Commande:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire d'édition d'une commande
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $commande = $em->getRepository('PlateformeEcommerceBundle:Commande')->find($id);
    if (null === $commande) {
      throw new NotFoundHttpException("Le commande ayant l'identifiant " . $id . " n'existe pas.");
    }

    $lignes_commande = $em->getRepository('PlateformeEcommerceBundle:CommandeLigne')->findByCommande($commande->getId());
    $etats_paiement = $em->getRepository('PlateformeEcommerceBundle:EtatPaiement')->findAll();
    $etats_livraison = $em->getRepository('PlateformeEcommerceBundle:EtatLivraison')->findAll();

    if ($request->isMethod('POST')) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($commande);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Commande modifiée avec succès");
      return $this->redirectToRoute('plateforme_ecommerce_commandes_crud');
    }

    return $this->render('PlateformeEcommerceBundle:Commande:edit.html.twig', array(
          'commande' => $commande,
          'lignes_commande' => $lignes_commande,
          'etats_paiement' => $etats_paiement,
          'etats_livraison' => $etats_livraison,
    ));
  }

  /**
   * Mise à jour du statut d'une commande
   */
  public function statusAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    $commande = $em->getRepository('PlateformeEcommerceBundle:Commande')->find($id);
    if (null === $commande) {
      throw new NotFoundHttpException("Le commande ayant l'identifiant " . $id . " n'existe pas.");
    }
    $etat_livraison = $em->getRepository('PlateformeEcommerceBundle:EtatLivraison')->find($valeurs_recu['status_livraison']);
    $commande->setEtatLivraison($etat_livraison);
    $etat_paiement = $em->getRepository('PlateformeEcommerceBundle:EtatPaiement')->find($valeurs_recu['status_paiement']);
    $commande->setEtatPaiement($etat_paiement);
    $em->persist($commande);
    $em->flush();
    $request->getSession()->getFlashBag()->add('success', "Status de la commande mis à jour");
    return $this->redirectToRoute('plateforme_ecommerce_commandes_edit', array('id' => $id));
  }

  /**
   * Formulaire de suppression d'une commande
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $commande = $em->getRepository('PlateformeEcommerceBundle:Commande')->find($id);
    if (null === $commande) {
      throw new NotFoundHttpException("Le commande ayant l'identifiant " . $id . " n'existe pas.");
    }
    $em->remove($commande);
    $em->flush();
    $request->getSession()->getFlashBag()->add('info', "Commande supprimée avec succès");
    return $this->redirectToRoute('plateforme_ecommerce_commandes_crud');
  }

  /**
   * Mise à jour d'une commande après un paiement
   */
  public function majAction($datas, $commande) {
    $em = $this->getDoctrine()->getManager();
    $commande->setStatus('paiement_accepte');
    $em->persist($commande);
    $em->flush();
    return $this->redirectToRoute('plateforme_ecommerce_commandes_crud');
  }

}
