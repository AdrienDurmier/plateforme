<?php

namespace Plateforme\EcommerceBundle\Twig\Extension;

class TTCExtension extends \Twig_Extension {

  public function getFilters() {
    return array(new \Twig_SimpleFilter('ttc', array($this, 'calculTTC')));
  }

  function calculTTC($prixHT, $tva) {
    return round($prixHT * $tva->getMultiplicate(), 2);
  }

  public function getName() {
    return 'ttc_extension';
  }

}
