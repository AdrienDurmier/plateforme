<?php

namespace Plateforme\EcommerceBundle\Twig\Extension;

class HTExtension extends \Twig_Extension {

  public function getFilters() {
    return array(new \Twig_SimpleFilter('ht', array($this, 'calculHT')));
  }

  function calculHT($prixTTC, $tva) {
    return round($prixTTC / $tva->getMultiplicate(), 2);
  }

  public function getName() {
    return 'ht_extension';
  }

}
