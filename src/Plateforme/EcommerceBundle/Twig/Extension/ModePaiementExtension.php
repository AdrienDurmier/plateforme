<?php

namespace Plateforme\EcommerceBundle\Twig\Extension;

class ModePaiementExtension extends \Twig_Extension {

  public function getFilters() {
    return array(new \Twig_SimpleFilter('mode_paiement', array($this, 'afficherModePaiement')));
  }

  function afficherModePaiement($mode) {
    switch ($mode) {
      case 'paiement_cheque':
        return 'Chèque';
      case 'paiement_virement':
        return 'Virement bancaire';
      case 'paiement_paypal':
        return 'Paypal';
    }
    return null;
  }

  public function getName() {
    return 'mode_paiement';
  }

}
