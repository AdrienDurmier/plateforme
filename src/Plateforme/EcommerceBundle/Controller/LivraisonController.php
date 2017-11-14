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
    
    // Récupération du client
    $user = $this->get('security.token_storage')->getToken()->getUser();
    
    // Récupération de l'adresse de la plateforme
    $titre = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('site_name');
    $voie = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_voie');
    $complement = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_complement');
    $code_postal = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_code_postal');
    $commune = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_commune');
    $pays = $em->getRepository('PlateformeCoreBundle:Variable')->findOneByCode('adresse_pays');
    $adresse_plateforme = array(
      'nom' => $titre->getValue(),
      'adresse' => $voie->getValue(),
      'complement' => $complement->getValue(),
      'code_postal' => $code_postal->getValue(),
      'commune' => $commune->getValue(),
      'pays' => $pays->getValue(),
    );
    
    // Récupération des adresses du client
    $adresses = $em->getRepository('PlateformeCoreBundle:Adresse')->findByClient($user);
    $adresses_livraison_possibles = array();
    $adresses_facturation_possibles = array();
    $i=0;foreach ($adresses as $adresse) {
      if ($adresse->getLivraison()) {
        $adresses_livraison_possibles[$i]['id'] = $adresse->getId();
        $adresses_livraison_possibles[$i]['adresse'] = $adresse->getAdresse();
        $adresses_livraison_possibles[$i]['complement'] = $adresse->getComplement();
        $adresses_livraison_possibles[$i]['code_postal'] = $adresse->getCodePostal();
        $adresses_livraison_possibles[$i]['commune'] = $adresse->getCommune();
        $adresses_livraison_possibles[$i]['pays'] = $adresse->getPays();
        $i++;
      }
    }
    $j=0;foreach ($adresses as $adresse) {
      if ($adresse->getFacturation()) {
        $adresses_facturation_possibles[$j]['id'] = $adresse->getId();
        $adresses_facturation_possibles[$j]['adresse'] = $adresse->getAdresse();
        $adresses_facturation_possibles[$j]['complement'] = $adresse->getComplement();
        $adresses_facturation_possibles[$j]['code_postal'] = $adresse->getCodePostal();
        $adresses_facturation_possibles[$j]['commune'] = $adresse->getCommune();
        $adresses_facturation_possibles[$j]['pays'] = $adresse->getPays();
        $j++;
      }
    }
    
    // Récupération du tarif le moins cher pour la livraison lettre La Poste
    
    // Récupération du tarif le moins cher pour la livraison colissimo La Poste
    
    
    return $this->render('PlateformeEcommerceBundle:Tunnel:livraison.html.twig', array(
          'user'                            => $user,
          'adresse_plateforme'              => $adresse_plateforme,
          'adresses_livraison_possibles'    => $adresses_livraison_possibles,
          'adresses_facturation_possibles'  => $adresses_facturation_possibles,
          'countries'                       => Intl::getRegionBundle()->getCountryNames(),
    ));
  }

}
