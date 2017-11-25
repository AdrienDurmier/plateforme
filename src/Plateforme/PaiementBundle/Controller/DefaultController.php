<?php

namespace Plateforme\PaiementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlateformePaiementBundle:Default:index.html.twig');
    }
}
