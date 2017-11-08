<?php

namespace Plateforme\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\CoreBundle\Entity\Adresse;
use Plateforme\CoreBundle\Form\AdresseType;
use Symfony\Component\Intl\Intl;
use Symfony\Component\HttpFoundation\JsonResponse;

class LivraisonController extends Controller {

  public function livraisonAction(Request $request) {
    $em = $this->getDoctrine()->getManager();
    $adresse = new Adresse();

    $user = $this->get('security.token_storage')->getToken()->getUser();
    $adresses = $em->getRepository('PlateformeCoreBundle:Adresse')->findByClient($user);

    $adresse_magasin_titre_obj = $em->getRepository('PlateformeCoreBundle:Adresse')->findByClient($user);
    $adresse_magasin = array(
      'adresse_magasin_titre' => '',
    );

    return $this->render('PlateformeEcommerceBundle:Tunnel:livraison.html.twig', array(
          'user' => $user,
          'adresses' => $adresses,
          'countries' => Intl::getRegionBundle()->getCountryNames(),
    ));
  }

  /**
   * Choix de la livraison
   * L'objectif est d'ajouter le mode de livraison aux variables de sessions adresse_livraison & adresse_facturation
   * @return 
   *  le tarif de la livraison
   *  les adresses de livraison possible
   */
  public function choixAction(Request $request) {
    // Récupération
    $valeurs_recu = $request->request->all();
    // Si l'utilisateur n'a pas fait de choix alors on le renvoie directement vers le formulaire
    if (!isset($valeurs_recu['mode_livraison'])) {
      $this->get('session')->getFlashBag()->add('warning', "Vous devez choisir un mode de livraison");
      return $this->redirect($this->generateUrl('plateforme_ecommerce_tunnel_livraison'));
    }
    $session = $request->getSession();
    // Adresse de livraison
    if (!$session->has('adresse_livraison')) {
      $session->set('adresse_livraison', array());
    }
    $adresse_livraison = $session->get('adresse_livraison');
    // Adresse de facturation
    if (!$session->has('adresse_facturation')) {
      $session->set('adresse_facturation', array());
    }
    $adresse_facturation = $session->get('adresse_facturation');
    $adresse_livraison['mode'] = $valeurs_recu['mode_livraison'];
    $adresse_facturation['mode'] = $valeurs_recu['mode_livraison'];
    // En fonction du mode paiement on ne redirige pas vers les mêmes pages
    $result = null;
    switch ($valeurs_recu['mode_livraison']) {
      // Retrait en magasin
      case "livraison_retrait":
        // Récupération du tarif et des adresses possibles
        $result = $this->modeRetrait();
        $response = array(
          'data' => array(
            'tarif_livraison' => $result['tarif_livraison'],
            'adresses_livraison_possibles' => $result['adresses_livraison_possibles'],
            'adresses_facturation_possibles' => $result['adresses_facturation_possibles']
          )
        );
        break;
      // Livraison par La Poste
      case "livraison_laposte":
        // Récupération du tarif et des adresses possibles
        $result = $this->modeLaPoste();
        $response = array(
          'data' => array(
            'adresses_livraison_possibles' => $result['adresses_livraison_possibles'],
            'adresses_facturation_possibles' => $result['adresses_facturation_possibles']
          )
        );
        break;
    }
    // Enregistrement des sessions
    $session->set('adresse_livraison', $adresse_livraison);
    $session->set('adresse_facturation', $adresse_facturation);
    return new JsonResponse($response);
  }

  /**
   * Fonction renvoyant un tableau contenant pour le mode retrait en magasin
   *  - le tarif de ce mode de livraison
   *  - les adresses de livraison possibles
   *  - les adresses de facturation possibles
   */
  public function modeRetrait() {
    $em = $this->getDoctrine()->getManager();
    $user = $this->get('security.token_storage')->getToken()->getUser();
    // L'adresse de livraison sera automatiquement l'adresse de Micropuces
    $titre = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('site_name');
    $voie = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_voie');
    $complement = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_complement');
    $code_postal = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_code_postal');
    $commune = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_commune');
    $pays = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_pays');
    $adresses_livraison_possibles = array(
      'titre' => $titre->getValue(),
      'adresse' => $voie->getValue(),
      'complement' => $complement->getValue(),
      'code_postal' => $code_postal->getValue(),
      'commune' => $commune->getValue(),
      'pays' => $pays->getValue(),
    );
    // Récupération des adresses de facturation uniquement
    $adresses = $em->getRepository('PlateformeCoreBundle:Adresse')->findByClient($user);
    $adresses_facturation_possibles = array();
    foreach ($adresses as $adresse) {
      if ($adresse->getFacturation()) {
        $adresses_facturation_possibles[$adresse->getId()]['titre'] = $adresse->getTitre();
        $adresses_facturation_possibles[$adresse->getId()]['adresse'] = $adresse->getAdresse();
        $adresses_facturation_possibles[$adresse->getId()]['complement'] = $adresse->getComplement();
        $adresses_facturation_possibles[$adresse->getId()]['code_postal'] = $adresse->getCodePostal();
        $adresses_facturation_possibles[$adresse->getId()]['commune'] = $adresse->getCommune();
        $adresses_facturation_possibles[$adresse->getId()]['pays'] = $adresse->getPays();
      }
    }
    return array(
      'tarif_livraison' => 0,
      'adresses_livraison_possibles' => $adresses_livraison_possibles,
      'adresses_facturation_possibles' => $adresses_facturation_possibles
    );
  }
  
  /**
   * Pour l'envoi par La Poste
   *  - les adresses de livraison possibles
   *  - les adresses de facturation possibles
   * @param pays de destination norme ISO-3361 alpha2
   */
  public function modeLaPoste($pays_destination) {
    $em = $this->getDoctrine()->getManager();
    $user = $this->get('security.token_storage')->getToken()->getUser();
    
    // Récupération des adresses du client
    $adresses = $em->getRepository('PlateformeCoreBundle:Adresse')->findByClient($user);
    $adresses_livraison_possibles = array();
    $adresses_facturation_possibles = array();
    foreach ($adresses as $adresse) {
      if ($adresse->getLivraison()) {
        $adresses_livraison_possibles[$adresse->getId()]['titre'] = $adresse->getTitre();
        $adresses_livraison_possibles[$adresse->getId()]['adresse'] = $adresse->getAdresse();
        $adresses_livraison_possibles[$adresse->getId()]['complement'] = $adresse->getComplement();
        $adresses_livraison_possibles[$adresse->getId()]['code_postal'] = $adresse->getCodePostal();
        $adresses_livraison_possibles[$adresse->getId()]['commune'] = $adresse->getCommune();
        $adresses_livraison_possibles[$adresse->getId()]['pays'] = $adresse->getPays();
      }
      if ($adresse->getFacturation()) {
        $adresses_facturation_possibles[$adresse->getId()]['titre'] = $adresse->getTitre();
        $adresses_facturation_possibles[$adresse->getId()]['adresse'] = $adresse->getAdresse();
        $adresses_facturation_possibles[$adresse->getId()]['complement'] = $adresse->getComplement();
        $adresses_facturation_possibles[$adresse->getId()]['code_postal'] = $adresse->getCodePostal();
        $adresses_facturation_possibles[$adresse->getId()]['commune'] = $adresse->getCommune();
        $adresses_facturation_possibles[$adresse->getId()]['pays'] = $adresse->getPays();
      }
    }
    return array(
      'adresses_livraison_possibles' => $adresses_livraison_possibles,
      'adresses_facturation_possibles' => $adresses_facturation_possibles
    );
  }

}
