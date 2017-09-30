<?php

namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlateformeCoreBundle:Default:index.html.twig');
    }
}
