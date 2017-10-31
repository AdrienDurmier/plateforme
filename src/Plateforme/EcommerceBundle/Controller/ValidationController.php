<?php

namespace Plateforme\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ValidationController extends Controller {

  public function validationAction(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $session = $request->getSession();
    if (!$session->has('panier')) {
      return $this->redirectToRoute('plateforme_ecommerce_panier');
    }
    $panier = $session->get('panier');

    return $this->render('PlateformeEcommerceBundle:Validation:validation.html.twig', array(
      'panier'  =>  $panier,
    ));
  }

}
