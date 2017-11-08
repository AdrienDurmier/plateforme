<?php

namespace Plateforme\EcommerceBundle\Controller;

use Plateforme\EcommerceBundle\Entity\TarifLaposteLettre;
use Plateforme\EcommerceBundle\Form\TarifLaposteLettreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TarifLaposteLettreController extends Controller {

  /**
   * Gestion des tarifs de La Poste par lettre
   * @Security("has_role('ROLE_WEBMASTER')")
   */
  public function crudAction() {
    $em = $this->getDoctrine()->getManager();
    $tarifs = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteLettre')->findAll();
    return $this->render('PlateformeEcommerceBundle:TarifLaposteLettre:crud.html.twig', array(
          'tarifs' => $tarifs,
    ));
  }

  /**
   * Formulaire de tarif de La Poste par lettre
   * @Security("has_role('ROLE_WEBMASTER')")
   */
  public function addAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $tarif = new TarifLaposteLettre();
    $form = $this->get('form.factory')->create(TarifLaposteLettreType::class, $tarif);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($tarif);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Tarif créé avec succès");
        return $this->redirectToRoute('plateforme_ecommerce_tariflapostelettre_crud');
      }
    }
    return $this->render('PlateformeEcommerceBundle:TarifLaposteLettre:add.html.twig', array(
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire d'édition d'un tarif de La Poste par lettre
   * @Security("has_role('ROLE_WEBMASTER')")
   */
  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $tarif = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteLettre')->find($id);
    if (null === $tarif) {
      throw new NotFoundHttpException("La tarif ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create(TarifLaposteLettreType::class, $tarif);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($tarif);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Tarif modifié avec succès");
        return $this->redirectToRoute('plateforme_ecommerce_tariflapostelettre_crud');
      }
    }
    return $this->render('PlateformeEcommerceBundle:TarifLaposteLettre:edit.html.twig', array(
          'tarif' => $tarif,
          'form' => $form->createView(),
    ));
  }

  /**
   * Formulaire de suppression d'un tarif de La Poste par lettre
   * @Security("has_role('ROLE_WEBMASTER')")
   */
  public function deleteAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();
    $tarif = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteLettre')->find($id);
    if (null === $tarif) {
      throw new NotFoundHttpException("Le tarif ayant l'identifiant " . $id . " n'existe pas.");
    }
    $form = $this->get('form.factory')->create();
    if ($request->isMethod('POST')) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($tarif);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Tarif supprimé avec succès");
      return $this->redirectToRoute('plateforme_ecommerce_tariflapostelettre_crud');
    }
    return $this->render('PlateformeEcommerceBundle:TarifLaposteLettre:delete.html.twig', array(
          'tarif' => $tarif,
          'form' => $form->createView(),
    ));
  }

  /**
   * Récupération du tarif à partir du pays de destination (passé en post via ajax)
   * @return type
   */
  public function tarifAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $valeurs_recu = $request->request->all();
    // Récupération du tarif en fonction du Pays
    $tarif_livraison_obj = $em->getRepository('PlateformeEcommerceBundle:TarifLaposteLettre')->findOneByPays($valeurs_recu['pays_destination']);
    $tarif_livraison = null;
    // Envoie en France (tout pays ayant un tarif)
    if (isset($tarif_livraison_obj)) {
      $tarif_livraison = $tarif_livraison_obj->getTarif();
    }
    // Envoie à l'international (tout pays n'ayant pas de tarif)
    else{
      $tarif_livraison_obj = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('laposte_lettre_tarif_international');
      $tarif_livraison = $tarif_livraison_obj->getValue();
    }
    $response = array(
      'tarif_livraison' => $tarif_livraison,
    );
    return new JsonResponse($response);
  }

}
