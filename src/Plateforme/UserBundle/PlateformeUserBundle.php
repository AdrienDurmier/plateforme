<?php
// src/Plateforme/UserBundle/PlateformeUserBundle.php

namespace Plateforme\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PlateformeUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
