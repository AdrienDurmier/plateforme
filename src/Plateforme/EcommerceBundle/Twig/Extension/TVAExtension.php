<?php

namespace Plateforme\EcommerceBundle\Twig\Extension;

class TVAExtension extends \Twig_Extension {

  public function getFilters() {
    return array(new \Twig_SimpleFilter('tva', array($this, 'calculTVA')));
  }

  function calculTVA($prixHT, $tva) {
    return round($prixHT * ($tva->getValeur()/100),2);
  }

  public function getName() {
    return 'tva_extension';
  }

}
