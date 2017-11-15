<?php

namespace Plateforme\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LivraisonRetraitController extends Controller {

  /**
   * Récupération du tarif (est appelé en ajax pour garantir la mise jour du tarif en cas de clic rapide)
   * @return type
   */
  public function tarifAction(Request $request) {
    $response = array(
      'tarif_livraison' => 0,
    );
    return new JsonResponse($response);
  }

}
