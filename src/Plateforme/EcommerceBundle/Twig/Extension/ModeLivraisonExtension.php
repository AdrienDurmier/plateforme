<?php

namespace Plateforme\EcommerceBundle\Twig\Extension;

class ModeLivraisonExtension extends \Twig_Extension {

  public function getFilters() {
    return array(new \Twig_SimpleFilter('mode_livraison', array($this, 'afficherModeLivraison')));
  }

  function afficherModeLivraison($mode) {
    switch ($mode) {
      case 'livraison_retrait':
        return 'Retrait';
      case 'livraison_laposte_lettre':
        return 'Lettre';
      case 'livraison_laposte_colissimo':
        return 'Colissimo';
    }
    return null;
  }

  public function getName() {
    return 'mode_livraison';
  }

}
