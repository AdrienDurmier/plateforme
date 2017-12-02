<?php
namespace Plateforme\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MaintenanceController extends Controller
{
    /**
     * Mode maintenance
     */
    public function indexAction()
    {
      
      $driver = $this->get('lexik_maintenance.driver.factory')->getDriver();
      
      $message = "";
      if ($action === 'lock') {
          $message = $driver->getMessageLock($driver->lock());
      } else {
          $message = $driver->getMessageUnlock($driver->unlock());
      }

      $this->get('session')->setFlash('maintenance', $message);
      
      return $this->render('PlateformeCoreBundle:Maintenance:index.html.twig');
    }
    
}
