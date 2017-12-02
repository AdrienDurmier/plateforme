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
    public function indexAction(Request $request)
    {
      if ($request->isMethod('POST')) {
        $driver = $this->get('lexik_maintenance.driver.factory')->getDriver();
        $valeurs_recu = $request->request->all();
        $message = "";
        if ($valeurs_recu['maintenance_mode']) {
            $message = $driver->getMessageLock($driver->lock());
            $request->getSession()->getFlashBag()->add('warning', "Mode maintenance activé");
        } else {
            $message = $driver->getMessageUnlock($driver->unlock());
            $request->getSession()->getFlashBag()->add('success', "Mode maintenance désactivé");
        }
      }

      return $this->render('PlateformeCoreBundle:Maintenance:index.html.twig');
    }
    
}
