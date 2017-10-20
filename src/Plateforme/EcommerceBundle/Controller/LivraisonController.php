<?php

namespace Plateforme\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\CoreBundle\Entity\Adresse;
use Plateforme\CoreBundle\Form\AdresseType;

class LivraisonController extends Controller {

  public function livraisonAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $adresse = new Adresse();
    $form = $this->get('form.factory')->create(AdresseType::class, $adresse);

    $user = $this->get('security.token_storage')->getToken()->getUser();
    $adresses = $em->getRepository('PlateformeCoreBundle:Adresse')->findByClient($user);

    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $adresse->setClient($user);
        $em->persist($adresse);
        $em->flush();

        return $this->redirect($this->generateUrl('plateforme_ecommerce_livraison'));
      }
    }

    return $this->render('PlateformeEcommerceBundle:Livraison:livraison.html.twig', array(
          'user' => $user,
          'adresses' => $adresses,
          'form' => $form->createView()
    ));
  }

  /**
   * Suppression d'une adresse
   */
  public function adresseSuppressionAction($id) {
    $em = $this->getDoctrine()->getManager();
    $adresse = $em->getRepository('PlateformeEcommerceBundle:Adresse')->find($id);

    if ($this->get('security.token_storage')->getToken()->getUser() != $adresse->getClient() || !$adresse)
      return $this->redirect($this->generateUrl('plateforme_ecommerce_livraison'));

    $em->remove($adresse);
    $em->flush();

    return $this->redirect($this->generateUrl('plateforme_ecommerce_livraison'));
  }

  public function setLivraisonOnSession() {
    $session = $this->getRequest()->getSession();

    if (!$session->has('adresse'))
      $session->set('adresse', array());
    $adresse = $session->get('adresse');

    if ($this->getRequest()->request->get('livraison') != null && $this->getRequest()->request->get('facturation') != null) {
      $adresse['livraison'] = $this->getRequest()->request->get('livraison');
      $adresse['facturation'] = $this->getRequest()->request->get('facturation');
    }
    else {
      return $this->redirect($this->generateUrl('validation'));
    }

    $session->set('adresse', $adresse);
    return $this->redirect($this->generateUrl('validation'));
  }

}
