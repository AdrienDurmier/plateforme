<?php
namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Plateforme\CoreBundle\Form\BackOfficeType;

class BackOfficeController extends Controller
{
    /**
     *  Page Accueil du back office
     */
    public function indexAction()
    {
      return $this->render('PlateformeCoreBundle:BackOffice:index.html.twig');
    }
    
    /**
     *  Pages
     */
    public function pagesAction()
    {
      return $this->render('PlateformeCoreBundle:BackOffice:pages.html.twig');
    }
    
    /**
     *  Catalogue
     */
    public function catalogueAction()
    {
      return $this->render('PlateformeCoreBundle:BackOffice:catalogue.html.twig');
    }
    
    /**
     *  Configuration
     */
    public function configurationAction()
    {
      return $this->render('PlateformeCoreBundle:BackOffice:configuration.html.twig');
    }
    
}
